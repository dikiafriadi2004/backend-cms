@extends('layouts.admin')

@section('title', 'Pengaturan Kontak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Kontak</h1>
        <p class="text-gray-600">Kelola pengaturan formulir kontak dan notifikasi</p>
    </div>

    <!-- Settings Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.settings.contact.update') }}" class="divide-y divide-gray-200">
            @csrf
            
            <!-- Contact Form Settings -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Formulir Kontak</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_form_enabled" class="flex items-center">
                            <input type="checkbox" id="contact_form_enabled" name="contact_form_enabled" value="1"
                                   {{ old('contact_form_enabled', $settings['contact_form_enabled'] ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan Formulir Kontak</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan formulir kontak di website</p>
                    </div>
                    
                    <div>
                        <label for="contact_admin_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Admin <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="contact_admin_email" name="contact_admin_email" 
                               value="{{ old('contact_admin_email', $settings['contact_admin_email'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="admin@kontercms.com" required>
                        <p class="mt-1 text-sm text-gray-500">Email yang akan menerima notifikasi kontak masuk</p>
                    </div>
                </div>
            </div>

            <!-- Auto Reply Settings -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Balasan Otomatis</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="contact_auto_reply" class="flex items-center">
                            <input type="checkbox" id="contact_auto_reply" name="contact_auto_reply" value="1"
                                   {{ old('contact_auto_reply', $settings['contact_auto_reply'] ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan Balasan Otomatis</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Kirim email balasan otomatis kepada pengirim</p>
                    </div>
                    
                    <div>
                        <label for="contact_auto_reply_subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subjek Balasan Otomatis
                        </label>
                        <input type="text" id="contact_auto_reply_subject" name="contact_auto_reply_subject" 
                               value="{{ old('contact_auto_reply_subject', $settings['contact_auto_reply_subject'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Terima kasih telah menghubungi kami">
                    </div>
                    
                    <div>
                        <label for="contact_auto_reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                            Pesan Balasan Otomatis
                        </label>
                        <textarea id="contact_auto_reply_message" name="contact_auto_reply_message" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Terima kasih telah menghubungi kami...">{{ old('contact_auto_reply_message', $settings['contact_auto_reply_message'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Notifikasi</h2>
                
                <div>
                    <label for="contact_notification_enabled" class="flex items-center">
                        <input type="checkbox" id="contact_notification_enabled" name="contact_notification_enabled" value="1"
                               {{ old('contact_notification_enabled', $settings['contact_notification_enabled'] ?? true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan Notifikasi Email</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Kirim notifikasi email ke admin saat ada kontak masuk</p>
                </div>
            </div>

            <!-- Rate Limiting Settings -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Rate Limiting</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_rate_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            Maksimal Pengiriman
                        </label>
                        <input type="number" id="contact_rate_limit" name="contact_rate_limit" min="1" max="100"
                               value="{{ old('contact_rate_limit', $settings['contact_rate_limit'] ?? 5) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Jumlah maksimal pengiriman per periode waktu</p>
                    </div>
                    
                    <div>
                        <label for="contact_rate_limit_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                            Periode Waktu (Menit)
                        </label>
                        <input type="number" id="contact_rate_limit_minutes" name="contact_rate_limit_minutes" min="1" max="1440"
                               value="{{ old('contact_rate_limit_minutes', $settings['contact_rate_limit_minutes'] ?? 60) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Periode waktu dalam menit untuk rate limiting</p>
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

    <!-- Test Contact Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Test Formulir Kontak</h2>
        <p class="text-gray-600 mb-4">Gunakan form di bawah ini untuk menguji pengaturan kontak Anda</p>
        
        <form method="POST" action="{{ route('admin.contacts.store') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="test_name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" id="test_name" name="name" value="Test User"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="test_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="test_email" name="email" value="test@example.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label for="test_subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                <input type="text" id="test_subject" name="subject" value="Test Contact Form"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="test_message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                <textarea id="test_message" name="message" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">Ini adalah pesan test untuk menguji formulir kontak.</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Kirim Test
                </button>
            </div>
        </form>
    </div>
</div>
@endsection