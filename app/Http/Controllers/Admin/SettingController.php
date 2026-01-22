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
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $logoPath, 'string', 'general');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
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
}