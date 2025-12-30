<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'content',
        'is_approved',  // For moderation
        'metadata',
    ];

    protected $casts = [
        'rating' => 'integer',
        'metadata' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getDateAddedAttribute()
    {
        return $this->created_at->format('F j, Y'); // "January 15, 2024"
    }
    
    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans(); // "2 days ago"
    }
    
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
    
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
