<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- This line was missing or broken
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // This allows you to save data without "MassAssignmentException"
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}