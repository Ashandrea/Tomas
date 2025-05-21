<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourierAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $courier;

    public function __construct(Order $order, User $courier)
    {
        $this->order = $order;
        $this->courier = $courier;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'courier_id' => $this->courier->id,
            'courier_name' => $this->courier->name,
            'message' => "Courier {$this->courier->name} has accepted your order #{$this->order->id}",
            'type' => 'courier_assigned'
        ];
    }
} 