<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'variant_sku',
        'quantity',
        'attributes',
        'price',
        'price_snapshot',
        'expires_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'attributes' => 'array',
        'price_snapshot' => 'array',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    // Accessors
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '£' . number_format($this->subtotal, 2);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '£' . number_format($this->price, 2);
    }

    public function getIsGuestAttribute(): bool
    {
        return is_null($this->user_id);
    }

    public function getVariantNameAttribute(): ?string
    {
        if (!$this->attributes || !$this->variant_sku) {
            return null;
        }

        // Convert attributes array to readable string
        // {'size': 'M', 'color': 'Red'} → "Size: M, Color: Red"
        return collect($this->attributes)
            ->map(fn($value, $key) => ucfirst($key) . ': ' . ucfirst($value))
            ->join(', ');
    }

    // Business Logic
    public function increaseQuantity(int $amount = 1): void
    {
        $this->increment('quantity', $amount);
    }

    public function decreaseQuantity(int $amount = 1): bool
    {
        $newQuantity = $this->quantity - $amount;
        
        if ($newQuantity <= 0) {
            $this->delete();
            return true;
        }
        
        $this->decrement('quantity', $amount);
        return false;
    }

    public function updatePrice(): void
    {
        $product = $this->product;
        
        if (!$product) {
            return;
        }

        // Get current price (including variant adjustments if any)
        $currentPrice = $product->price;
        
        // Store price snapshot
        $this->price_snapshot = [
            'original' => $product->price,
            'compare_price' => $product->compare_price,
            'updated_at' => now(),
        ];
        
        $this->price = $currentPrice;
        $this->save();
    }

    public function mergeWith(Cart $otherCart): void
    {
        if ($this->product_id !== $otherCart->product_id || 
            $this->variant_sku !== $otherCart->variant_sku) {
            return;
        }

        $this->increaseQuantity($otherCart->quantity);
        $otherCart->delete();
    }

    public static function cleanupExpired(): void
    {
        self::expired()->delete();
    }
}