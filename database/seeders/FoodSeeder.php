<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all sellers
        $sellers = User::where('role', 'seller')->get();

        // Food categories with items
        $foodCategories = [
            'Nasi' => [
                [
                    'name' => 'Nasi Goreng Spesial',
                    'description' => 'Nasi goreng dengan telur, ayam, udang, dan sayuran segar',
                    'price' => 25000,
                ],
                [
                    'name' => 'Nasi Uduk',
                    'description' => 'Nasi kukus yang dimasak dengan santan kelapa dan rempah-rempah',
                    'price' => 15000,
                ],
                [
                    'name' => 'Nasi Kuning',
                    'description' => 'Nasi kuning lengkap dengan lauk pauk tradisional',
                    'price' => 20000,
                ],
            ],
            'Mie' => [
                [
                    'name' => 'Mie Goreng Jawa',
                    'description' => 'Mie goreng dengan bumbu Jawa dan sayuran segar',
                    'price' => 22000,
                ],
                [
                    'name' => 'Mie Ayam Spesial',
                    'description' => 'Mie ayam dengan topping ayam cincang dan pangsit',
                    'price' => 25000,
                ],
                [
                    'name' => 'Mie Aceh',
                    'description' => 'Mie goreng khas Aceh dengan bumbu rempah',
                    'price' => 28000,
                ],
            ],
            'Ayam' => [
                [
                    'name' => 'Ayam Goreng Kremes',
                    'description' => 'Ayam goreng dengan taburan kremes renyah',
                    'price' => 30000,
                ],
                [
                    'name' => 'Ayam Bakar Madu',
                    'description' => 'Ayam bakar dengan olesan madu special',
                    'price' => 32000,
                ],
                [
                    'name' => 'Ayam Geprek',
                    'description' => 'Ayam geprek dengan sambal pedas level 1-5',
                    'price' => 25000,
                ],
            ],
            'Soto' => [
                [
                    'name' => 'Soto Ayam',
                    'description' => 'Soto ayam dengan kuah bening dan bumbu rempah',
                    'price' => 20000,
                ],
                [
                    'name' => 'Soto Betawi',
                    'description' => 'Soto khas Betawi dengan kuah santan',
                    'price' => 25000,
                ],
                [
                    'name' => 'Soto Madura',
                    'description' => 'Soto khas Madura dengan daging sapi',
                    'price' => 28000,
                ],
            ],
            'Minuman' => [
                [
                    'name' => 'Es Teh Manis',
                    'description' => 'Teh manis dingin yang menyegarkan',
                    'price' => 5000,
                ],
                [
                    'name' => 'Es Jeruk',
                    'description' => 'Jeruk peras segar dengan es',
                    'price' => 7000,
                ],
                [
                    'name' => 'Es Campur',
                    'description' => 'Es campur dengan berbagai macam isian',
                    'price' => 15000,
                ],
            ],
        ];

        // Create food items for each seller
        foreach ($sellers as $seller) {
            // Each seller gets a random selection of items from each category
            foreach ($foodCategories as $category => $items) {
                // Get 1-3 random items from each category
                $selectedItems = collect($items)->random(rand(1, 3));
                
                foreach ($selectedItems as $item) {
                    Food::create([
                        'id' => Str::uuid(),
                        'seller_id' => $seller->id,
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'is_available' => true,
                        'image' => null, // You can add default images later if needed
                    ]);
                }
            }
        }
    }
}
