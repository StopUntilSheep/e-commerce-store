<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::where('is_active', true)->where('quantity', '>', 0)->get();

        foreach ($orders as $order) {
            // Each order gets 1-4 items
            $itemCount = rand(1, 4);
            
            for ($i = 1; $i <= $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_snapshot' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'sku' => $product->sku,
                        'description' => $product->description,
                        'price' => $product->price,
                        'images' => $product->images->take(2)->map->only(['url', 'alt_text'])->toArray(),
                        'category' => $product->category?->name,
                        'brand' => $product->brand?->name,
                    ],
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'attributes' => $product->attributes,
                ]);
            }
        }
    }
}