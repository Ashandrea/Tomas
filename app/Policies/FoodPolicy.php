<?php

namespace App\Policies;

use App\Models\Food;
use App\Models\User;

class FoodPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Food $food)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isSeller();
    }

    public function update(User $user, Food $food)
    {
        // Allow sellers to update their own food items
        if ($user->isSeller() && $user->id === $food->seller_id) {
            return true;
        }
        
        // Allow students to toggle food availability for their own items
        if ($user->isMahasiswa() && $user->id === $food->seller_id) {
            return true;
        }
        
        return false;
    }

    public function delete(User $user, Food $food)
    {
        // Allow sellers and mahasiswa to delete their own food items
        return ($user->isSeller() || $user->isMahasiswa()) && $user->id === $food->seller_id;
    }
} 