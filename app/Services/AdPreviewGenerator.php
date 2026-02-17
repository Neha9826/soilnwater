<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdPreviewGenerator
{
    public static function generate(Ad $ad): ?string
    {
        $directory = 'ads/previews';
        Storage::disk('public')->makeDirectory($directory);

        $filename = 'ad_' . $ad->id . '_' . Str::random(6) . '.png';
        $path = $directory . '/' . $filename;

        // Canvas size (square default)
        $width  = 600;
        $height = 600;

        // Create image
        $img = imagecreatetruecolor($width, $height);

        // Colors
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 20, 20, 20);
        $gray  = imagecolorallocate($img, 120, 120, 120);

        // Background
        imagefilledrectangle($img, 0, 0, $width, $height, $white);

        // Title
        imagestring($img, 5, 20, 20, $ad->title, $black);

        // Load ad values
        $y = 70;
        foreach ($ad->values()->with('field')->get() as $value) {

            // Skip images here (handled below)
            if ($value->field->type === 'image') {
                continue;
            }

            $text = $value->field->field_name . ': ' . strval($value->value);
            imagestring($img, 3, 20, $y, substr($text, 0, 60), $gray);
            $y += 22;
        }

        // Handle first image field (if any)
        $imageValue = $ad->values()
            ->whereHas('field', fn ($q) => $q->where('type', 'image'))
            ->first();

        if ($imageValue && Storage::disk('public')->exists($imageValue->value)) {

            $imagePath = storage_path('app/public/' . $imageValue->value);
            $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

            $src = match ($ext) {
                'jpg', 'jpeg' => imagecreatefromjpeg($imagePath),
                'png' => imagecreatefrompng($imagePath),
                default => null
            };

            if ($src) {
                imagecopyresampled(
                    $img,
                    $src,
                    350, 350,
                    0, 0,
                    220, 220,
                    imagesx($src),
                    imagesy($src)
                );
                imagedestroy($src);
            }
        }

        // Save image
        $absolute = storage_path('app/public/' . $path);
        imagepng($img, $absolute);
        imagedestroy($img);

        return $path;
    }
}
