<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Store Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Shopper users
        $shoppers = [
            ['name' => 'John Smith', 'email' => 'john.smith@example.com'],
            ['name' => 'Emma Johnson', 'email' => 'emma.j@example.com'],
            ['name' => 'Michael Brown', 'email' => 'michael.b@example.com'],
            ['name' => 'Sarah Davis', 'email' => 'sarah.d@example.com'],
            ['name' => 'Robert Wilson', 'email' => 'robert.w@example.com'],
            ['name' => 'Lisa Miller', 'email' => 'lisa.m@example.com'],
            ['name' => 'David Taylor', 'email' => 'david.t@example.com'],
            ['name' => 'Jennifer Lee', 'email' => 'jennifer.l@example.com'],
        ];

        foreach ($shoppers as $shopper) {
            User::create([
                'name' => $shopper['name'],
                'email' => $shopper['email'],
                'password' => Hash::make('password'),
                'role' => 'shopper',
                'email_verified_at' => now()->subDays(rand(1, 100)),
            ]);
        }
    }
}