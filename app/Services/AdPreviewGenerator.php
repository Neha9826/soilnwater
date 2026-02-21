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
            
            // We use 400px as the base unit to match your Trekking design's math
            // This ensures a 1x2 ad becomes 400x800 and a 1x1 becomes 400x400
            $width = $tier->grid_width * 400;
            $height = $tier->grid_height * 400;

            $data = $ad->values->load('field')->mapWithKeys(function($item) {
                $val = $item->value;
                if ($item->field->type === 'image' && !empty($val)) {
                    if (Storage::disk('public')->exists($val)) {
                        $imageData = Storage::disk('public')->get($val);
                        $mimeType = Storage::disk('public')->mimeType($val);
                        // Base64 encoding ensures images load regardless of server path issues
                        $val = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                    }
                }
                return [$item->field->field_name => $val];
            })->toArray();

            $rawHtml = view($ad->template->blade_path, ['data' => $data])->render();
            
            // Clean HTML wrapper with zero margins to prevent thin white borders
            $html = "<html>
                 <head>
                    <script src='https://cdn.tailwindcss.com'></script>
                    <style>
                        body, html { margin: 0; padding: 0; overflow: hidden; background: white; }
                        /* Ensure the container matches the template's pixel expectations */
                        .ad-container { width: {$width}px; height: {$height}px; position: relative; overflow: hidden; }
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
        'width' => $width,  // CRITICAL: Tells API to produce a wide banner image
        'height' => $height // CRITICAL: Tells API to produce a tall full-page image
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