<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Allow these fields to be stored in the database
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    /**
     * Get the product associated with the cart item.
     * This allows us to pull the price, name, and images.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who owns this cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}