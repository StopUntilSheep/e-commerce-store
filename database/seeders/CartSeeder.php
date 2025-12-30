<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'shopper')->get();
        $products = Product::where('is_active', true)->where('quantity', '>', 0)->get();

        foreach ($users as $user) {
            // 50% chance user has items in cart
            if (rand(0, 1)) {
                $cartCount = rand(1, 3);
                
                for ($i = 1; $i <= $cartCount; $i++) {
                    $product = $products->random();
                    $quantity = rand(1, 2);
                    
                    Cart::create([
                        'user_id' => $user->id,
                        'session_id' => null, // User is logged in
                        'product_id' => $product->id,
                        'variant_sku' => $product->variants->isNotEmpty() ? $product->variants->random()->sku : null,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'price_snapshot' => [
                            'original' => $product->price,
                            'updated_at' => now()->subDays(rand(0, 7)),
                        ],
                        'expires_at' => now()->addDays(30),
                        'attributes' => $product->attributes,
                    ]);
                }
            }
        }

        // Add some guest carts
        for ($i = 1; $i <= 5; $i++) {
            $product = $products->random();
            $quantity = rand(1, 2);
            
            Cart::create([
                'user_id' => null,
                'session_id' => Str::random(32),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'price_snapshot' => [
                    'original' => $product->price,
                    'updated_at' => now()->subDays(rand(0, 14)),
                ],
                'expires_at' => now()->addDays(7), // Guest carts expire faster
                'attributes' => $product->attributes,
            ]);
        }
    }
}