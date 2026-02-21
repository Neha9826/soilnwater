<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdPreviewGenerator
{
    /**
     * Generates a high-quality PNG preview using an external API.
     */
    public static function generate(Ad $ad): ?string
{
    try {
        $tier = $ad->template->tier;
        
        // Calculate exact pixel dimensions based on your 4-column grid unit
        // Standard (1x1) = 400x400 | Banner (4x1) = 1600x400 | Full Page (4x2) = 1600x800
        $width = (int)($tier->grid_width * 400);
        $height = (int)($tier->grid_height * 400);

        $data = $ad->values->load('field')->mapWithKeys(function($item) {
            $val = $item->value;
            if ($item->field->type === 'image' && !empty($val)) {
                if (Storage::disk('public')->exists($val)) {
                    $imageData = Storage::disk('public')->get($val);
                    $mimeType = Storage::disk('public')->mimeType($val);
                    $val = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                }
            }
            return [$item->field->field_name => $val];
        })->toArray();

        $rawHtml = view($ad->template->blade_path, ['data' => $data])->render();
        
        $html = "<html>
             <head>
                <script src='https://cdn.tailwindcss.com'></script>
                <style>
                    /* Force the viewport to the exact size of the Ad Tier */
                    body, html { 
                        margin: 0 !important; 
                        padding: 0 !important; 
                        width: {$width}px !important; 
                        height: {$height}px !important; 
                        overflow: hidden; 
                    }
                    .ad-container { 
                        width: 100% !important; 
                        height: 100% !important; 
                        position: relative; 
                    }
                </style>
             </head>
             <body>
                <div class='ad-container'>{$rawHtml}</div>
             </body>
             </html>";

        $response = Http::withBasicAuth(config('services.hcti.id'), config('services.hcti.key'))
            ->post('https://hcti.io/v1/image', [
                'html' => $html,
                'selector' => '.ad-container', 
                'width' => $width,  // Matches 1600px for Banners
                'height' => $height,
                'ms_delay' => 1000  // Increased delay to ensure wide layouts render
            ]);

        if ($response->successful()) {
            $filename = 'ads/previews/ad_' . $ad->id . '_' . time() . '.png';
            Storage::disk('public')->put($filename, Http::get($response->json()['url'])->body());
            return $filename;
        }

        Log::error('HCTI API Error: ' . $response->body());
        return null;

    } catch (\Exception $e) {
        Log::error('Ad Preview Error: ' . $e->getMessage());
        return null;
    }
}   
}