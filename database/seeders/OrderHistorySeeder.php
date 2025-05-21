<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderHistorySeeder extends Seeder
{
    public function run(): void
    {
        // Get users for each role
        $customers = User::where('role', User::ROLE_CUSTOMER)->get();
        $sellers = User::where('role', User::ROLE_SELLER)->get();
        $couriers = User::where('role', User::ROLE_COURIER)->get();

        // Create orders with different statuses and dates
        foreach ($customers as $customer) {
            // Generate 5-10 orders per customer
            $numberOfOrders = rand(5, 10);
            
            for ($i = 0; $i < $numberOfOrders; $i++) {
                $seller = $sellers->random();
                $courier = $couriers->random();
                
                // Get random food items from the seller
                $foods = Food::where('seller_id', $seller->id)
                    ->inRandomOrder()
                    ->take(rand(1, 5))
                    ->get();
                
                if ($foods->isEmpty()) {
                    continue;
                }

                // Calculate total amount
                $totalAmount = $foods->sum('price');

                // Create order with random past date
                $createdAt = Carbon::now()->subDays(rand(1, 30));
                
                // Determine random status
                $statuses = [
                    Order::STATUS_DELIVERED => 60,    // 60% chance
                    Order::STATUS_CANCELLED => 20,    // 20% chance
                    Order::STATUS_PREPARING => 10,    // 10% chance
                    Order::STATUS_ON_DELIVERY => 10   // 10% chance
                ];
                
                $status = $this->getRandomWeightedStatus($statuses);

                // Create the order
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'seller_id' => $seller->id,
                    'courier_id' => $courier->id,
                    'status' => $status,
                    'delivery_location' => 'Jl. Contoh No. ' . rand(1, 100) . ', Kota ' . ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta'][rand(0, 3)],
                    'notes' => ['Tolong dibungkus rapi', 'Jangan lupa sambel', 'Mohon dipastikan makanan masih hangat', null][rand(0, 3)],
                    'total_amount' => $totalAmount,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ]);

                // Add timestamps based on status
                $timestamps = $this->generateTimestamps($createdAt, $status);
                $order->update($timestamps);

                // Create order items
                foreach ($foods as $food) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'food_id' => $food->id,
                        'quantity' => rand(1, 3),
                        'price_at_time' => $food->price,
                        'notes' => null
                    ]);
                }
            }
        }
    }

    private function getRandomWeightedStatus(array $statuses): string
    {
        $rand = rand(1, 100);
        $sum = 0;
        
        foreach ($statuses as $status => $weight) {
            $sum += $weight;
            if ($rand <= $sum) {
                return $status;
            }
        }
        
        return Order::STATUS_DELIVERED;
    }

    private function generateTimestamps(Carbon $createdAt, string $status): array
    {
        $timestamps = [
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];

        if (in_array($status, [Order::STATUS_CANCELLED, Order::STATUS_DELIVERED, Order::STATUS_PREPARING, Order::STATUS_ON_DELIVERY])) {
            $timestamps['courier_assigned_at'] = $createdAt->copy()->addMinutes(rand(5, 15));
            
            if ($status === Order::STATUS_CANCELLED) {
                $timestamps['cancelled_at'] = $createdAt->copy()->addMinutes(rand(16, 30));
            } else {
                $timestamps['food_picked_at'] = $createdAt->copy()->addMinutes(rand(16, 30));
                
                if (in_array($status, [Order::STATUS_DELIVERED])) {
                    $timestamps['actual_delivery_time'] = $createdAt->copy()->addMinutes(rand(31, 60));
                }
            }
        }

        return $timestamps;
    }
} 