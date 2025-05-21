<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $customer = User::factory()->customer()->create();
        $seller = User::factory()->seller()->create();
        $courier = User::factory()->courier()->create();

        return [
            'id' => Str::uuid(),
            'status' => fake()->randomElement(['pending', 'accepted', 'preparing', 'ready', 'picked_up', 'delivered', 'cancelled']),
            'delivery_location' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
            'total_amount' => fake()->randomFloat(2, 10000, 500000),
            'estimated_delivery_time' => fake()->dateTimeBetween('now', '+2 hours'),
            'customer_id' => $customer->id,
            'seller_id' => $seller->id,
            'courier_id' => $courier->id,
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'courier_id' => null,
            'estimated_delivery_time' => null,
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
        ]);
    }

    public function withExistingUsers(User $customer, User $seller, ?User $courier = null): static
    {
        return $this->state(fn (array $attributes) => [
            'customer_id' => $customer->id,
            'seller_id' => $seller->id,
            'courier_id' => $courier?->id,
        ]);
    }
}
