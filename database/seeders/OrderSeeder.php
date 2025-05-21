<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get some existing users
        $customers = User::where('role', 'customer')->get();
        $sellers = User::where('role', 'seller')->get();
        $couriers = User::where('role', 'courier')->get();

        // Create some pending orders
        foreach ($customers as $customer) {
            Order::factory(2)
                ->pending()
                ->create([
                    'customer_id' => $customer->id,
                    'seller_id' => $sellers->random()->id,
                ]);
        }

        // Create some delivered orders
        foreach ($customers as $customer) {
            Order::factory(3)
                ->delivered()
                ->create([
                    'customer_id' => $customer->id,
                    'seller_id' => $sellers->random()->id,
                    'courier_id' => $couriers->random()->id,
                ]);
        }

        // Create random orders in various states
        Order::factory(10)->create([
            'customer_id' => fn() => $customers->random()->id,
            'seller_id' => fn() => $sellers->random()->id,
            'courier_id' => fn() => $couriers->random()->id,
        ]);
    }
} 