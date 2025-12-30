<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // 'shipping', 'billing', 'both'
        'first_name',
        'last_name',
        'company',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'country',
        'country_code',
        'phone',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getFormattedAddressAttribute(): string
    {
        $lines = [];
        if ($this->company) $lines[] = $this->company;
        $lines[] = $this->address_line_1;
        if ($this->address_line_2) $lines[] = $this->address_line_2;
        $lines[] = $this->city;
        if ($this->county) $lines[] = $this->county;
        $lines[] = $this->postcode;
        $lines[] = $this->country;

        return implode("\n", $lines);
    }
}