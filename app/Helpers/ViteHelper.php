<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ViteHelper
{
    public static function asset($path)
    {
        // Cek jika VERCEL_ENV diatur
        $isVercel = env('VERCEL_ENV', false);

        // Tentukan lokasi manifest.json
        $manifestPath = $isVercel
            ? base_path('public/build/manifest.json') // Path untuk Vercel
            : public_path('build/manifest.json');     // Path untuk localhost

        Log::info('Manifest Path: ' . $manifestPath);

        if (!file_exists($manifestPath)) {
            throw new \Exception('Manifest file not found: ' . $manifestPath);
        }

        // Parse manifest.json
        $manifest = json_decode(file_get_contents($manifestPath), true);

        if (!isset($manifest[$path])) {
            throw new \Exception('Asset not found in manifest: ' . $path);
        }

        if (config('app.env') === 'production') {
            return $manifest[$path]['file'];
        } else {
            return '/build/' . $manifest[$path]['file'];
        }
    }
}
