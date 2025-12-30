<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website',
    ];

    protected $casts = [
        'logo' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}