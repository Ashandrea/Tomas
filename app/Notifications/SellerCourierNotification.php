<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class SellerCourierNotification extends Notification
{
    use Queueable;

    public $orderDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Notification')
            ->line('You have a new order.')
            ->line('Order ID: ' . $this->orderDetails['id'])
            ->line('Customer: ' . $this->orderDetails['customer_name'])
            ->action('View Order', url('/orders/' . $this->orderDetails['id']))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->orderDetails['id'],
            'customer_name' => $this->orderDetails['customer_name'],
            'message' => "Order #{$this->orderDetails['id']} status berubah dari {$this->orderDetails['old_status']} menjadi {$this->orderDetails['new_status']}",
            'old_status' => $this->orderDetails['old_status'],
            'new_status' => $this->orderDetails['new_status'],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->orderDetails['id'],
            'customer_name' => $this->orderDetails['customer_name'],
            'old_status' => $this->orderDetails['old_status'],
            'new_status' => $this->orderDetails['new_status'],
        ];
    }
}
