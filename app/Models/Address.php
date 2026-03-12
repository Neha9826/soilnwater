<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'name', 'phone', 'pincode', 'address', 'city', 'state', 'is_default'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
