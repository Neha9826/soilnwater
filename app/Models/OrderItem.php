<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // These are the actual columns for an item, not shipping details
    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity', 
        'price'
    ];

    /**
     * Relationship: Each item belongs to one Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: Each item belongs to one Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}