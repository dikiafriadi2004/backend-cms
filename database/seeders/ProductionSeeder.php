<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductionSeeder extends Seeder
{
    /**
     * Seed the application's database for production environment.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding untuk production...');

        // Check if permissions already exist
        $permissionCount = \Spatie\Permission\Models\Permission::count();
        if ($permissionCount == 0) {
            // Seed permissions and roles first
            $this->call([
                PermissionSeeder::class,
            ]);
        } else {
            $this->command->info('✅ Permissions sudah ada, skip seeding permissions');
        }

        // Create Super Admin with secure random password
        $adminPassword = $this->generateSecurePassword();
        
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@kontercms.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@kontercms.com',
                'password' => Hash::make($adminPassword),
                'status' => true,
                'bio' => 'Super Administrator KonterCMS',
                'email_verified_at' => now(),
            ]
        );

        // Assign Super Admin role
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        // Create default categories
        $categories = [
            ['name' => 'Berita', 'slug' => 'berita', 'description' => 'Kategori untuk berita terkini', 'color' => '#3b82f6'],
            ['name' => 'Artikel', 'slug' => 'artikel', 'description' => 'Kategori untuk artikel informatif', 'color' => '#10b981'],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'description' => 'Kategori untuk tutorial dan panduan', 'color' => '#f59e0b'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Kategori untuk pengumuman resmi', 'color' => '#ef4444'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Create default tags
        $tags = [
            ['name' => 'Penting', 'slug' => 'penting', 'color' => '#ef4444'],
            ['name' => 'Trending', 'slug' => 'trending', 'color' => '#f59e0b'],
            ['name' => 'Tips', 'slug' => 'tips', 'color' => '#10b981'],
            ['name' => 'Update', 'slug' => 'update', 'color' => '#3b82f6'],
            ['name' => 'Event', 'slug' => 'event', 'color' => '#8b5cf6'],
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate(
                ['slug' => $tagData['slug']],
                $tagData
            );
        }

        // Create essential settings
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'KonterCMS', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Sistem Manajemen Konten Profesional', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_keywords', 'value' => 'cms, content management, laravel, php', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_author', 'value' => 'KonterCMS Team', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'admin@kontercms.com', 'type' => 'email', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@kontercms.com', 'type' => 'email', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+62 812 3456 7890', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'type' => 'text', 'group' => 'general'],
            ['key' => 'posts_per_page', 'value' => '10', 'type' => 'number', 'group' => 'general'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'general'],
            ['key' => 'allow_registration', 'value' => '0', 'type' => 'boolean', 'group' => 'general'],
            ['key' => 'default_user_role', 'value' => 'Author', 'type' => 'text', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Asia/Jakarta', 'type' => 'text', 'group' => 'general'],
            ['key' => 'date_format', 'value' => 'd M Y', 'type' => 'text', 'group' => 'general'],
            ['key' => 'time_format', 'value' => 'H:i', 'type' => 'text', 'group' => 'general'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'KonterCMS - Sistem Manajemen Konten Profesional', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Platform CMS terdepan untuk mengelola konten website dengan mudah dan profesional', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'cms, content management, laravel, php, website, blog', 'type' => 'text', 'group' => 'seo'],
            
            // Company Profile Settings
            ['key' => 'company_name', 'value' => 'PulsaServer Indonesia', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_tagline', 'value' => 'Solusi Server Pulsa Terpercaya #1 di Indonesia', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_description', 'value' => 'Kami adalah penyedia layanan server pulsa terdepan di Indonesia dengan teknologi canggih dan dukungan 24/7. Bergabunglah dengan ribuan mitra sukses kami.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_about', 'value' => 'PulsaServer Indonesia didirikan dengan visi menjadi platform server pulsa terdepan yang memberikan kemudahan dan keuntungan maksimal bagi para mitra. Dengan pengalaman lebih dari 5 tahun, kami telah melayani ribuan mitra di seluruh Indonesia dengan sistem yang stabil dan harga yang kompetitif.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_vision', 'value' => 'Menjadi platform server pulsa terdepan di Indonesia yang memberikan solusi terbaik untuk bisnis pulsa dan PPOB.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_mission', 'value' => 'Memberikan layanan server pulsa berkualitas tinggi dengan harga kompetitif, sistem yang stabil, dan dukungan pelanggan terbaik untuk kesuksesan mitra.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_website', 'value' => 'https://pulsaserver.id', 'type' => 'text', 'group' => 'company'],
            
            // Contact Information
            ['key' => 'company_address', 'value' => 'Jl. Sudirman No. 123, Jakarta Pusat 10220, Indonesia', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_phone', 'value' => '+62 21 1234 5678', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_email', 'value' => 'info@pulsaserver.id', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_whatsapp', 'value' => '6281234567890', 'type' => 'text', 'group' => 'company'],
            ['key' => 'company_telegram', 'value' => '@pulsaserver_id', 'type' => 'text', 'group' => 'company'],
            
            // Company Statistics
            ['key' => 'company_established_year', 'value' => '2019', 'type' => 'number', 'group' => 'company'],
            ['key' => 'company_employees', 'value' => '25', 'type' => 'number', 'group' => 'company'],
            ['key' => 'company_clients', 'value' => '5000', 'type' => 'number', 'group' => 'company'],
            ['key' => 'company_projects', 'value' => '10000', 'type' => 'number', 'group' => 'company'],
            ['key' => 'company_experience_years', 'value' => '5', 'type' => 'number', 'group' => 'company'],
            
            // CTA Settings
            ['key' => 'cta_title', 'value' => 'Siap Memulai Bisnis Pulsa?', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_subtitle', 'value' => 'Bergabunglah dengan 5000+ mitra sukses kami', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_description', 'value' => 'Dapatkan akses ke sistem server pulsa terbaik dengan harga kompetitif, transaksi cepat, dan dukungan 24/7. Mulai bisnis pulsa Anda hari ini!', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_button_text', 'value' => 'Daftar Sekarang', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_button_url', 'value' => 'https://pulsaserver.id/daftar', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_whatsapp_number', 'value' => '6281234567890', 'type' => 'text', 'group' => 'company'],
            ['key' => 'cta_whatsapp_message', 'value' => 'Halo, saya tertarik untuk bergabung sebagai mitra PulsaServer Indonesia. Mohon informasi lebih lanjut.', 'type' => 'text', 'group' => 'company'],
            
            // Server Pulsa Specific Settings
            ['key' => 'pulsa_app_name', 'value' => 'PulsaServer Pro', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_app_description', 'value' => 'Aplikasi server pulsa all-in-one dengan fitur lengkap untuk mengelola bisnis pulsa, token listrik, dan PPOB dengan mudah dan efisien.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_app_features', 'value' => "Multi Operator (Telkomsel, Indosat, XL, Tri, Smartfren)\nPPOB Lengkap (PLN, PDAM, Internet, TV Kabel)\nHarga Real Time & Kompetitif\nTransaksi Via SMS, WhatsApp, Web\nLaporan Transaksi Detail\nManajemen Downline\nDeposit Otomatis\nCustom Markup Harga", 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_app_benefits', 'value' => "Modal Mulai 100rb\nKomisi Hingga 15%\nTransaksi 24/7 Non-Stop\nServer Stabil 99.9% Uptime\nCS Responsif 24/7\nTraining & Panduan Lengkap\nUpdate Fitur Berkala\nGaransi Uang Kembali", 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_pricing_title', 'value' => 'Paket Berlangganan Terjangkau', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_pricing_description', 'value' => 'Pilih paket yang sesuai dengan kebutuhan bisnis Anda. Semua paket sudah termasuk akses penuh ke semua fitur.', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_demo_url', 'value' => 'https://demo.pulsaserver.id', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_download_url', 'value' => 'https://pulsaserver.id/download', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_support_hours', 'value' => '24/7', 'type' => 'text', 'group' => 'company'],
            ['key' => 'pulsa_guarantee', 'value' => 'Garansi uang kembali 100% dalam 7 hari', 'type' => 'text', 'group' => 'company'],
            
            // Social Media Settings
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/pulsaserver.id', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/pulsaserver_id', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/pulsaserver.id', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/pulsaserver-indonesia', 'type' => 'text', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@pulsaserver', 'type' => 'text', 'group' => 'social'],
        ];

        foreach ($settings as $settingData) {
            Setting::firstOrCreate(
                ['key' => $settingData['key']],
                $settingData
            );
        }

        // Create default menu
        $this->call([
            MenuSeeder::class,
        ]);

        // Display credentials
        $this->command->info('');
        $this->command->info('🎉 Production seeding berhasil!');
        $this->command->info('');
        $this->command->info('📋 KREDENSIAL LOGIN:');
        $this->command->info('   Email: admin@kontercms.com');
        $this->command->info('   Password: ' . $adminPassword);
        $this->command->info('');
        $this->command->warn('⚠️  PENTING:');
        $this->command->warn('   1. SIMPAN password di tempat yang aman!');
        $this->command->warn('   2. GANTI password setelah login pertama kali!');
        $this->command->warn('   3. HAPUS file log yang berisi password ini!');
        $this->command->info('');
        $this->command->info('✅ Kategori default: Berita, Artikel, Tutorial, Pengumuman');
        $this->command->info('✅ Tag default: Penting, Trending, Tips, Update, Event');
        $this->command->info('✅ Pengaturan dasar telah dikonfigurasi');
    }

    /**
     * Generate secure random password
     */
    private function generateSecurePassword(): string
    {
        $length = 16;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        // Ensure at least one character from each type
        $password .= chr(rand(97, 122)); // lowercase
        $password .= chr(rand(65, 90));  // uppercase
        $password .= chr(rand(48, 57));  // number
        $password .= '!@#$%^&*'[rand(0, 7)]; // special char
        
        // Fill the rest randomly
        for ($i = 4; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return str_shuffle($password);
    }
}