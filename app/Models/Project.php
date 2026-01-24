<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean',
        'is_promoted' => 'boolean',
        'promotion_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // This was the missing method causing your error
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_project');
    }
}