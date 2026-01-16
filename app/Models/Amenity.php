<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'amenity_property');
    }
}