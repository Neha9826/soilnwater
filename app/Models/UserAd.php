<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAd extends Model
{
    protected $fillable = ['ad_template_id', 'user_id', 'title', 'custom_data'];

    protected $casts = [
        'custom_data' => 'array',
    ];
}
