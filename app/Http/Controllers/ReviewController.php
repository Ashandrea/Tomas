<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Food;
use App\Notifications\RatingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        $this->authorize('create', [Review::class, $order]);

        if ($order->status !== 'delivered') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'You can only rate delivered orders.');
        }

        if ($order->review()->exists()) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'You have already reviewed this order.');
        }

        // Load the order with its items and food details
        $order->load(['items.food', 'courier']);

        // Check if any food items are missing
        $invalidItems = $order->items->filter(function($item) {
            return !$item->food;
        });

        if ($invalidItems->isNotEmpty()) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Tidak dapat meninjau pesanan ini karena beberapa barang sudah tidak tersedia.');
        }

        return view('reviews.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        Log::info('Review submission attempt', [
            'order_id' => $order->id,
            'request_data' => $request->all()
        ]);

        $this->authorize('create', [Review::class, $order]);

        if ($order->status !== 'delivered') {
            Log::warning('Review submission failed: Order not delivered', [
                'order_id' => $order->id,
                'status' => $order->status
            ]);
            return redirect()->route('orders.show', $order)
                ->with('error', 'You can only rate delivered orders.');
        }

        if ($order->review()->exists()) {
            Log::warning('Review submission failed: Review already exists', [
                'order_id' => $order->id
            ]);
            return redirect()->route('orders.show', $order)
                ->with('error', 'You have already reviewed this order.');
        }

        try {
            $validated = $request->validate([
                'food_ratings' => 'required|array|min:1',
                'food_ratings.*.rating' => 'required|integer|between:1,5',
                'food_ratings.*.comment' => 'nullable|string|max:500',
                'courier_rating' => 'nullable|integer|between:1,5',
                'courier_comment' => 'nullable|string|max:500',
            ]);

            Log::info('Review validation passed', [
                'order_id' => $order->id,
                'validated_data' => $validated
            ]);

            DB::transaction(function () use ($order, $validated) {
                // Handle food ratings
                foreach ($validated['food_ratings'] as $foodId => $ratingData) {
                    $food = Food::findOrFail($foodId);
                    
                    // Ensure the food item belongs to this order
                    if (!$order->items()->where('food_id', $foodId)->exists()) {
                        throw new \Exception('Invalid food item for this order');
                    }

                    // Create review for this food item
                    $review = Review::create([
                        'id' => Str::uuid(),
                        'order_id' => $order->id,
                        'food_id' => $foodId,
                        'customer_id' => auth()->id(),
                        'seller_id' => $food->seller_id,
                    ]);

                    // Create food-specific rating
                    $food->ratings()->create([
                        'review_id' => $review->id,
                        'rating' => $ratingData['rating'],
                        'comment' => $ratingData['comment'] ?? null,
                    ]);

                    // Notify seller
                    if ($food->seller) {
                        $food->seller->notify(new RatingNotification(
                            $order,
                            $ratingData['rating'],
                            'food'
                        ));
                    }
                }

                // Handle courier rating if provided
                if (isset($validated['courier_rating'])) {
                    if (!$order->courier_id) {
                        throw new \Exception('Cannot rate delivery: No courier found for this order.');
                    }

                    $review = Review::create([
                        'id' => Str::uuid(),
                        'order_id' => $order->id,
                        'customer_id' => auth()->id(),
                        'courier_id' => $order->courier_id,
                        'courier_rating' => $validated['courier_rating'],
                        'courier_comment' => $validated['courier_comment'] ?? null,
                    ]);

                    // Notify courier
                    if ($order->courier) {
                        $order->courier->notify(new RatingNotification(
                            $order,
                            $validated['courier_rating'],
                            'delivery'
                        ));
                    }
                }
            });

            Log::info('Review submission completed successfully', [
                'order_id' => $order->id
            ]);

            return redirect()->route('orders.history')
                ->with('success', 'Umpan balik berhasil dikirim.');

        } catch (\Exception $e) {
            Log::error('Review submission failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to submit review: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'food_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'food_comment' => ['nullable', 'string', 'max:500'],
            'courier_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'courier_comment' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            DB::transaction(function () use ($review, $validated) {
                $review->update($validated);

                // Update seller's average rating
                if ($review->seller) {
                    $sellerAvgRating = Review::where('seller_id', $review->seller_id)
                        ->avg('food_rating');
                    $review->seller->update(['average_rating' => $sellerAvgRating]);
                }

                // Update courier's average rating
                if ($review->courier) {
                    $courierAvgRating = Review::where('courier_id', $review->courier_id)
                        ->avg('courier_rating');
                    $review->courier->update(['average_rating' => $courierAvgRating]);
                }
            });

            return redirect()->route('orders.history')
                ->with('success', 'Umpan balik berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update review: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
