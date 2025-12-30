<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing variants to avoid duplicate errors
        ProductVariant::truncate();

        // Add variants to clothing products
        $clothingProducts = Product::whereHas('category', function ($query) {
            $query->where('name', 'LIKE', '%Clothing%');
        })->get();

        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Grey'];
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        foreach ($clothingProducts as $product) {
            // Each clothing product gets 3-6 variants
            $variantCount = rand(3, 6);
            
            // Track used combinations for this product to avoid duplicates
            $usedCombinations = [];
            
            for ($i = 1; $i <= $variantCount; $i++) {
                $color = $colors[array_rand($colors)];
                $size = $sizes[array_rand($sizes)];
                $combination = "{$color}-{$size}";
                
                // Ensure unique combination for this product
                while (in_array($combination, $usedCombinations)) {
                    $color = $colors[array_rand($colors)];
                    $size = $sizes[array_rand($sizes)];
                    $combination = "{$color}-{$size}";
                }
                
                $usedCombinations[] = $combination;
                
                // Create unique SKU
                $sku = "{$product->sku}-{$color}-{$size}";
                
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $sku,
                    'name' => "{$product->name} - {$color}, Size {$size}",
                    'attributes' => [
                        'color' => $color,
                        'size' => $size,
                    ],
                ]);
            }
        }

        // Add variants to iPhone (different colors and storage)
        $iphone = Product::where('name', 'iPhone 15 Pro')->first();
        if ($iphone) {
            $iphoneColors = ['Natural Titanium', 'Blue Titanium', 'White Titanium', 'Black Titanium'];
            $storageOptions = ['128GB', '256GB', '512GB', '1TB'];
            
            foreach ($iphoneColors as $color) {
                foreach ($storageOptions as $storage) {
                    // Create unique SKU for each combination
                    $colorSlug = Str::slug($color, '-');
                    $storageSlug = Str::slug($storage, '-');
                    
                    ProductVariant::create([
                        'product_id' => $iphone->id,
                        'sku' => "IPH15PRO-{$colorSlug}-{$storageSlug}",
                        'name' => "iPhone 15 Pro - {$color} - {$storage}",
                        'attributes' => [
                            'color' => $color,
                            'storage' => $storage,
                        ],
                    ]);
                }
            }
        }
    }
}