<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product) // Laravel automatically finds by slug
    {
        // Check if product is active
        if (!$product->is_active) {
            abort(404); // Or redirect
        }
        
        // Eager load relationships
        $product->load(['category', 'brand', 'images' => function ($query) {
            $query->whereNull('deleted_at')->orderBy('order');
        }]);
        
        // Also load reviews with users
        $product->load(['reviews' => function ($query) {
            $query->where('is_approved', true)
                  ->with('user:id,name')
                  ->latest()
                  ->take(10);
        }]);
        
        // Format data
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'formatted_price' => '£' . number_format($product->price, 2),
            'description' => $product->description,
            'short_description' => $product->short_description,
            'quantity' => $product->quantity,
            'is_in_stock' => $product->quantity > 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null,
            'brand' => $product->brand ? [
                'id' => $product->brand->id,
                'name' => $product->brand->name,
                'slug' => $product->brand->slug,
            ] : null,
            'images' => $product->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->url,
                    'thumbnail_url' => $image->thumbnail_url,
                    'alt_text' => $image->alt_text,
                    'is_primary' => $image->is_primary,
                    'order' => $image->order,
                ];
            }),
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'name' => $variant->name,
                    'attributes' => $variant->attributes,
                ];
            }),
            'average_rating' => $product->reviews->avg('rating') ?? 0,
            'reviews_count' => $product->reviews->count(),
            'reviews' => $product->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'content' => $review->content,
                    'created_at' => $review->created_at->diffForHumans(),
                    'user' => $review->user ? [
                        'name' => $review->user->name,
                        'initials' => $review->user->initials,
                    ] : null,
                    'metadata' => $review->metadata,
                ];
            }),
            'is_featured' => $product->is_featured,
            'attributes' => $product->attributes,
            'created_at' => $product->created_at->format('F Y'),
        ];
        
        // Get related products
        $relatedProducts = Product::with(['images' => function ($query) {
                $query->whereNull('deleted_at')->orderBy('order');
            }])
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                // Same category
                if ($product->category_id) {
                    $query->where('category_id', $product->category_id);
                }
                // Or same brand
                if ($product->brand_id) {
                    $query->orWhere('brand_id', $product->brand_id);
                }
            })
            ->take(4)
            ->get()
            ->map(function ($related) {
                return [
                    'id' => $related->id,
                    'name' => $related->name,
                    'slug' => $related->slug,
                    'price' => $related->price,
                    'formatted_price' => '£' . number_format($related->price, 2),
                    'main_image' => $related->images->first()?->url,
                ];
            });
        
        return Inertia::render('Product', [
            'product' => $productData,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}