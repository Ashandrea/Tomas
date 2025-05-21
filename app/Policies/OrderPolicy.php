<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        return $user->isMahasiswa() ||
               $user->id === $order->customer_id ||
               $user->id === $order->seller_id ||
               $user->id === $order->courier_id;
    }

    public function create(User $user)
    {
        return $user->isCustomer();
    }

    public function update(User $user, Order $order)
    {
        return $user->id === $order->customer_id ||
               $user->id === $order->seller_id ||
               $user->id === $order->courier_id;
    }

    public function review(User $user, Order $order)
    {
        return $user->isCustomer() &&
               $user->id === $order->customer_id &&
               $order->status === 'delivered' &&
               !$order->review;
    }

    public function updateStatus(User $user, Order $order)
    {
        // Seller can update status for their own orders
        if (($user->isSeller() || $user->isMahasiswa()) && $order->seller_id === $user->id) {
            return true;
        }

        // Courier can update status for orders they are assigned to
        if ($user->isCourier() && $order->courier_id === $user->id) {
            return true;
        }

        // Courier can accept pending orders
        if ($user->isCourier() && $order->status === 'pending' && $order->courier_id === null) {
            return true;
        }

        return false;
    }
} 