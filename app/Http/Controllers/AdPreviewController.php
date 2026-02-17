<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class AdPreviewGenerator
{
    public static function generate(Ad $ad): ?string
    {
        Log::info('AdPreviewGenerator started', ['ad_id' => $ad->id]);

        try {
            $directory = 'ads/previews';
            Storage::disk('public')->makeDirectory($directory);

            $filename = 'ad_' . $ad->id . '_' . Str::random(6) . '.png';
            $relativePath = $directory . '/' . $filename;
            $absolutePath = storage_path('app/public/' . $relativePath);

            $url = route('ads.preview', $ad->id);

            Log::info('Generating preview', [
                'url' => $url,
                'output' => $absolutePath
            ]);

            Browsershot::url($url)
                ->setNodeBinary('node')
                ->setNpmBinary('npm')
                ->setChromePath(
                    base_path('node_modules/playwright/.local-browsers/chromium*/chrome-win/chrome.exe')
                )
                ->windowSize(1200, 1200)
                ->deviceScaleFactor(2)
                ->waitUntilNetworkIdle()
                ->timeout(90)
                ->save($absolutePath);

            if (!file_exists($absolutePath)) {
                Log::error('PNG not created');
                return null;
            }

            Log::info('Preview generated successfully', [
                'path' => $relativePath,
                'size' => filesize($absolutePath)
            ]);

            return $relativePath;

        } catch (\Throwable $e) {
            Log::error('AdPreviewGenerator FAILED', [
                'ad_id' => $ad->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
    