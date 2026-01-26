<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function general()
    {
        $settings = Setting::where('group', 'general')->pluck('value', 'key');
        return view('admin.settings.general', compact('settings'));
    }

    public function seo()
    {
        $settings = Setting::where('group', 'seo')->pluck('value', 'key');
        return view('admin.settings.seo', compact('settings'));
    }

    public function social()
    {
        $settings = Setting::where('group', 'social')->pluck('value', 'key');
        return view('admin.settings.social', compact('settings'));
    }

    public function analytics()
    {
        $settings = Setting::where('group', 'analytics')->pluck('value', 'key');
        return view('admin.settings.analytics', compact('settings'));
    }

    public function company()
    {
        $settings = Setting::where('group', 'company')->pluck('value', 'key');
        return view('admin.settings.company', compact('settings'));
    }

    public function contact()
    {
        $settings = Setting::whereIn('group', ['contact'])->pluck('value', 'key');
        return view('admin.settings.contact', compact('settings'));
    }

    public function email()
    {
        $settings = Setting::where('group', 'email')->pluck('value', 'key');
        return view('admin.settings.email', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|max:255',
            'site_description' => 'nullable',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable',
            'contact_address' => 'nullable'
        ]);

        $settings = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_address' => $request->contact_address
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'string', 'general');
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && \Storage::disk('public')->exists($oldLogo)) {
                \Storage::disk('public')->delete($oldLogo);
            }
            
            $logoPath = $request->file('site_logo')->store('images', 'public');
            Setting::set('site_logo', $logoPath, 'string', 'general');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && \Storage::disk('public')->exists($oldFavicon)) {
                \Storage::disk('public')->delete($oldFavicon);
            }
            
            $faviconPath = $request->file('site_favicon')->store('images', 'public');
            Setting::set('site_favicon', $faviconPath, 'string', 'general');
        }

        return redirect()->route('admin.settings.general')
            ->with('success', 'Pengaturan umum berhasil disimpan.');
    }

    public function updateSeo(Request $request)
    {
        $request->validate([
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable',
            'google_site_verification' => 'nullable',
            'robots_txt' => 'nullable'
        ]);

        $settings = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'google_site_verification' => $request->google_site_verification,
            'robots_txt' => $request->robots_txt
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'string', 'seo');
        }

        return redirect()->route('admin.settings.seo')
            ->with('success', 'Pengaturan SEO berhasil disimpan.');
    }

    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url'
        ]);

        $settings = [
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'string', 'social');
        }

        return redirect()->route('admin.settings.social')
            ->with('success', 'Pengaturan media sosial berhasil disimpan.');
    }

    public function updateAnalytics(Request $request)
    {
        $request->validate([
            'google_analytics_id' => 'nullable',
            'google_tag_manager_id' => 'nullable',
            'facebook_pixel_id' => 'nullable'
        ]);

        $settings = [
            'google_analytics_id' => $request->google_analytics_id,
            'google_tag_manager_id' => $request->google_tag_manager_id,
            'facebook_pixel_id' => $request->facebook_pixel_id
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'string', 'analytics');
        }

        return redirect()->route('admin.settings.analytics')
            ->with('success', 'Pengaturan analytics berhasil disimpan.');
    }

    public function updateCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_tagline' => 'nullable|max:255',
            'company_description' => 'nullable',
            'company_about' => 'nullable',
            'company_vision' => 'nullable',
            'company_mission' => 'nullable',
            'company_address' => 'nullable',
            'company_phone' => 'nullable',
            'company_email' => 'nullable|email',
            'company_whatsapp' => 'nullable',
            'company_telegram' => 'nullable',
            'telegram_channel' => 'nullable|max:255',
            // CTA Settings
            'cta_title' => 'nullable|max:255',
            'cta_subtitle' => 'nullable|max:255',
            'cta_description' => 'nullable',
            'cta_button_text' => 'nullable|max:100',
            'cta_button_url' => 'nullable|url',
            'cta_whatsapp_number' => 'nullable',
            'cta_whatsapp_message' => 'nullable',
        ]);

        $settings = [
            'company_name' => $request->company_name,
            'company_tagline' => $request->company_tagline,
            'company_description' => $request->company_description,
            'company_about' => $request->company_about,
            'company_vision' => $request->company_vision,
            'company_mission' => $request->company_mission,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email,
            'company_whatsapp' => $request->company_whatsapp,
            'company_telegram' => $request->company_telegram,
            'telegram_channel' => $request->telegram_channel,
            // CTA Settings
            'cta_title' => $request->cta_title,
            'cta_subtitle' => $request->cta_subtitle,
            'cta_description' => $request->cta_description,
            'cta_button_text' => $request->cta_button_text,
            'cta_button_url' => $request->cta_button_url,
            'cta_whatsapp_number' => $request->cta_whatsapp_number,
            'cta_whatsapp_message' => $request->cta_whatsapp_message,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'string', 'company');
        }

        return redirect()->route('admin.settings.company')
            ->with('success', 'Pengaturan company profile berhasil disimpan.');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_form_enabled' => 'nullable|boolean',
            'contact_admin_email' => 'required|email',
            'contact_auto_reply' => 'nullable|boolean',
            'contact_auto_reply_subject' => 'nullable|max:255',
            'contact_auto_reply_message' => 'nullable',
            'contact_notification_enabled' => 'nullable|boolean',
            'contact_rate_limit' => 'required|integer|min:1|max:100',
            'contact_rate_limit_minutes' => 'required|integer|min:1|max:1440',
        ]);

        $settings = [
            'contact_form_enabled' => $request->has('contact_form_enabled') ? '1' : '0',
            'contact_admin_email' => $request->contact_admin_email,
            'contact_auto_reply' => $request->has('contact_auto_reply') ? '1' : '0',
            'contact_auto_reply_subject' => $request->contact_auto_reply_subject,
            'contact_auto_reply_message' => $request->contact_auto_reply_message,
            'contact_notification_enabled' => $request->has('contact_notification_enabled') ? '1' : '0',
            'contact_rate_limit' => $request->contact_rate_limit,
            'contact_rate_limit_minutes' => $request->contact_rate_limit_minutes,
        ];

        foreach ($settings as $key => $value) {
            $type = in_array($key, ['contact_form_enabled', 'contact_auto_reply', 'contact_notification_enabled']) ? 'boolean' : 
                   (in_array($key, ['contact_rate_limit', 'contact_rate_limit_minutes']) ? 'integer' : 'string');
            Setting::set($key, $value, $type, 'contact');
        }

        return redirect()->route('admin.settings.contact')
            ->with('success', 'Pengaturan kontak berhasil disimpan.');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|in:smtp,log',
            'mail_host' => 'required_if:mail_mailer,smtp|max:255',
            'mail_port' => 'required_if:mail_mailer,smtp|integer|min:1|max:65535',
            'mail_username' => 'required_if:mail_mailer,smtp|email',
            'mail_password' => 'required_if:mail_mailer,smtp',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|max:255',
        ]);

        $settings = [
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];

        foreach ($settings as $key => $value) {
            $type = $key === 'mail_port' ? 'integer' : 'string';
            Setting::set($key, $value, $type, 'email');
        }

        // Update .env file for immediate effect
        $this->updateEnvFile([
            'MAIL_MAILER' => $request->mail_mailer,
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_ENCRYPTION' => $request->mail_encryption,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => $request->mail_from_name,
        ]);

        return redirect()->route('admin.settings.email')
            ->with('success', 'Pengaturan email berhasil disimpan.');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            \Mail::raw('Ini adalah email test dari KonterCMS. Jika Anda menerima email ini, berarti konfigurasi SMTP sudah benar.', function ($message) use ($request) {
                $message->to($request->test_email)
                        ->subject('Test Email dari KonterCMS');
            });

            return redirect()->route('admin.settings.email')
                ->with('success', 'Email test berhasil dikirim ke ' . $request->test_email);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.email')
                ->with('error', 'Gagal mengirim email test: ' . $e->getMessage());
        }
    }

    private function updateEnvFile($data)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            // Escape the value properly for .env format
            $escapedValue = $this->escapeEnvValue($value);
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$escapedValue}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $envContent);
        
        // Clear config cache to ensure changes take effect
        \Artisan::call('config:clear');
    }

    private function escapeEnvValue($value)
    {
        if (empty($value)) {
            return '';
        }
        
        // If value contains spaces, special characters, or quotes, wrap in double quotes
        if (preg_match('/[\s"\'#]/', $value)) {
            // Escape any existing double quotes
            $value = str_replace('"', '\\"', $value);
            return '"' . $value . '"';
        }
        
        return $value;
    }

    public function emailTemplate()
    {
        $settings = Setting::whereIn('group', ['email', 'contact'])->pluck('value', 'key');
        return view('admin.settings.email-template', compact('settings'));
    }

    public function updateEmailTemplate(Request $request)
    {
        $request->validate([
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email_logo_width' => 'required|integer|min:50|max:500',
            'email_logo_height' => 'required|integer|min:30|max:200',
            'company_address' => 'nullable|string',
            'company_website' => 'nullable|url',
            'response_time' => 'nullable|string|max:255',
            'business_hours' => 'nullable|string'
        ]);

        $settings = [
            'email_logo_width' => $request->email_logo_width,
            'email_logo_height' => $request->email_logo_height,
            'company_address' => $request->company_address,
            'company_website' => $request->company_website,
            'response_time' => $request->response_time,
            'business_hours' => $request->business_hours
        ];

        // Handle logo upload
        if ($request->hasFile('logo_file')) {
            // Delete old logo if exists
            $oldLogo = setting('email_logo_url');
            if ($oldLogo) {
                // Extract path from full URL if needed
                $oldPath = str_replace([config('app.url'), '/storage/'], '', $oldLogo);
                if (\Storage::disk('public')->exists($oldPath)) {
                    \Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Store new logo
            $logoPath = $request->file('logo_file')->store('logos', 'public');
            // Use full URL with domain for email templates
            $settings['email_logo_url'] = config('app.url') . '/storage/' . $logoPath;
        }

        foreach ($settings as $key => $value) {
            $group = in_array($key, ['email_logo_url', 'email_logo_width', 'email_logo_height']) ? 'email' : 'contact';
            Setting::set($key, $value, 'string', $group);
        }

        return redirect()->route('admin.settings.email-template')
            ->with('success', 'Pengaturan template email berhasil disimpan.');
    }

    public function testEmailTemplate(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
            'template_type' => 'required|in:admin,user'
        ]);

        try {
            // Create a dummy contact for testing
            $testContact = new \App\Models\Contact([
                'id' => 999,
                'name' => 'Test User',
                'email' => $request->test_email,
                'phone' => '+62812345678',
                'company' => 'Test Company',
                'subject' => 'Test Email Template',
                'message' => 'Ini adalah pesan test untuk melihat tampilan template email dengan logo dan setting terbaru.',
                'status' => 'new',
                'created_at' => now()
            ]);

            // Send test email
            \Mail::to($request->test_email)->send(new \App\Mail\ContactFormMail($testContact, $request->template_type));

            return redirect()->route('admin.settings.email-template')
                ->with('success', 'Email test berhasil dikirim ke ' . $request->test_email);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.email-template')
                ->with('error', 'Gagal mengirim email test: ' . $e->getMessage());
        }
    }
}