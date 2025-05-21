<?php

namespace App\Http\View\Composers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view)
    {
        $notificationCount = 0;
        
        if (Auth::check() && Auth::user()->isMahasiswa()) {
            $notificationCount = Order::where('seller_id', Auth::id())
                ->whereIn('status', ['pending', 'accepted', 'preparing', 'ready'])
                ->with(['customer', 'seller', 'items.food'])
                ->count();
        }
        
        $view->with('notificationCount', $notificationCount);
    }
}
