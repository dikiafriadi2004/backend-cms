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
            ['key' => 'site_logo', 'value' => '', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'admin@kontercms.com', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+62 123 456 789', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'type' => 'string', 'group' => 'general'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'KonterCMS - Content Management System', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'KonterCMS adalah sistem manajemen konten yang powerful dan mudah digunakan', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'cms, laravel, content management, blog', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'google_site_verification', 'value' => '', 'type' => 'string', 'group' => 'seo'],
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
            
            // Company Profile Settings
            ['key' => 'company_name', 'value' => 'KonterCMS Company', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_tagline', 'value' => 'Solusi CMS Terdepan untuk Bisnis Modern', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_description', 'value' => 'KonterCMS adalah platform manajemen konten yang dirancang khusus untuk memenuhi kebutuhan bisnis modern. Dengan fitur-fitur canggih dan antarmuka yang user-friendly, kami membantu Anda mengelola konten website dengan mudah dan efisien.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_about', 'value' => 'Kami adalah tim yang berdedikasi untuk menghadirkan solusi CMS terbaik. Dengan pengalaman bertahun-tahun di bidang teknologi web, kami memahami kebutuhan unik setiap bisnis dan berkomitmen untuk memberikan layanan yang berkualitas tinggi.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_vision', 'value' => 'Menjadi platform CMS terdepan yang memberdayakan bisnis untuk berkembang di era digital dengan solusi yang inovatif dan mudah digunakan.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_mission', 'value' => 'Menyediakan platform CMS yang powerful, user-friendly, dan dapat diandalkan untuk membantu bisnis mengelola konten digital mereka dengan efektif dan efisien.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_address', 'value' => 'Jl. Teknologi Digital No. 123, Jakarta Selatan 12345, Indonesia', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_phone', 'value' => '+62 21 1234 5678', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_email', 'value' => 'info@kontercms.com', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_whatsapp', 'value' => '+62 812 3456 7890', 'type' => 'string', 'group' => 'company'],
            ['key' => 'company_telegram', 'value' => '@kontercms', 'type' => 'string', 'group' => 'company'],
            ['key' => 'telegram_channel', 'value' => '@kontercms_channel', 'type' => 'string', 'group' => 'company'],
            
            // CTA (Call to Action) Settings
            ['key' => 'cta_title', 'value' => 'Siap Memulai dengan KonterCMS?', 'type' => 'string', 'group' => 'company'],
            ['key' => 'cta_subtitle', 'value' => 'Bergabunglah dengan ribuan bisnis yang telah mempercayai KonterCMS', 'type' => 'string', 'group' => 'company'],
            ['key' => 'cta_description', 'value' => 'Dapatkan akses ke semua fitur premium KonterCMS dan mulai kelola website Anda dengan lebih profesional. Tim support kami siap membantu Anda 24/7.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_button_text', 'value' => 'Hubungi Kami Sekarang', 'type' => 'string', 'group' => 'company'],
            ['key' => 'cta_button_url', 'value' => '#contact', 'type' => 'string', 'group' => 'company'],
            ['key' => 'cta_whatsapp_number', 'value' => '6281234567890', 'type' => 'string', 'group' => 'company'],
            ['key' => 'cta_whatsapp_message', 'value' => 'Halo, saya tertarik dengan layanan KonterCMS. Bisakah Anda memberikan informasi lebih lanjut?', 'type' => 'text', 'group' => 'company'],
            
            // Contact Form Settings
            ['key' => 'contact_form_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'contact'],
            ['key' => 'contact_admin_email', 'value' => 'admin@kontercms.com', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'contact_auto_reply', 'value' => '1', 'type' => 'boolean', 'group' => 'contact'],
            ['key' => 'contact_auto_reply_subject', 'value' => 'Terima kasih telah menghubungi kami', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'contact_auto_reply_message', 'value' => 'Terima kasih telah menghubungi KonterCMS. Pesan Anda telah kami terima dan akan segera kami respon dalam 1x24 jam. Tim customer service kami akan menghubungi Anda secepatnya.', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_notification_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'contact'],
            ['key' => 'contact_rate_limit', 'value' => '5', 'type' => 'integer', 'group' => 'contact'],
            ['key' => 'contact_rate_limit_minutes', 'value' => '60', 'type' => 'integer', 'group' => 'contact'],
            
            // Email Settings for Gmail SMTP
            ['key' => 'mail_mailer', 'value' => 'smtp', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_port', 'value' => '587', 'type' => 'integer', 'group' => 'email'],
            ['key' => 'mail_username', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_password', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_encryption', 'value' => 'tls', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_from_address', 'value' => 'noreply@kontercms.com', 'type' => 'string', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => 'KonterCMS', 'type' => 'string', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            // Use updateOrCreate to avoid duplicates when seeding multiple times
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings berhasil di-seed ke database');
        $this->command->info('   - General Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'general')) . ' items');
        $this->command->info('   - SEO Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'seo')) . ' items');
        $this->command->info('   - Social Media Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'social')) . ' items');
        $this->command->info('   - Analytics Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'analytics')) . ' items');
        $this->command->info('   - Company Profile & CTA Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'company')) . ' items');
        $this->command->info('   - Contact Form Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'contact')) . ' items');
        $this->command->info('   - Email Settings: ' . count(array_filter($settings, fn($s) => $s['group'] === 'email')) . ' items');
        $this->command->info('   Total: ' . count($settings) . ' settings');
    }
}