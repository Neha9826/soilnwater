<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdTemplateField extends Model
{
    protected $fillable = [
        'ad_template_id', 
        'field_name', 
        'label', 
        'type', 
        'is_required', 
        'default_value', // The Admin's "Master Design" content
        'sort_order'
    ];

    /**
     * Relationship: The field belongs to a Master Template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(AdTemplate::class);
    }
}