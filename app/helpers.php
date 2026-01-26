<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        static $settings = null;
        
        if ($settings === null) {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        }
        
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('email_logo_url')) {
    /**
     * Get email logo URL with full domain or base64
     *
     * @return string|null
     */
    function email_logo_url()
    {
        // Check if base64 version exists (for localhost testing)
        $base64Logo = setting('email_logo_base64');
        if ($base64Logo && str_starts_with($base64Logo, 'data:image/')) {
            return $base64Logo;
        }
        
        $logoUrl = setting('email_logo_url');
        
        if (!$logoUrl) {
            return null;
        }
        
        // If already has domain, return as is
        if (str_starts_with($logoUrl, 'http')) {
            return $logoUrl;
        }
        
        // If starts with /storage/, add domain
        if (str_starts_with($logoUrl, '/storage/')) {
            return config('app.url') . $logoUrl;
        }
        
        // If just filename or relative path, add full storage path
        return config('app.url') . '/storage/' . ltrim($logoUrl, '/');
    }
}