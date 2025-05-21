<?php

namespace App\Services;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Notifications\OrderStatusNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function notifyOrderStatusChange(Order $order, string $oldStatus, string $newStatus): void
    {
        // Notify customer
        if ($order->customer) {
            $order->customer->notify(new OrderStatusNotification($order, $oldStatus));
        }

        // Notify seller
        if ($order->seller) {
            $order->seller->notify(new OrderStatusNotification($order, $oldStatus));
        }

        // Notify courier
        if ($order->courier) {
            $order->courier->notify(new OrderStatusNotification($order, $oldStatus));
        }

        // Dispatch event for real-time updates
        Event::dispatch(new OrderStatusChanged($order, $oldStatus, $newStatus));
    }

    protected function getStatusChangeMessage(Order $order, string $oldStatus, string $newStatus): string
    {
        $orderId = $order->id;
        $userName = auth()->user()->name;

        return match($newStatus) {
            'accepted' => "Pesanan #{$orderId} telah diterima oleh {$userName}",
            'preparing' => "Pesanan #{$orderId} sedang disiapkan oleh {$userName}",
            'ready' => "Pesanan #{$orderId} siap diambil",
            'picked_up' => "Pesanan #{$orderId} telah diambil oleh {$userName}",
            'delivered' => "Pesanan #{$orderId} telah sampai di {$userName}",
            'cancelled' => "Pesanan #{$orderId} telah dibatalkan oleh {$userName}",
            default => "Order #{$orderId} status berubah dari {$oldStatus} menjadi {$newStatus}",
        };
    }

    public function sendNotification(User $user, string $type, string $message, array $data = []): void
    {
        // Create a custom notification class on the fly
        $notification = new class($type, $message, $data) extends OrderStatusNotification {
            private $notificationType;
            private $notificationMessage;
            private $notificationData;

            public function __construct($type, $message, $data)
            {
                $this->notificationType = $type;
                $this->notificationMessage = $message;
                $this->notificationData = $data;
            }

            public function toArray($notifiable): array
            {
                return array_merge($this->notificationData, [
                    'type' => $this->notificationType,
                    'message' => $this->notificationMessage,
                ]);
            }
        };

        $user->notify($notification);
    }
}