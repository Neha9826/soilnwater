<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdTemplate extends Model
{
    protected $fillable = ['ad_tier_id', 'name', 'blade_path', 'is_active'];

    /**
     * Relationship: A Template has many dynamic Fields.
     * This is what the Filament Repeater uses.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(AdTemplateField::class);
    }

    /**
     * Relationship: A Template belongs to a specific Shape/Tier.
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(AdTier::class, 'ad_tier_id');
    }
}