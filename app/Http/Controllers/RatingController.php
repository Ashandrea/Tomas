<?php

namespace App\Http\Controllers;

use App\Events\NewRatingNotification;
use App\Models\Order;
use App\Models\Food;
use App\Models\Review;
use App\Notifications\RatingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan hanya customer yang bisa memberikan rating
        if (auth()->user()->id !== $order->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.rating', compact('order'));
    }

    public function submitRating(Request $request, Order $order)
    {
        // Pastikan hanya customer yang bisa memberikan rating
        if (auth()->user()->id !== $order->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $request->validate([
            'food_ratings' => 'required|array|min:1',
            'food_ratings.*.rating' => 'required|integer|between:1,5',
            'food_ratings.*.comment' => 'nullable|string|max:255',
            'courier_rating' => 'nullable|integer|between:1,5',
            'courier_comment' => 'nullable|string|max:255',
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Simpan rating untuk setiap makanan
            foreach ($request->food_ratings as $foodId => $ratingData) {
                $food = Food::findOrFail($foodId);
                
                // Pastikan makanan tersebut termasuk dalam pesanan ini
                if (!$order->items()->where('food_id', $foodId)->exists()) {
                    throw new \Exception('Invalid food item for this order');
                }

                // Buat review untuk makanan ini
                $review = Review::create([
                    'order_id' => $order->id,
                    'food_id' => $foodId,
                    'customer_id' => auth()->id(),
                    'seller_id' => $food->seller_id,
                    'courier_id' => $order->courier_id,
                ]);

                // Simpan rating spesifik untuk makanan
                $food->ratings()->create([
                    'review_id' => $review->id,
                    'rating' => $ratingData['rating'],
                    'comment' => $ratingData['comment'] ?? null,
                ]);

                // Kirim notifikasi ke penjual
                $food->seller->notify(new RatingNotification(
                    $order,
                    $ratingData['rating'],
                    'food'
                ));
                
                event(new NewRatingNotification(
                    $food->seller_id,
                    'food',
                    $order->id,
                    $ratingData['rating']
                ));
            }

            // Jika ada kurir dan rating kurir
            if ($order->courier_id && $request->has('courier_rating')) {
                $review = Review::create([
                    'order_id' => $order->id,
                    'customer_id' => auth()->id(),
                    'courier_id' => $order->courier_id,
                    'courier_rating' => $request->courier_rating,
                    'courier_comment' => $request->courier_comment,
                ]);

                // Kirim notifikasi ke kurir
                $order->courier->notify(new RatingNotification(
                    $order,
                    $request->courier_rating,
                    'delivery'
                ));

                event(new NewRatingNotification(
                    $order->courier_id,
                    'delivery',
                    $order->id,
                    $request->courier_rating
                ));
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rating berhasil dikirim']);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Rating submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}