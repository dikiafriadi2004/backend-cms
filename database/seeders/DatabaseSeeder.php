<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
            CategoryTagSeeder::class,
            PageSeeder::class,
            SimplePostSeeder::class,
        ]);

        // Create Super Admin User with secure credentials
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@kontercms.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@kontercms.com',
                'password' => Hash::make('KonterCMS@2024!'),
                'status' => true,
                'bio' => 'Super Administrator dengan akses penuh ke sistem KonterCMS',
                'email_verified_at' => now(),
            ]
        );

        // Assign Super Admin role
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        // Create additional admin user for backup
        $backupAdmin = User::firstOrCreate(
            ['email' => 'backup@kontercms.com'],
            [
                'name' => 'Backup Administrator',
                'email' => 'backup@kontercms.com',
                'password' => Hash::make('BackupAdmin@2024!'),
                'status' => true,
                'bio' => 'Administrator cadangan untuk sistem KonterCMS',
                'email_verified_at' => now(),
            ]
        );

        // Assign Admin role to backup user
        if (!$backupAdmin->hasRole('Admin')) {
            $backupAdmin->assignRole('Admin');
        }

        $this->command->info('✅ Super Admin berhasil dibuat:');
        $this->command->info('   Email: admin@kontercms.com');
        $this->command->info('   Password: KonterCMS@2024!');
        $this->command->info('');
        $this->command->info('✅ Backup Admin berhasil dibuat:');
        $this->command->info('   Email: backup@kontercms.com');
        $this->command->info('   Password: BackupAdmin@2024!');
        $this->command->info('');
        $this->command->warn('⚠️  PENTING: Segera ganti password setelah login pertama kali!');
    }
}
