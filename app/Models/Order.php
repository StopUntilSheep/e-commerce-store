<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',              // Who placed the order
        'order_number',         // Unique order identifier
        'status',               // pending, processing, shipped, delivered, cancelled
        'subtotal',             // Total before tax/shipping
        'tax_amount',           // Tax amount
        'shipping_amount',      // Shipping cost
        'total',                // Final total
        'payment_method',       // stripe, paypal, etc.
        'payment_status',       // pending, paid, failed, refunded
        'shipping_address',     // JSON with full address
        'billing_address',      // JSON (may be same as shipping)
        'notes',                // Customer notes
        'admin_notes',          // Internal notes
        'metadata',             // Additional data
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'metadata' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getFormattedTotalAttribute(): string
    {
        return '£' . number_format($this->total, 2);
    }

    public function getCustomerNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        
        // For guest orders, get from shipping address
        return $this->shipping_address['first_name'] . ' ' . $this->shipping_address['last_name'];
    }
}

// Shipping/billing address JSON structure
// $address = [
//     'first_name' => 'John',
//     'last_name' => 'Doe',
//     'company' => 'ACME Corp',
//     'address_line_1' => '123 Main St',
//     'address_line_2' => 'Suite 100',
//     'city' => 'London',
//     'county' => 'Greater London',
//     'postcode' => 'SW1A 1AA',
//     'country' => 'United Kingdom',
//     'country_code' => 'GB',
//     'phone' => '+44 1234 567890',
//     'email' => 'john@example.com',
// ];
