<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Get all public settings.
     */
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

        return response()->json([
            'success' => true,
            'data' => $publicSettings
        ]);
    }

    /**
     * Get general settings.
     */
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

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Get SEO settings.
     */
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

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Get social media settings.
     */
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

    /**
     * Get company profile settings.
     */
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

    /**
     * Get specific setting by key.
     */
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

        return response()->json([
            'success' => true,
            'data' => [
                'key' => $setting->key,
                'value' => $setting->value
            ]
        ]);
    }
}