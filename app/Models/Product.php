<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'on_sale' => 'boolean',
    ];

    // CHANGED: Product now belongs to a Business, not a User
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}