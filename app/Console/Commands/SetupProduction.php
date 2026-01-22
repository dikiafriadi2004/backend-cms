<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kontercms:setup-production {--force : Force setup even if database has data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup KonterCMS for production environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 KonterCMS Production Setup');
        $this->info('================================');

        // Check if database has data
        if (!$this->option('force')) {
            $userCount = DB::table('users')->count();
            if ($userCount > 0) {
                $this->error('❌ Database sudah berisi data!');
                $this->info('   Gunakan --force untuk melanjutkan setup');
                return 1;
            }
        }

        // Confirm production setup
        if (!$this->confirm('Apakah Anda yakin ingin setup KonterCMS untuk production?')) {
            $this->info('Setup dibatalkan.');
            return 0;
        }

        $this->info('');
        $this->info('📦 Menjalankan migrasi database...');
        
        try {
            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✅ Migrasi database berhasil');

            $this->info('');
            $this->info('🌱 Menjalankan seeder production...');
            
            // Run production seeder
            Artisan::call('db:seed', [
                '--class' => 'ProductionSeeder',
                '--force' => true
            ]);

            $this->info('');
            $this->info('🔧 Mengoptimalkan aplikasi...');
            
            // Optimize application
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            
            $this->info('✅ Optimasi aplikasi berhasil');

            $this->info('');
            $this->info('🔗 Membuat symbolic link storage...');
            Artisan::call('storage:link');
            $this->info('✅ Storage link berhasil dibuat');

            $this->info('');
            $this->info('🎉 SETUP PRODUCTION BERHASIL!');
            $this->info('');
            $this->warn('📋 LANGKAH SELANJUTNYA:');
            $this->warn('1. Cek kredensial login yang ditampilkan di atas');
            $this->warn('2. Login ke admin panel: /admin');
            $this->warn('3. Ganti password default');
            $this->warn('4. Konfigurasi pengaturan situs');
            $this->warn('5. Upload logo dan favicon');
            $this->info('');

        } catch (\Exception $e) {
            $this->error('❌ Error during setup: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
