<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories and brands
        $smartphones = Category::where('name', 'Smartphones')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        $mensClothing = Category::where('name', 'Men\'s Clothing')->first();
        $womensClothing = Category::where('name', 'Women\'s Clothing')->first();
        $home = Category::where('name', 'Home & Garden')->first();

        $apple = Brand::where('name', 'Apple')->first();
        $samsung = Brand::where('name', 'Samsung')->first();
        $nike = Brand::where('name', 'Nike')->first();
        $adidas = Brand::where('name', 'Adidas')->first();
        $sony = Brand::where('name', 'Sony')->first();
        $ikea = Brand::where('name', 'IKEA')->first();

        // Electronics - Smartphones
        Product::create([
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',  // ← ADD SLUG
            'sku' => 'IPH15PRO-256',
            'description' => 'The latest iPhone with A17 Pro chip, titanium design, and advanced camera system.',
            'short_description' => 'Premium smartphone with titanium design',
            'price' => 1099.99,
            'quantity' => 25,
            'category_id' => $smartphones->id,
            'brand_id' => $apple->id,
            'is_active' => true,
            'is_featured' => true,
            'attributes' => ['color' => 'Natural Titanium', 'storage' => '256GB']
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S24 Ultra',
            'slug' => 'samsung-galaxy-s24-ultra',  // ← ADD SLUG
            'sku' => 'SGS24U-512',
            'description' => 'Flagship Android phone with S Pen, 200MP camera, and Snapdragon 8 Gen 3.',
            'short_description' => 'Android flagship with built-in S Pen',
            'price' => 1299.99,
            'quantity' => 18,
            'category_id' => $smartphones->id,
            'brand_id' => $samsung->id,
            'is_active' => true,
            'is_featured' => true,
            'attributes' => ['color' => 'Titanium Black', 'storage' => '512GB']
        ]);

        Product::create([
            'name' => 'MacBook Pro 16" M3 Max',
            'slug' => 'macbook-pro-16-m3-max',  // ← ADD SLUG
            'sku' => 'MBP16-M3MAX',
            'description' => 'Professional laptop with M3 Max chip, 16-inch Liquid Retina XDR display.',
            'short_description' => 'Professional creative workstation',
            'price' => 3499.99,
            'quantity' => 12,
            'category_id' => $laptops->id,
            'brand_id' => $apple->id,
            'is_active' => true,
            'is_featured' => true,
            'attributes' => ['color' => 'Space Black', 'ram' => '64GB', 'storage' => '2TB']
        ]);

        Product::create([
            'name' => 'Sony WH-1000XM5 Headphones',
            'slug' => 'sony-wh-1000xm5-headphones',  // ← ADD SLUG
            'sku' => 'SONY-WH1000XM5',
            'description' => 'Industry-leading noise cancelling headphones with 30-hour battery.',
            'short_description' => 'Premium noise cancelling headphones',
            'price' => 349.99,
            'quantity' => 42,
            'category_id' => $smartphones->id, // Electronics accessory
            'brand_id' => $sony->id,
            'is_active' => true,
            'is_featured' => false,
            'attributes' => ['color' => 'Black']
        ]);

        Product::create([
            'name' => 'Nike Air Max 270',
            'slug' => 'nike-air-max-270',  // ← ADD SLUG
            'sku' => 'NIKE-AM270',
            'description' => 'Comfortable lifestyle shoes with visible Air cushioning.',
            'short_description' => 'Iconic lifestyle sneakers',
            'price' => 149.99,
            'quantity' => 65,
            'category_id' => $mensClothing->id,
            'brand_id' => $nike->id,
            'is_active' => true,
            'is_featured' => true,
            'attributes' => ['color' => 'White/Black', 'size' => '10']
        ]);

        Product::create([
            'name' => 'Adidas Ultraboost 22',
            'slug' => 'adidas-ultraboost-22',  // ← ADD SLUG
            'sku' => 'ADI-UB22',
            'description' => 'Running shoes with responsive Boost cushioning and Primeknit upper.',
            'short_description' => 'Premium running shoes',
            'price' => 179.99,
            'quantity' => 38,
            'category_id' => $mensClothing->id,
            'brand_id' => $adidas->id,
            'is_active' => true,
            'is_featured' => false,
            'attributes' => ['color' => 'Core Black', 'size' => '11']
        ]);

        Product::create([
            'name' => 'Nike Sportswear Hoodie',
            'slug' => 'nike-sportswear-hoodie',  // ← ADD SLUG
            'sku' => 'NIKE-SWHOOD',
            'description' => 'Comfortable fleece hoodie with classic Nike design.',
            'short_description' => 'Classic fleece hoodie',
            'price' => 79.99,
            'quantity' => 52,
            'category_id' => $womensClothing->id,
            'brand_id' => $nike->id,
            'is_active' => true,
            'is_featured' => false,
            'attributes' => ['color' => 'Grey', 'size' => 'M']
        ]);

        Product::create([
            'name' => 'Adidas Tiro 24 Training Pants',
            'slug' => 'adidas-tiro-24-training-pants',  // ← ADD SLUG
            'sku' => 'ADI-TIRO24',
            'description' => 'Soccer-inspired training pants with moisture-wicking fabric.',
            'short_description' => 'Training pants for active lifestyle',
            'price' => 64.99,
            'quantity' => 47,
            'category_id' => $womensClothing->id,
            'brand_id' => $adidas->id,
            'is_active' => true,
            'is_featured' => false,
            'attributes' => ['color' => 'Black', 'size' => 'S']
        ]);

        Product::create([
            'name' => 'IKEA BILLY Bookcase',
            'slug' => 'ikea-billy-bookcase',  // ← ADD SLUG
            'sku' => 'IKEA-BILLY',
            'description' => 'Versatile bookcase that fits into small spaces, adjustable shelves.',
            'short_description' => 'Classic adjustable bookcase',
            'price' => 89.99,
            'quantity' => 24,
            'category_id' => $home->id,
            'brand_id' => $ikea->id,
            'is_active' => true,
            'is_featured' => true,
            'attributes' => ['color' => 'White', 'width' => '80cm']
        ]);

        Product::create([
            'name' => 'IKEA POÄNG Armchair',
            'slug' => 'ikea-poang-armchair',  // ← ADD SLUG
            'sku' => 'IKEA-POANG',
            'description' => 'Comfortable armchair with curved frame that adapts to your body.',
            'short_description' => 'Iconic comfortable armchair',
            'price' => 149.99,
            'quantity' => 18,
            'category_id' => $home->id,
            'brand_id' => $ikea->id,
            'is_active' => true,
            'is_featured' => false,
            'attributes' => ['color' => 'Birch', 'cover' => 'Beige']
        ]);

        Product::create([
            'name' => 'Apple Watch Series 9',
            'slug' => 'apple-watch-series-9',  // ← ADD SLUG
            'sku' => 'AWS9-45MM',
            'description' => 'Smartwatch with blood oxygen app, ECG, and Always-On Retina display.',
            'short_description' => 'Advanced health monitoring smartwatch',
            'price' => 429.99,
            'quantity' => 31,
            'category_id' => $smartphones->id,
            'brand_id' => $apple->id,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Samsung 4K Smart TV',
            'slug' => 'samsung-4k-smart-tv',  // ← ADD SLUG
            'sku' => 'SAMS-65UHD',
            'description' => '65" 4K UHD Smart TV with HDR and built-in streaming apps.',
            'short_description' => 'Crystal clear 4K television',
            'price' => 699.99,
            'quantity' => 15,
            'category_id' => $home->id,
            'brand_id' => $samsung->id,
            'is_active' => true,
            'is_featured' => false,
        ]);

        Product::create([
            'name' => 'Nike Dunk Low Retro',
            'slug' => 'nike-dunk-low-retro',  // ← ADD SLUG
            'sku' => 'NIKE-DUNKLOW',
            'description' => 'Retro basketball-inspired sneakers with classic design.',
            'short_description' => 'Classic basketball sneakers',
            'price' => 119.99,
            'quantity' => 0,
            'category_id' => $mensClothing->id,
            'brand_id' => $nike->id,
            'is_active' => true,
            'is_featured' => false,
        ]);

        Product::create([
            'name' => 'Sony PlayStation 4 Pro',
            'slug' => 'sony-playstation-4-pro',  // ← ADD SLUG
            'sku' => 'SONY-PS4PRO',
            'description' => 'Previous generation gaming console with 4K gaming.',
            'short_description' => '4K gaming console',
            'price' => 399.99,
            'quantity' => 8,
            'category_id' => $smartphones->id,
            'brand_id' => $sony->id,
            'is_active' => false,
            'is_featured' => false,
        ]);

        Product::create([
            'name' => 'Adidas Originals T-Shirt',
            'slug' => 'adidas-originals-t-shirt',  // ← ADD SLUG
            'sku' => 'ADI-TSHT',
            'description' => 'Classic cotton t-shirt with iconic Adidas logo.',
            'short_description' => 'Classic logo t-shirt',
            'price' => 29.99,
            'quantity' => 3,
            'category_id' => $mensClothing->id,
            'brand_id' => $adidas->id,
            'is_active' => true,
            'is_featured' => false,
        ]);
    }
}