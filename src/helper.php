<?php

if (!function_exists('hq_asset_url')) {
    function hq_asset_url(string $url): string
    {
        // Default disk & base path
        $disk = config('filesystems.default', 'public');
        $base = rtrim(config('filesystems.asset_url', '/assets'), '/');
        $path = ltrim($url, '/');

        // Delay Storage usage hanya jika app sudah boot
        if ($disk === 's3' && class_exists('Illuminate\Support\Facades\Storage')) {
            try {
                return \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
            } catch (\RuntimeException $e) {
                // Kalau belum boot, fallback ke asset
                return asset($base . '/' . $path);
            }
        }

        return asset($base . '/' . $path);
    }
}
