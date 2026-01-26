@extends('layouts.admin')

@section('title', 'Pengaturan Email')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Email</h1>
        <p class="text-gray-600">Konfigurasi SMTP Gmail untuk pengiriman email</p>
    </div>

    <!-- Gmail Setup Guide -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Panduan Setup Gmail SMTP</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Aktifkan 2-Step Verification di akun Gmail Anda</li>
                        <li>Buat App Password khusus untuk aplikasi ini</li>
                        <li>Gunakan App Password sebagai password SMTP (bukan password Gmail)</li>
                        <li>Pastikan "Less secure app access" diaktifkan jika diperlukan</li>
                    </ol>
                    <p class="mt-2">
                        <a href="https://support.google.com/accounts/answer/185833" target="_blank" 
                           class="font-medium underline hover:text-blue-600">
                            Pelajari cara membuat App Password →
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.settings.email.update') }}" class="divide-y divide-gray-200">
            @csrf
            
            <!-- SMTP Configuration -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Konfigurasi SMTP</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_mailer" class="block text-sm font-medium text-gray-700 mb-2">
                            Mail Driver
                        </label>
                        <select id="mail_mailer" name="mail_mailer" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="smtp" {{ old('mail_mailer', $settings['mail_mailer'] ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="log" {{ old('mail_mailer', $settings['mail_mailer'] ?? 'smtp') === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Host
                        </label>
                        <input type="text" id="mail_host" name="mail_host" 
                               value="{{ old('mail_host', $settings['mail_host'] ?? 'smtp.gmail.com') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="smtp.gmail.com">
                    </div>
                    
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-2">
                            SMTP Port
                        </label>
                        <select id="mail_port" name="mail_port" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="587" {{ old('mail_port', $settings['mail_port'] ?? '587') == '587' ? 'selected' : '' }}>587 (TLS)</option>
                            <option value="465" {{ old('mail_port', $settings['mail_port'] ?? '587') == '465' ? 'selected' : '' }}>465 (SSL)</option>
                            <option value="25" {{ old('mail_port', $settings['mail_port'] ?? '587') == '25' ? 'selected' : '' }}>25 (Non-encrypted)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-2">
                            Encryption
                        </label>
                        <select id="mail_encryption" name="mail_encryption" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="tls" {{ old('mail_encryption', $settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ old('mail_encryption', $settings['mail_encryption'] ?? 'tls') === 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ old('mail_encryption', $settings['mail_encryption'] ?? 'tls') === '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Gmail Credentials -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Kredensial Gmail</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-2">
                            Gmail Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="mail_username" name="mail_username" 
                               value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="your-email@gmail.com" required>
                        <p class="mt-1 text-sm text-gray-500">Alamat Gmail yang akan digunakan untuk mengirim email</p>
                    </div>
                    
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-2">
                            App Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="mail_password" name="mail_password" 
                               value="{{ old('mail_password', $settings['mail_password'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="App Password (16 karakter)" required>
                        <p class="mt-1 text-sm text-gray-500">
                            <strong>Bukan password Gmail biasa!</strong> Gunakan App Password yang dibuat khusus untuk aplikasi ini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sender Information -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengirim</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-2">
                            From Address
                        </label>
                        <input type="email" id="mail_from_address" name="mail_from_address" 
                               value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="noreply@kontercms.com">
                        <p class="mt-1 text-sm text-gray-500">Email pengirim yang akan muncul di email</p>
                    </div>
                    
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-2">
                            From Name
                        </label>
                        <input type="text" id="mail_from_name" name="mail_from_name" 
                               value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="KonterCMS">
                        <p class="mt-1 text-sm text-gray-500">Nama pengirim yang akan muncul di email</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="px-6 py-4 bg-gray-50 flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Test Email -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Test Pengiriman Email</h2>
        <p class="text-gray-600 mb-4">Kirim email test untuk memastikan konfigurasi SMTP berfungsi dengan baik</p>
        
        <form method="POST" action="{{ route('admin.settings.email.test') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="test_email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Tujuan
                </label>
                <input type="email" id="test_email" name="test_email" 
                       value="{{ auth()->user()->email }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="test@example.com" required>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                    </svg>
                    Kirim Test Email
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-update encryption based on port selection
document.getElementById('mail_port').addEventListener('change', function() {
    const port = this.value;
    const encryptionSelect = document.getElementById('mail_encryption');
    
    if (port === '587') {
        encryptionSelect.value = 'tls';
    } else if (port === '465') {
        encryptionSelect.value = 'ssl';
    } else if (port === '25') {
        encryptionSelect.value = '';
    }
});
</script>
@endsection