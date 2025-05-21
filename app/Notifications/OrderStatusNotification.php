<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, ?string $oldStatus = null)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $order->status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => $this->getMessage(),
            'seller_name' => $this->order->seller->name,
            'total_amount' => $this->order->total_amount,
        ];
    }

    /**
     * Get the appropriate message based on the status change.
     */
    protected function getMessage(): string
    {
        return match ($this->newStatus) {
            'cancelled' => 'Pesanan Anda telah dibatalkan.',
            'pending' => 'Pesanan Anda telah dibuat dan menunggu konfirmasi.',
            'accepted' => 'Pesanan Anda telah diterima oleh penjual.',
            'preparing' => 'Pesanan Anda sedang disiapkan.',
            'ready' => 'Pesanan Anda sudah siap diambil.',
            'picked_up' => 'Pesanan Anda telah diambil oleh kurir.',
            'delivered' => 'Pesanan Anda telah sampai di tujuan.',
            default => 'Status pesanan Anda telah diperbarui menjadi ' . ucfirst($this->newStatus),
        };
    }
} 