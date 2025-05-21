<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewRatingNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $userType;
    public $orderId;
    public $rating;
    public $message;

    public function __construct($userId, $userType, $orderId, $rating)
    {
        $this->userId = $userId;
        $this->userType = $userType;
        $this->orderId = $orderId;
        $this->rating = $rating;
        $this->message = "Customer memberikan rating $rating untuk order #$orderId";
    }

    public function broadcastOn()
    {
        return new Channel('notifications.'.$this->userType.'.'.$this->userId);
    }
}
