<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use App\Models\Showcase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isCustomer()) {
            return $this->customerDashboard($request);
        } elseif ($user->isSeller()) {
            return $this->sellerDashboard();
        } elseif ($user->isCourier()) {
            return $this->courierDashboard();
        } elseif ($user->isMahasiswa()) {
            return $this->mahasiswaDashboard($request);
        }

        abort(403, 'Unauthorized action.');
    }

    protected function customerDashboard(Request $request)
    {
        $activeOrders = Order::where('customer_id', auth()->id())
            ->whereIn('status', ['pending', 'accepted', 'preparing', 'ready', 'picked_up'])
            ->with(['seller', 'courier'])
            ->latest()
            ->get();

        $query = Food::where('is_available', true)
            ->where('show_in_other_menu', false) // Exclude items marked for 'Menu Lainnya'
            ->with(['seller', 'ratings'])
            ->withAvg('ratings as average_rating', 'rating');

        // Apply search if search term is provided
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('seller', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $foods = $query->latest()->paginate(12)->withQueryString();

        $showcases = Showcase::where('is_active', true)
            ->with('student')
            ->latest()
            ->get();

        if ($request->ajax()) {
            return view('dashboard.partials.food-list', compact('foods'))->render();
        }

        return view('dashboard.customer', compact('activeOrders', 'foods', 'showcases'));
    }

    protected function sellerDashboard()
    {
        $orders = Order::where('seller_id', auth()->id())
            ->whereIn('status', ['pending', 'accepted', 'preparing', 'ready'])
            ->with(['customer', 'courier'])
            ->latest()
            ->get();

        $foods = Food::where('seller_id', auth()->user()->id)
            ->latest()
            ->get();

        // Get average food rating for the seller
        $averageRating = auth()->user()->receivedFoodReviews()->avg('food_rating');

        return view('dashboard.seller', compact('orders', 'foods', 'averageRating'));
    }

    protected function mahasiswaDashboard(Request $request)
    {
        $user = auth()->user();
        
        // Get mahasiswa's foods
        $foods = Food::where('seller_id', $user->id)
            ->latest()
            ->get();
            
        // Get mahasiswa's pending orders
        $pendingOrdersCount = Order::where('seller_id', $user->id)
            ->whereIn('status', ['pending', 'accepted', 'preparing'])
            ->count();
            
        // Get pending delivery orders count (for the delivery section)
        $pendingDeliveryCount = Order::ready()
            ->whereDoesntHave('seller', function($query) {
                $query->where('role', 'mahasiswa');
            })
            ->count();
            
        return view('dashboard.mahasiswa', [
            'foods' => $foods,
            'pendingOrdersCount' => $pendingOrdersCount,
            'pendingDeliveryCount' => $pendingDeliveryCount
        ]);
    }
    
    /**
     * Get count of ready orders for notification badge
     */
    public function getReadyOrdersCount()
    {
        $user = auth()->user();
        
        if ($user->isMahasiswa()) {
            // For mahasiswa, count all orders where they are the seller and status is pending, accepted, preparing, or ready
            $count = Order::where('seller_id', $user->id)
                ->whereIn('status', ['pending', 'accepted', 'preparing', 'ready'])
                ->with(['customer', 'seller', 'items.food'])
                ->count();
        } else {
            // For other roles, use the existing logic
            $count = Order::ready()
                ->whereDoesntHave('seller', function($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->count();
        }
            
        return response()->json(['count' => $count]);
    }
    
    public function courier2()
    {
        $user = auth()->user();
        
        // Initialize empty collections by default
        $pendingOrders = collect();
        $availableOrders = collect();
        $activeDeliveries = collect();
        
        // Only proceed if we have a valid user
        if (!$user) {
            return view('dashboard.courier2', compact('pendingOrders', 'availableOrders', 'activeDeliveries'));
        }
        
        // Define the relationships to eager load
        $withRelations = [
            'customer' => function($query) {
                $query->select('id', 'name', 'email');
            },
            'seller' => function($query) {
                $query->select('id', 'name', 'email', 'role');
            },
            'items.food' => function($query) {
                $query->select('id', 'name', 'price');
            }
        ];
        
        if ($user->isMahasiswa()) {
            // For mahasiswa, show all orders where they are the seller
            $pendingOrders = Order::where('seller_id', $user->id)
                ->whereIn('status', ['pending', 'accepted', 'preparing'])
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
                
            $availableOrders = Order::where('seller_id', $user->id)
                ->where('status', 'ready')
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
                
            $activeDeliveries = Order::where('seller_id', $user->id)
                ->whereIn('status', ['picked_up', 'on_delivery'])
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
        } else {
            // For regular couriers, show orders not assigned to mahasiswa
            $pendingOrders = Order::where('status', 'pending')
                ->whereNull('courier_id')
                ->whereDoesntHave('seller', function($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
                
            $availableOrders = Order::where('courier_id', $user->id)
                ->where('status', 'accepted')
                ->whereDoesntHave('seller', function($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
                
            $activeDeliveries = Order::where('courier_id', $user->id)
                ->whereIn('status', ['picked_up', 'on_delivery'])
                ->whereDoesntHave('seller', function($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->with($withRelations)
                ->latest()
                ->get()
                ->filter(function($order) {
                    return $order->customer && $order->seller;
                });
        }
        
        return view('dashboard.courier2', [
            'pendingOrders' => $pendingOrders,
            'availableOrders' => $availableOrders,
            'activeDeliveries' => $activeDeliveries
        ]);
    }

    protected function getNotificationCount()
    {
        $user = auth()->user();
        
        if ($user->isMahasiswa()) {
            return Order::where('seller_id', $user->id)
                ->where('status', 'ready')
                ->count();
        }
        
        return 0;
    }
    
    protected function courierDashboard()
    {
        // Orders that need to be picked up from sellers
        $availableOrders = Order::where('courier_id', auth()->id())
            ->whereIn('status', ['accepted', 'preparing'])
            ->whereDoesntHave('seller', function($query) {
                $query->where('role', 'mahasiswa'); // Exclude orders from mahasiswa
            })
            ->with(['customer', 'seller'])
            ->latest()
            ->get();

        // Orders that are being delivered
        $activeDeliveries = Order::where('courier_id', auth()->id())
            ->whereIn('status', ['ready', 'picked_up'])
            ->whereDoesntHave('seller', function($query) {
                $query->where('role', 'mahasiswa'); // Exclude orders from mahasiswa
            })
            ->with(['customer', 'seller'])
            ->latest()
            ->get();

        // Orders waiting to be accepted by courier
        $pendingOrders = Order::whereNull('courier_id')
            ->where('status', 'pending')
            ->whereDoesntHave('seller', function($query) {
                $query->where('role', 'mahasiswa'); // Exclude orders from mahasiswa
            })
            ->with(['customer', 'seller'])
            ->latest()
            ->get();

        // Get average delivery rating for the courier
        $averageRating = auth()->user()->receivedDeliveryReviews()->avg('courier_rating');

        return view('dashboard.courier', compact('availableOrders', 'activeDeliveries', 'pendingOrders', 'averageRating'));
    }
}