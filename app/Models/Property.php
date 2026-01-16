<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    // CASTS: Automatically convert JSON database columns to PHP Arrays
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean',
    ];

    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function floors()
    {
        return $this->hasMany(PropertyFloor::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_property');
    }
}