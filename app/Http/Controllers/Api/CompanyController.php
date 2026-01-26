<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function profile()
    {
        $settings = Setting::where('group', 'company')->pluck('value', 'key');
        
        // Process and format the data
        $companyProfile = [
            'basic_info' => [
                'name' => $settings['company_name'] ?? '',
                'tagline' => $settings['company_tagline'] ?? '',
                'description' => $settings['company_description'] ?? '',
                'logo' => $this->getImageUrl($settings['company_logo'] ?? null),
                'hero_image' => $this->getImageUrl($settings['company_hero_image'] ?? null),
                'website' => $settings['company_website'] ?? '',
            ],
            'about' => [
                'about_us' => $settings['company_about'] ?? '',
                'vision' => $settings['company_vision'] ?? '',
                'mission' => $settings['company_mission'] ?? '',
            ],
            'contact' => [
                'address' => $settings['company_address'] ?? '',
                'phone' => $settings['company_phone'] ?? '',
                'email' => $settings['company_email'] ?? '',
                'whatsapp' => $settings['company_whatsapp'] ?? '',
                'telegram' => $settings['company_telegram'] ?? '',
            ],
            'statistics' => [
                'established_year' => (int) ($settings['company_established_year'] ?? 0),
                'employees' => (int) ($settings['company_employees'] ?? 0),
                'clients' => (int) ($settings['company_clients'] ?? 0),
                'projects' => (int) ($settings['company_projects'] ?? 0),
                'experience_years' => (int) ($settings['company_experience_years'] ?? 0),
            ],
            'cta' => [
                'title' => $settings['cta_title'] ?? '',
                'subtitle' => $settings['cta_subtitle'] ?? '',
                'description' => $settings['cta_description'] ?? '',
                'button_text' => $settings['cta_button_text'] ?? '',
                'button_url' => $settings['cta_button_url'] ?? '',
                'whatsapp_number' => $settings['cta_whatsapp_number'] ?? '',
                'whatsapp_message' => $settings['cta_whatsapp_message'] ?? '',
            ],
            'pulsa_app' => [
                'name' => $settings['pulsa_app_name'] ?? '',
                'description' => $settings['pulsa_app_description'] ?? '',
                'features' => $this->parseListData($settings['pulsa_app_features'] ?? ''),
                'benefits' => $this->parseListData($settings['pulsa_app_benefits'] ?? ''),
                'pricing' => [
                    'title' => $settings['pulsa_pricing_title'] ?? '',
                    'description' => $settings['pulsa_pricing_description'] ?? '',
                ],
                'demo_url' => $settings['pulsa_demo_url'] ?? '',
                'download_url' => $settings['pulsa_download_url'] ?? '',
                'support_hours' => $settings['pulsa_support_hours'] ?? '',
                'guarantee' => $settings['pulsa_guarantee'] ?? '',
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $companyProfile
        ]);
    }

    public function siteSettings()
    {
        $generalSettings = Setting::where('group', 'general')->pluck('value', 'key');
        $seoSettings = Setting::where('group', 'seo')->pluck('value', 'key');
        $socialSettings = Setting::where('group', 'social')->pluck('value', 'key');

        $settings = [
            'site' => [
                'name' => $generalSettings['site_name'] ?? '',
                'description' => $generalSettings['site_description'] ?? '',
                'logo' => $this->getImageUrl($generalSettings['site_logo'] ?? null),
                'favicon' => $this->getImageUrl($generalSettings['site_favicon'] ?? null),
                'contact_email' => $generalSettings['contact_email'] ?? '',
                'contact_phone' => $generalSettings['contact_phone'] ?? '',
                'contact_address' => $generalSettings['contact_address'] ?? '',
            ],
            'seo' => [
                'meta_title' => $seoSettings['meta_title'] ?? '',
                'meta_description' => $seoSettings['meta_description'] ?? '',
                'meta_keywords' => $seoSettings['meta_keywords'] ?? '',
                'google_site_verification' => $seoSettings['google_site_verification'] ?? '',
            ],
            'social' => [
                'facebook_url' => $socialSettings['facebook_url'] ?? '',
                'twitter_url' => $socialSettings['twitter_url'] ?? '',
                'instagram_url' => $socialSettings['instagram_url'] ?? '',
                'linkedin_url' => $socialSettings['linkedin_url'] ?? '',
                'youtube_url' => $socialSettings['youtube_url'] ?? '',
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function whatsappLink(Request $request)
    {
        $settings = Setting::where('group', 'company')->pluck('value', 'key');
        
        $whatsappNumber = $settings['cta_whatsapp_number'] ?? $settings['company_whatsapp'] ?? '';
        $defaultMessage = $settings['cta_whatsapp_message'] ?? 'Halo, saya tertarik dengan layanan Anda';
        
        // Custom message from request or use default
        $message = $request->get('message', $defaultMessage);
        
        // Clean phone number (remove non-numeric characters except +)
        $cleanNumber = preg_replace('/[^0-9+]/', '', $whatsappNumber);
        
        // Ensure number starts with country code
        if (substr($cleanNumber, 0, 1) === '0') {
            $cleanNumber = '62' . substr($cleanNumber, 1);
        } elseif (substr($cleanNumber, 0, 2) !== '62' && substr($cleanNumber, 0, 1) !== '+') {
            $cleanNumber = '62' . $cleanNumber;
        }
        
        $whatsappUrl = "https://wa.me/{$cleanNumber}?text=" . urlencode($message);
        
        return response()->json([
            'success' => true,
            'data' => [
                'whatsapp_url' => $whatsappUrl,
                'phone_number' => $whatsappNumber,
                'message' => $message
            ]
        ]);
    }

    public function statistics()
    {
        $settings = Setting::where('group', 'company')->pluck('value', 'key');
        
        $statistics = [
            'established_year' => (int) ($settings['company_established_year'] ?? 0),
            'employees' => (int) ($settings['company_employees'] ?? 0),
            'clients' => (int) ($settings['company_clients'] ?? 0),
            'projects' => (int) ($settings['company_projects'] ?? 0),
            'experience_years' => (int) ($settings['company_experience_years'] ?? 0),
        ];

        return response()->json([
            'success' => true,
            'data' => $statistics
        ]);
    }

    private function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return null;
        }

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        return Storage::url($imagePath);
    }

    private function parseListData($data)
    {
        if (!$data) {
            return [];
        }

        // Split by newlines first, then by commas
        $items = preg_split('/[\r\n,]+/', $data);
        
        // Clean and filter empty items
        $items = array_map('trim', $items);
        $items = array_filter($items, function($item) {
            return !empty($item);
        });

        return array_values($items);
    }
}
