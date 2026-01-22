<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'KonterCMS', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Content Management System dengan Laravel', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'admin@kontercms.com', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+62 123 456 789', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'type' => 'string', 'group' => 'general'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'KonterCMS - Content Management System', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'KonterCMS adalah sistem manajemen konten yang powerful dan mudah digunakan', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'cms, laravel, content management, blog', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'robots_txt', 'value' => "User-agent: *\nDisallow: /admin/\nAllow: /", 'type' => 'text', 'group' => 'seo'],
            
            // Social Media Settings
            ['key' => 'facebook_url', 'value' => '', 'type' => 'string', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'string', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'string', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'string', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'string', 'group' => 'social'],
            
            // Analytics Settings
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'string', 'group' => 'analytics'],
            ['key' => 'google_tag_manager_id', 'value' => '', 'type' => 'string', 'group' => 'analytics'],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'string', 'group' => 'analytics'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}