<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Review;
use App\Notifications\RatingNotification;
use App\Notifications\CourierAssignedNotification;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use AuthorizesRequests;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = auth()->user();
        $orders = Order::query();

        if ($user->isCustomer()) {
            $orders->where('customer_id', $user->id);
        } elseif ($user->isSeller()) {
            $orders->where('seller_id', $user->id);
        } elseif ($user->isCourier()) {
            $orders->where('courier_id', $user->id);
        }

        $orders = $orders->with(['customer', 'seller', 'courier', 'items.food'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
    
    /**
     * Display a listing of the mahasiswa's orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function mahasiswa()
    {
        $user = auth()->user();
        
        // Get orders where the current user is the seller
        $orders = Order::where('seller_id', $user->id)
            ->with(['customer', 'courier', 'items.food'])
            ->latest()
            ->get();
            
        return view('orders.mahasiswa', compact('orders'));
    }
    
    public function create2(Request $request, $foodId = null)
    {
        // Handle cart data from URL
        $cartItems = [];
        if ($request->has('cart')) {
            $cartData = explode(',', $request->cart);
            foreach ($cartData as $item) {
                list($id, $quantity) = explode(':', $item);
                $cartItems[$id] = (int)$quantity;
            }
        }

        if ($foodId) {
            $food = Food::findOrFail($foodId);
            if (!$food->is_available) {
                return redirect()->route('dashboard')
                    ->with('error', 'Maaf, item ini tidak tersedia lagi.');
            }
            // If a food item is selected, only show that item grouped by seller
            $foods = collect([$food->seller_id => collect([$food])]);
            $cartItems[$food->id] = 1;
        } else {
            // Get all food items that are in the cart
            $foods = Food::where('is_available', true)
                ->when(!empty($cartItems), function ($query) use ($cartItems) {
                    $query->whereIn('id', array_keys($cartItems));
                })
                ->with('seller')
                ->get()
                ->groupBy('seller_id');
        }

        return view('orders.create2', compact('foods', 'cartItems'));
    }
    
    public function create(Request $request, $foodId = null)
    {
        // Handle cart data from URL
        $cartItems = [];
        if ($request->has('cart')) {
            $cartData = explode(',', $request->cart);
            foreach ($cartData as $item) {
                list($id, $quantity) = explode(':', $item);
                $cartItems[$id] = (int)$quantity;
            }
        }

        if ($foodId) {
            $food = Food::findOrFail($foodId);
            if (!$food->is_available) {
                return redirect()->route('dashboard')
                    ->with('error', 'Maaf, item ini tidak tersedia lagi.');
            }
            // If a food item is selected, only show that item grouped by seller
            $foods = collect([$food->seller_id => collect([$food])]);
            $cartItems[$food->id] = 1;
        } else {
            // Get all food items that are in the cart
            $foods = Food::where('is_available', true)
                ->when(!empty($cartItems), function ($query) use ($cartItems) {
                    $query->whereIn('id', array_keys($cartItems));
                })
                ->with('seller')
                ->get()
                ->groupBy('seller_id');
        }

        return view('orders.create', compact('foods', 'cartItems'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'seller_id' => ['required', 'exists:users,id'],
                'items' => ['required', 'array', 'min:1'],
                'items.*.food_id' => ['required', 'exists:foods,id'],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
                'items.*.notes' => ['nullable', 'string'],
                'delivery_location' => ['required', 'string'],
                'notes' => ['nullable', 'string'],
                'from_create2' => ['sometimes', 'boolean'],
            ]);

            DB::beginTransaction();

            // Filter out items with quantity 0
            $items = collect($validated['items'])->filter(function ($item) {
                return isset($item['quantity']) && $item['quantity'] > 0;
            });

            if ($items->isEmpty()) {
                return back()->withErrors(['items' => 'At least one item must be selected with quantity greater than 0.']);
            }

            // Check if this is an order from /lainnya page (all items have show_in_other_menu = true)
            $isFromLainnya = true;
            $foodIds = collect($items)->pluck('food_id');
            $foods = Food::whereIn('id', $foodIds)->get();
            
            foreach ($foods as $food) {
                if (!$food->show_in_other_menu) {
                    $isFromLainnya = false;
                    break;
                }
            }

            // Create the order
            $order = new Order([
                'id' => Str::uuid(),
                'customer_id' => auth()->user()->id, 
                'seller_id' => $validated['seller_id'],
                'delivery_location' => $validated['delivery_location'],
                'notes' => $validated['notes'],
                'status' => $isFromLainnya ? Order::STATUS_PREPARING : Order::STATUS_PENDING,
                'courier_id' => $isFromLainnya ? $validated['seller_id'] : null
            ]);

            // Calculate total amount
            $totalAmount = 0;
            
            foreach ($items as $item) {
                $food = Food::where('id', $item['food_id'])->firstOrFail();
                $totalAmount += $food->price * $item['quantity'];
            }

            // Get delivery fee from the request or default to 5000
            $deliveryFee = $request->input('delivery_fee', 5000);
            
            $order->total_amount = $totalAmount;
            $order->delivery_fee = $deliveryFee;
            $order->save();

            // Create order items
            foreach ($items as $item) {
                $food = Food::where('id', $item['food_id'])->firstOrFail();
                $order->items()->create([
                    'id' => Str::uuid(),
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'price_at_time' => $food->price,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            // Clear the cart from localStorage using JavaScript
            $redirectRoute = $request->has('from_create2') ? 'orders.show2' : 'orders.show';
            return redirect()->route($redirectRoute, $order)
                ->with('success', 'Pesanan berhasil dibuat.')
                ->with('clearCart', true);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::error('Order validation failed: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            \Log::error('Order creation failed - Model not found: ' . $e->getMessage());
            return back()->withErrors(['error' => 'One or more selected items are no longer available.'])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to place order. Please try again.'])->withInput();
        }
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['customer', 'seller', 'courier', 'items.food']);
        
        // Calculate subtotal
        $subtotal = $order->items->sum(function($item) {
            return $item->price_at_time * $item->quantity;
        });
        
        return view('orders.show', [
            'order' => $order,
            'subtotal' => $subtotal
        ]);
    }
    
    public function show2(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['customer', 'seller', 'courier', 'items.food']);
        
        // Calculate subtotal
        $subtotal = $order->items->sum(function($item) {
            return $item->price_at_time * $item->quantity;
        });
        
        return view('orders.show2', [
            'order' => $order,
            'subtotal' => $subtotal
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,preparing,ready,picked_up,delivered',
            'courier_id' => 'nullable|exists:users,id'
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Send notification to customer when courier accepts order
        if ($validated['status'] === 'accepted' && $validated['courier_id']) {
            $courier = auth()->user();
            $order->customer->notify(new CourierAssignedNotification($order, $courier));
        }

        if (auth()->user()->isCourier()) {
            return redirect()->route('orders.status', $order);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function status(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['customer', 'seller', 'courier', 'items.food']);
        return view('orders.status', compact('order'));
    }

    public function track(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['customer', 'seller', 'courier', 'items.food']);
        return view('orders.track', compact('order'));
    }

    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        $allowedStatuses = ['pending', 'accepted'];
        if (!in_array($order->status, $allowedStatuses)) {
            return back()->with('error', 'Hanya pesanan dengan status menunggu atau diterima yang dapat dibatalkan.');
        }

        $previousStatus = $order->status;
        $order->update(['status' => 'cancelled']);
        $this->notificationService->notifyOrderStatusChange($order, $previousStatus, 'cancelled');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function history()
    {
        $user = auth()->user();
        $orders = Order::query()
            ->with(['customer', 'seller', 'courier', 'items.food', 'reviews.foodRatings']);

        if ($user->role === 'customer') {
            $orders->where('customer_id', $user->id);
        } elseif ($user->role === 'seller') {
            $orders->where('seller_id', $user->id);
        } elseif ($user->role === 'courier') {
            $orders->where('courier_id', $user->id);
        }

        $orders = $orders->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('orders.history', compact('orders'));
    }

    public function rate(Order $order, Request $request)
    {
        $this->authorize('update', $order);

        if ($order->status !== 'delivered') {
            return back()->with('error', 'You can only rate delivered orders.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $order->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Terima kasih atas umpan balik Anda!');
    }

    public function rateModal($orderId)
    {
        // Fetch the order details if needed
        $order = Order::findOrFail($orderId);

        // Return a view for the modal with 5-star rating
        return response()->json([
            'html' => view('orders.rate-modal', compact('order'))->render()
        ]);
    }

    /**
     * Show the rating page for a specific order.
     */
    public function showRatingPage(Order $order)
    {
        $this->authorize('review', $order);

        if ($order->status !== 'delivered') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'You can only rate delivered orders.');
        }

        return view('orders.rating', compact('order'));
    }

    /**
     * Submit a rating for an order.
     */
    public function submitRating(Request $request, Order $order)
    {
        $this->authorize('review', $order);

        if ($order->status !== 'delivered') {
            return response()->json([
                'message' => 'You can only rate delivered orders.'
            ], 422);
        }

        $validated = $request->validate([
            'food_ratings' => 'required|array|min:1',
            'food_ratings.*.rating' => 'required|integer|between:1,5',
            'food_ratings.*.comment' => 'nullable|string|max:500',
            'courier_rating' => 'nullable|integer|between:1,5',
            'courier_comment' => 'nullable|string|max:500',
        ]);

        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Rating submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Redirect to the rating page for a specific order.
     *
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRatingPage($orderId)
    {
        // Redirect to a new page for rating
        return redirect()->route('rating.page', ['order' => $orderId]);
    }

    public function refreshFoods()
    {
        $foods = Food::with(['seller', 'ratings'])
            ->withAvg('ratings as average_rating', 'rating')
            ->where('is_available', true)
            ->latest()
            ->get();
        return view('dashboard.partials.foods', compact('foods'))->render();
    }
}