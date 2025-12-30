<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',  // ← ADD THIS
                'website' => 'https://www.apple.com',
                'logo' => ['url' => '/storage/brands/apple.png', 'alt' => 'Apple Logo']
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',  // ← ADD THIS
                'website' => 'https://www.samsung.com',
                'logo' => ['url' => '/storage/brands/samsung.png', 'alt' => 'Samsung Logo']
            ],
            [
                'name' => 'Nike',
                'slug' => 'nike',  // ← ADD THIS
                'website' => 'https://www.nike.com',
                'logo' => ['url' => '/storage/brands/nike.png', 'alt' => 'Nike Logo']
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',  // ← ADD THIS
                'website' => 'https://www.adidas.com',
                'logo' => ['url' => '/storage/brands/adidas.png', 'alt' => 'Adidas Logo']
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',  // ← ADD THIS
                'website' => 'https://www.sony.com',
                'logo' => ['url' => '/storage/brands/sony.png', 'alt' => 'Sony Logo']
            ],
            [
                'name' => 'IKEA',
                'slug' => 'ikea',  // ← ADD THIS
                'website' => 'https://www.ikea.com',
                'logo' => ['url' => '/storage/brands/ikea.png', 'alt' => 'IKEA Logo']
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}