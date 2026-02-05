<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdTemplateField extends Model
{
    // Explicitly define the table name from your SQL dump
    protected $table = 'ad_template_fields';

    protected $fillable = [
        'ad_template_id', 
        'field_name', 
        'label', 
        'type', 
        'is_required', 
        'default_value', 
        'sort_order'
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(AdTemplate::class, 'ad_template_id');
    }
}