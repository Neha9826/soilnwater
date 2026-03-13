<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amenities' => 'array', // Keep this: it handles the CheckboxList data
        'images' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean',
        'is_promoted' => 'boolean',
        'is_featured' => 'boolean', // Added to match ProjectResource toggle
        'completion_date' => 'date', // Added to match DatePicker in Resource
        'promotion_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* REMOVED: public function amenities() 
       REASON: We are using a JSON column 'amenities' in the projects table 
       instead of a many-to-many relationship table. 
    */
}