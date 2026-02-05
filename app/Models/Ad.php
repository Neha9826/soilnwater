<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    protected $fillable = ['user_id', 'ad_template_id', 'title', 'status'];

    // This connects the Ad to its Design Template
    public function template(): BelongsTo
    {
        return $this->belongsTo(AdTemplate::class, 'ad_template_id');
    }

    // This connects the Ad to the custom text/images saved in ad_values
    public function values(): HasMany
    {
        return $this->hasMany(AdValue::class, 'ad_id');
    }
}