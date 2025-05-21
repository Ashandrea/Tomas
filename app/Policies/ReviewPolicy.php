<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Models\Order;

class ReviewPolicy
{
    public function create(User $user, Order $order)
    {
        return $user->isCustomer() &&
               $user->id === $order->customer_id &&
               $order->status === 'delivered' &&
               !$order->review()->exists();
    }

    public function update(User $user, Review $review)
    {
        return $user->isCustomer() && $user->id === $review->customer_id;
    }

    public function delete(User $user, Review $review)
    {
        return $user->isCustomer() && $user->id === $review->customer_id;
    }
} 