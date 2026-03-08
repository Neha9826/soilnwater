<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'order_number', 'total_amount', 'status', 'name', 'phone', 'address', 'city', 'state', 'pincode'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
