<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // FIX: This tells Laravel to handle these fields as JSON Arrays automatically
    protected $casts = [
        'images' => 'array',
        'colors' => 'array',
        'sizes' => 'array',
        'specifications' => 'array',
        'tiered_pricing' => 'array', // <--- ADD THIS
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2', // <--- ADD THIS
        'is_active' => 'boolean',
        'is_sellable' => 'boolean', // <--- ADD THIS
        'has_special_offer' => 'boolean', // <--- ADD THIS
        'stock_quantity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(6);
            }
            if (empty($product->sku)) {
                $product->sku = strtoupper(Str::slug($product->brand ?? 'GEN') . '-' . Str::random(8));
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }
}