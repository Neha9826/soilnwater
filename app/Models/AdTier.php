<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdTier extends Model
{
    // These must match your migration columns
    protected $fillable = [
        'name', 
        'grid_width', 
        'grid_height', 
        'price', 
        'is_free'
    ];

    /**
     * Relationship: A Tier has many Master Templates
     */
    public function templates(): HasMany
    {
        return $this->hasMany(AdTemplate::class);
    }
}