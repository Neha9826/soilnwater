<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdValue extends Model
{
    protected $fillable = ['ad_id', 'field_id', 'value'];

    /**
     * This relationship MUST be named 'field' to fix the error 
     */
    public function field(): BelongsTo
    {
        // Links the saved data to the specific label in the fields table
        return $this->belongsTo(AdTemplateField::class, 'field_id');
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}