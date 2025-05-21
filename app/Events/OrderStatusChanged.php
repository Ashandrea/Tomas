<?php

namespace App\Events;

use App\Models\Order;
use App\Notifications\SellerCourierNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class OrderStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function broadcastOn()
    {
        $channels = [
            new PrivateChannel('orders.' . $this->order->id),
            new PrivateChannel('users.' . $this->order->customer_id),
            new PrivateChannel('users.' . $this->order->seller_id),
        ];

        if ($this->order->courier_id) {
            $channels[] = new PrivateChannel('users.' . $this->order->courier_id);
        }

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Order #{$this->order->id} status berubah dari {$this->oldStatus} menjadi {$this->newStatus}",
        ];
    }
}