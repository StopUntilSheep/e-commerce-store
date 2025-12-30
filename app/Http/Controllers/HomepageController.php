<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        // Get featured products
        $featuredProducts = Product::with(['category', 'brand', 'images' => function ($query) {
                $query->whereNull('deleted_at'); // Exclude soft-deleted images
            }])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'formatted_price' => '£' . number_format($product->price, 2),
                    'short_description' => $product->short_description,
                    'is_in_stock' => $product->quantity > 0,
                    'category' => $product->category?->name,
                    'brand' => $product->brand?->name,
                    'main_image' => $product->images->first()?->url,
                    'main_image_alt_text' => $product->images->first()?->alt_text,
                    'average_rating' => $product->reviews()->avg('rating') ?? 0,
                ];
            });

        // Get new arrivals
        $newArrivals = Product::with(['category', 'brand', 'images'])
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(12)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'formatted_price' => '£' . number_format($product->price, 2),
                    'short_description' => $product->short_description,
                    'is_in_stock' => $product->quantity > 0,
                    'category' => $product->category?->name,
                    'brand' => $product->brand?->name,
                    'main_image' => $product->images->first()?->url ?? '/images/placeholder.jpg',
                    'created_at' => $product->created_at->diffForHumans(),
                ];
            });

        // Get categories (simplified for SQLite)
        $categories = Category::whereNull('parent_id')
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true)->where('quantity', '>', 0);
            }])
            ->orderBy('order')
            ->take(6)
            ->get();

        return Inertia::render('Homepage', [
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'categories' => $categories,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}