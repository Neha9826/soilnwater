<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 1. CASTS: This is critical for your Website Builder & Images
    protected $casts = [
        'header_images' => 'array',
        'page_sections' => 'array',
        'is_verified' => 'boolean',
    ];

    // 2. BOOTED: This logic was moved from User.php
    // It automatically generates the Slug and QR Code when you save a business.
    protected static function booted()
    {
        static::saving(function ($business) {
            if ($business->name && !$business->slug) {
                // A. Generate Slug (e.g. "Sri Ram Paints" -> "sri-ram-paints")
                $business->slug = Str::slug($business->name);
                
                // B. Check uniqueness (append number if exists)
                $count = static::where('slug', $business->slug)->count();
                if ($count > 0) {
                    $business->slug .= '-' . ($count + 1);
                }

                // C. Generate QR Code
                $url = url('/v/' . $business->slug);
                $qrContent = QrCode::format('svg')->size(300)->generate($url);
                
                $filename = 'qrcodes/' . $business->slug . '.svg';
                Storage::disk('public')->put($filename, $qrContent);
                
                $business->qr_code_path = $filename;
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }
}