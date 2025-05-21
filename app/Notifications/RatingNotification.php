<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class RatingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $rating;
    protected $type;

    public function __construct($order, $rating, $type)
    {
        $this->order = $order;
        $this->rating = $rating;
        $this->type = $type;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subject = $this->type === 'food' ? 'Food Rating Received' : 'Delivery Rating Received';
        $message = $this->type === 'food' 
            ? "Customer gave a {$this->rating}-star rating for the food in order #{$this->order->id}"
            : "Customer gave a {$this->rating}-star rating for the delivery of order #{$this->order->id}";

        return (new MailMessage)
            ->subject($subject)
            ->line($message)
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'rating' => $this->rating,
            'type' => $this->type,
            'message' => $this->type === 'food'
                ? "Customer gave a {$this->rating}-star rating for the food in order #{$this->order->id}"
                : "Customer gave a {$this->rating}-star rating for the delivery of order #{$this->order->id}"
        ];
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'rating' => $this->rating,
            'type' => $this->type
        ];
    }
}
