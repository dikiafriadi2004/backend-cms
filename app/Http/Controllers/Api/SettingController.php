<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        // Filter out sensitive settings
        $publicSettings = $settings->except([
            'google_analytics_id',
            'facebook_pixel_id',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'mail_encryption'
        ]);

        // Convert image paths to full URLs
        $publicSettings = $this->convertImagePathsToUrls($publicSettings);

        return response()->json([
            'success' => true,
            'data' => $publicSettings
        ]);
    }

    public function general()
    {
        $generalKeys = [
            'site_name',
            'site_tagline',
            'site_description',
            'site_logo',
            'site_favicon',
            'contact_email',
            'contact_phone',
            'contact_address',
            'timezone',
            'date_format',
            'time_format'
        ];

        $settings = Setting::whereIn('key', $generalKeys)
            ->get()
            ->pluck('value', 'key');

        // Convert image paths to full URLs
        $settings = $this->convertImagePathsToUrls($settings);

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function seo()
    {
        $seoKeys = [
            'meta_title',
            'meta_description',
            'meta_keywords',
            'og_title',
            'og_description',
            'og_image',
            'twitter_card',
            'twitter_site',
            'twitter_creator'
        ];

        $settings = Setting::whereIn('key', $seoKeys)
            ->get()
            ->pluck('value', 'key');

        // Convert image paths to full URLs
        $settings = $this->convertImagePathsToUrls($settings);

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function social()
    {
        $socialKeys = [
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'linkedin_url',
            'youtube_url',
            'tiktok_url',
            'whatsapp_number'
        ];

        $settings = Setting::whereIn('key', $socialKeys)
            ->get()
            ->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function company()
    {
        $companyKeys = [
            'company_name',
            'company_tagline',
            'company_description',
            'company_about',
            'company_vision',
            'company_mission',
            'company_address',
            'company_phone',
            'company_email',
            'company_whatsapp',
            'company_telegram',
            'telegram_channel',
            'cta_title',
            'cta_subtitle',
            'cta_description',
            'cta_button_text',
            'cta_button_url',
            'cta_whatsapp_number',
            'cta_whatsapp_message'
        ];

        $settings = Setting::whereIn('key', $companyKeys)
            ->get()
            ->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function show($key)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Setting not found'
            ], 404);
        }

        // Check if setting is sensitive
        $sensitiveKeys = [
            'google_analytics_id',
            'facebook_pixel_id',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'mail_encryption'
        ];

        if (in_array($key, $sensitiveKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to sensitive setting'
            ], 403);
        }

        $value = $setting->value;

        // Convert image path to full URL if it's an image setting
        if ($this->isImageSetting($key) && $value) {
            $value = $this->convertPathToUrl($value);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'key' => $setting->key,
                'value' => $value
            ]
        ]);
    }

    private function convertImagePathsToUrls($settings)
    {
        $imageKeys = [
            'site_logo',
            'site_favicon',
            'og_image',
            'company_logo',
            'company_favicon'
        ];

        foreach ($imageKeys as $key) {
            if (isset($settings[$key]) && $settings[$key]) {
                $settings[$key] = $this->convertPathToUrl($settings[$key]);
            }
        }

        return $settings;
    }

    private function convertPathToUrl($path)
    {
        if (!$path) {
            return null;
        }

        // If already a full URL, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // If starts with http or https, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Convert storage path to full URL
        if (Storage::disk('public')->exists($path)) {
            return url(Storage::url($path));
        }

        // Fallback: construct URL manually
        return url('/storage/' . ltrim($path, '/'));
    }

    private function isImageSetting($key)
    {
        $imageKeys = [
            'site_logo',
            'site_favicon',
            'og_image',
            'company_logo',
            'company_favicon'
        ];

        return in_array($key, $imageKeys);
    }
}