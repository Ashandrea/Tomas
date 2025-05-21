<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo users for each role
        User::factory()->create([
            'name' => 'Demo Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'Demo Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);

        User::factory()->create([
            'name' => 'Demo Courier',
            'email' => 'courier@example.com',
            'password' => Hash::make('password'),
            'role' => 'courier',
            'courier_status' => 'available',
        ]);

        User::factory()->create([
            'name' => 'Demo Mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Create additional random users
        User::factory(5)->create(['role' => 'customer']);
        User::factory(3)->create(['role' => 'seller']);
        User::factory(3)->courier()->create();
    }
}