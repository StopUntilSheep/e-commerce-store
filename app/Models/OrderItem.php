<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',           // Original product reference (nullable if product deleted)
        'product_snapshot',     // JSON snapshot of product at time of purchase
        'name',                 // Product name at time of purchase
        'sku',                  // SKU at time of purchase
        'price',                // Price paid per unit
        'quantity',
        'subtotal',             // price * quantity
        'attributes',           // Selected variant attributes
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
        'product_snapshot' => 'array',
        'attributes' => 'array',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed(); // Include soft-deleted
    }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        return '£' . number_format($this->price, 2);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '£' . number_format($this->subtotal, 2);
    }

    // Create snapshot when adding to order
    public static function createFromProduct(Product $product, array $attributes = []): self
    {
        return new static([
            'product_id' => $product->id,
            'product_snapshot' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->price,
                'images' => $product->images->map->only(['url', 'alt_text']),
                'category' => $product->category?->name,
                'brand' => $product->brand?->name,
            ],
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
            'attributes' => $attributes,
        ]);
    }
}