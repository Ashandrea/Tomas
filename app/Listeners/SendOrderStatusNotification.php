<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Notifications\SellerCourierNotification;

class SendOrderStatusNotification
{
    public function handle(OrderStatusChanged $event)
    {
        // Notify the seller
        if ($event->order->seller) {
            $event->order->seller->notify(new SellerCourierNotification([
                'id' => $event->order->id,
                'customer_name' => $event->order->customer->name,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus
            ]));
        }

        // Notify the courier if assigned
        if ($event->order->courier) {
            $event->order->courier->notify(new SellerCourierNotification([
                'id' => $event->order->id,
                'customer_name' => $event->order->customer->name,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus
            ]));
        }
    }
}
