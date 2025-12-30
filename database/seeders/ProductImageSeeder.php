<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            // Add 2-4 images per product
            $imageCount = rand(2, 4);
            
            for ($i = 1; $i <= $imageCount; $i++) {
                $isPrimary = $i === 1;
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => "products/{$product->id}/image{$i}.jpg",
                    'url' => "https://example.com/storage/products/{$product->id}/image{$i}.jpg",
                    'thumbnail_url' => "https://example.com/storage/products/{$product->id}/thumb{$i}.jpg",
                    'is_primary' => $isPrimary,
                    'alt_text' => "{$product->name} - Image {$i}",
                    'order' => $i,
                ]);
            }
        }
    }
}