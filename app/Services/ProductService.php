<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductService
{
    public function getFeaturedProducts($limit = 8)
    {
        return Product::with(['category', 'brand', 'images' => function ($query) {
            $query->whereNull('deleted_at');
        }])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });
    }

    public function getNewArrivals($limit = 12)
    {
        return Product::with(['category', 'brand', 'images'])
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product, ['created_at']);
            });
    }

    public function getCategories($limit = 6)
    {
        return Category::whereNull('parent_id')
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true)->where('quantity', '>', 0);
            }])
            ->orderBy('order')
            ->take($limit)
            ->get();
    }

    public function getBrands()
    {
        return Brand::withCount(['products' => function ($query) {
            $query->where('is_active', true)->where('quantity', '>', 0);
        }])
            ->get();
    }

    protected function formatProduct($product, $additionalFields = [])
    {
        $formatted = [
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

        $defaultVariant = $product->has_variants
            ? $product->variants->where('is_default', true)->first()
            : null;

        if ($defaultVariant) {
            $formatted = array_merge($formatted, ['sku' => $defaultVariant->sku]);
        }

        foreach ($additionalFields as $field) {
            if (isset($product->$field)) {
                $formatted[$field] = $product->$field;
            }
        }

        return $formatted;
    }
}
