<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing reviews to avoid duplicate errors
        Review::truncate();

        $users = User::where('role', 'shopper')->get();
        $products = Product::where('is_active', true)->get();

        $reviews = [
            "Great product! Exactly as described. Would buy again.",
            "Good quality for the price. Shipping was fast.",
            "Product met my expectations. Works perfectly.",
            "Amazing quality! Better than expected.",
            "Decent product, but could be improved.",
            "Perfect for my needs. Very satisfied with purchase.",
            "Good value for money. Recommended.",
            "Works well. No issues so far.",
            "Excellent product. Exceeded expectations.",
            "Happy with my purchase. Good customer service.",
            "Solid product, does what it says.",
            "Better than I anticipated. Very pleased.",
            "Good build quality. Worth the money.",
            "Exactly what I needed. No complaints.",
            "Works as advertised. Good purchase.",
        ];

        // Create a pool of user-product combinations
        $userProductCombinations = [];
        
        foreach ($users as $user) {
            // Each user reviews 0-3 different products
            $reviewCount = rand(0, 3);
            
            // Get random unique products for this user
            $userProducts = $products->random(min($reviewCount, $products->count()));
            
            foreach ($userProducts as $product) {
                $rating = rand(3, 5); // Mostly positive reviews
                $isApproved = rand(0, 1) || $rating >= 4; // High ratings usually approved

                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => $rating,
                    'content' => $reviews[array_rand($reviews)],
                    'is_approved' => $isApproved,
                    'metadata' => [
                        'verified_purchase' => rand(0, 1),
                        'helpful_votes' => rand(0, 15),
                    ],
                ]);
            }
        }

        // Add some extra reviews for popular products
        $popularProducts = $products->take(3); // First 3 products get extra reviews
        
        foreach ($popularProducts as $product) {
            // Each popular product gets 2-4 extra reviews from different users
            $extraReviews = rand(2, 4);
            $availableUsers = $users->shuffle()->take($extraReviews);
            
            foreach ($availableUsers as $user) {
                // Check if this user already reviewed this product
                if (!Review::where('product_id', $product->id)
                          ->where('user_id', $user->id)
                          ->exists()) {
                    
                    $rating = rand(4, 5); // Popular products get higher ratings
                    
                    Review::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'rating' => $rating,
                        'content' => $reviews[array_rand($reviews)],
                        'is_approved' => true, // Popular product reviews auto-approved
                        'metadata' => [
                            'verified_purchase' => 1, // Mark as verified for popular products
                            'helpful_votes' => rand(5, 25),
                        ],
                    ]);
                }
            }
        }
    }
}