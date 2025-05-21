<?php

namespace App\Http\View\Composers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NavigationComposer
{
    public function compose(View $view)
    {
        $pendingDeliveryCount = 0;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->isMahasiswa()) {
                // Count orders that are ready for mahasiswa (their own orders)
                $pendingDeliveryCount = Order::where('seller_id', $user->id)
                    ->where('status', 'ready')
                    ->count();
            } elseif ($user->isCourier()) {
                // Count orders that are ready for courier (not assigned to mahasiswa)
                $pendingDeliveryCount = Order::where('status', 'ready')
                    ->whereDoesntHave('seller', function($query) {
                        $query->where('role', 'mahasiswa');
                    })
                    ->count();
            }
        }
        
        $view->with('pendingDeliveryCount', $pendingDeliveryCount);
    }
}
