<?php

namespace App\Helpers;

class ViteHelper
{
    public static function asset($path)
    {
        // Path ke manifest.json
        $manifestPath = public_path('build/manifest.json');

        if (!file_exists($manifestPath)) {
            throw new \Exception('Manifest file not found: ' . $manifestPath);
        }

        // Parse manifest.json
        $manifest = json_decode(file_get_contents($manifestPath), true);

        if (!isset($manifest[$path])) {
            throw new \Exception('Asset not found in manifest: ' . $path);
        }

        return '/build/' . $manifest[$path]['file'];
    }
}
