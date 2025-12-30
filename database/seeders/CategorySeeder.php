<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create main categories first (no parent_id)
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Latest gadgets and electronics',
            'order' => 1,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and apparel',
            'order' => 2,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home decor and garden supplies',
            'order' => 3,
        ]);

        $books = Category::create([
            'name' => 'Books & Media',
            'slug' => 'books-media',
            'description' => 'Books, movies, and music',
            'order' => 4,
        ]);

        // Now create sub-categories with parent_id
        Category::create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'description' => 'Mobile phones and accessories',
            'parent_id' => $electronics->id,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Laptops and computing',
            'parent_id' => $electronics->id,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Headphones',
            'slug' => 'headphones',
            'description' => 'Audio headphones and earphones',
            'parent_id' => $electronics->id,
            'order' => 3,
        ]);

        Category::create([
            'name' => 'Men\'s Clothing',
            'slug' => 'mens-clothing',
            'description' => 'Clothing for men',
            'parent_id' => $clothing->id,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Women\'s Clothing',
            'slug' => 'womens-clothing',
            'description' => 'Clothing for women',
            'parent_id' => $clothing->id,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Footwear',
            'slug' => 'footwear',
            'description' => 'Shoes and sneakers',
            'parent_id' => $clothing->id,
            'order' => 3,
        ]);

        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'description' => 'Home furniture and decor',
            'parent_id' => $home->id,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Kitchenware',
            'slug' => 'kitchenware',
            'description' => 'Kitchen appliances and utensils',
            'parent_id' => $home->id,
            'order' => 2,
        ]);
    }
}