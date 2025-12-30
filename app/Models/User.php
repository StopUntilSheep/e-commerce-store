<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // 'admin' / 'shopper'
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========== RELATIONSHIPS ==========
    
    /**
     * User's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * User's reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * User's wishlist items
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }
    
    /**
     * User's shopping cart (if storing cart in DB)
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
    
    /**
     * User's addresses
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    
    /**
     * User's default shipping address
     */
    public function defaultShippingAddress()
    {
        return $this->belongsTo(Address::class, 'default_shipping_address_id');
    }
    
    /**
     * User's default billing address
     */
    public function defaultBillingAddress()
    {
        return $this->belongsTo(Address::class, 'default_billing_address_id');
    }
    
    // ========== SCOPES ==========
    
    /**
     * Scope for customers (non-admins)
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'shopper');
    }
    
    /**
     * Scope for admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
    
    /**
     * Scope for users with verified email
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
    
    // ========== ACCESSORS ==========
    
    /**
     * Check if user is an admin
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user is a shopper
     */
    public function getIsShopperAttribute(): bool
    {
        return $this->role === 'shopper' || $this->role === null;
    }
    
    /**
     * Get user's initials for avatar placeholder
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        
        return $initials;
    }
    
    /**
     * Get total spent by user
     */
    public function getTotalSpentAttribute(): float
    {
        return $this->orders()
            ->where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->sum('total');
    }
    
    /**
     * Get formatted total spent
     */
    public function getFormattedTotalSpentAttribute(): string
    {
        return '£' . number_format($this->total_spent, 2);
    }
    
    /**
     * Get order count
     */
    public function getOrdersCountAttribute(): int
    {
        return $this->orders()->count();
    }
    
    /**
     * Get average order value
     */
    public function getAverageOrderValueAttribute(): float
    {
        $count = $this->orders_count;
        return $count > 0 ? $this->total_spent / $count : 0;
    }
    
    // ========== METHODS ==========
    
    /**
     * Check if user has ordered a specific product
     */
    public function hasPurchasedProduct($productId): bool
    {
        return $this->orders()
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
    }
    
    /**
     * Check if user can review a product
     */
    public function canReviewProduct($productId): bool
    {
        // Only allow reviews from verified purchasers
        return $this->hasPurchasedProduct($productId);
    }
    
    /**
     * Add product to wishlist
     */
    public function addToWishlist(Product $product): void
    {
        $this->wishlist()->syncWithoutDetaching([$product->id]);
    }
    
    /**
     * Remove product from wishlist
     */
    public function removeFromWishlist(Product $product): void
    {
        $this->wishlist()->detach($product->id);
    }
    
    /**
     * Check if product is in wishlist
     */
    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlist()->where('product_id', $product->id)->exists();
    }
}
