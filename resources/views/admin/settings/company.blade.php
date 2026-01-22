@extends('layouts.admin')

@section('title', 'Company Profile Settings')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.settings.company.update') }}">
        @csrf
        
        <div class="space-y-6">
            <!-- Company Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Perusahaan</h3>
                    <p class="text-sm text-gray-600">Informasi dasar tentang perusahaan Anda</p>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="company_name" class="form-label">Nama Perusahaan *</label>
                            <input type="text" id="company_name" name="company_name" 
                                   value="{{ old('company_name', $settings['company_name'] ?? '') }}" 
                                   class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_tagline" class="form-label">Tagline</label>
                            <input type="text" id="company_tagline" name="company_tagline" 
                                   value="{{ old('company_tagline', $settings['company_tagline'] ?? '') }}" 
                                   class="form-input" placeholder="Slogan perusahaan">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="company_description" class="form-label">Deskripsi Perusahaan</label>
                        <textarea id="company_description" name="company_description" rows="3" 
                                  class="form-input" placeholder="Deskripsi singkat tentang perusahaan">{{ old('company_description', $settings['company_description'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- About Company -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Tentang Perusahaan</h3>
                    <p class="text-sm text-gray-600">Informasi detail tentang perusahaan</p>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="company_about" class="form-label">Tentang Kami</label>
                        <textarea id="company_about" name="company_about" rows="4" 
                                  class="form-input" placeholder="Ceritakan tentang perusahaan Anda">{{ old('company_about', $settings['company_about'] ?? '') }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="company_vision" class="form-label">Visi</label>
                            <textarea id="company_vision" name="company_vision" rows="3" 
                                      class="form-input" placeholder="Visi perusahaan">{{ old('company_vision', $settings['company_vision'] ?? '') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_mission" class="form-label">Misi</label>
                            <textarea id="company_mission" name="company_mission" rows="3" 
                                      class="form-input" placeholder="Misi perusahaan">{{ old('company_mission', $settings['company_mission'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Kontak</h3>
                    <p class="text-sm text-gray-600">Detail kontak perusahaan</p>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="company_address" class="form-label">Alamat</label>
                        <textarea id="company_address" name="company_address" rows="2" 
                                  class="form-input" placeholder="Alamat lengkap perusahaan">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="company_phone" class="form-label">Telepon</label>
                            <input type="text" id="company_phone" name="company_phone" 
                                   value="{{ old('company_phone', $settings['company_phone'] ?? '') }}" 
                                   class="form-input" placeholder="+62 xxx xxxx xxxx">
                        </div>
                        
                        <div class="form-group">
                            <label for="company_email" class="form-label">Email</label>
                            <input type="email" id="company_email" name="company_email" 
                                   value="{{ old('company_email', $settings['company_email'] ?? '') }}" 
                                   class="form-input" placeholder="info@company.com">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="company_whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" id="company_whatsapp" name="company_whatsapp" 
                                   value="{{ old('company_whatsapp', $settings['company_whatsapp'] ?? '') }}" 
                                   class="form-input" placeholder="628xxxxxxxxx">
                        </div>
                        
                        <div class="form-group">
                            <label for="company_telegram" class="form-label">Telegram</label>
                            <input type="text" id="company_telegram" name="company_telegram" 
                                   value="{{ old('company_telegram', $settings['company_telegram'] ?? '') }}" 
                                   class="form-input" placeholder="@username">
                        </div>
                    </div>
                    
                    <!-- Channel Telegram -->
                    <div class="form-group">
                        <label for="telegram_channel" class="form-label">Channel Telegram</label>
                        <input type="text" id="telegram_channel" name="telegram_channel" 
                               value="{{ old('telegram_channel', $settings['telegram_channel'] ?? '') }}" 
                               class="form-input" placeholder="@channelname atau https://t.me/channelname">
                        <p class="text-xs text-gray-500 mt-1">Masukkan username channel atau link channel Telegram</p>
                    </div>
                </div>
            </div>
            
            <!-- Call to Action Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Call to Action (CTA)</h3>
                    <p class="text-sm text-gray-600">Pengaturan untuk tombol dan ajakan bertindak</p>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="cta_title" class="form-label">Judul CTA</label>
                            <input type="text" id="cta_title" name="cta_title" 
                                   value="{{ old('cta_title', $settings['cta_title'] ?? '') }}" 
                                   class="form-input" placeholder="Siap Memulai Bisnis Pulsa?">
                        </div>
                        
                        <div class="form-group">
                            <label for="cta_subtitle" class="form-label">Subtitle CTA</label>
                            <input type="text" id="cta_subtitle" name="cta_subtitle" 
                                   value="{{ old('cta_subtitle', $settings['cta_subtitle'] ?? '') }}" 
                                   class="form-input" placeholder="Bergabunglah dengan ribuan mitra sukses">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cta_description" class="form-label">Deskripsi CTA</label>
                        <textarea id="cta_description" name="cta_description" rows="3" 
                                  class="form-input" placeholder="Deskripsi singkat untuk meyakinkan pengunjung">{{ old('cta_description', $settings['cta_description'] ?? '') }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="cta_button_text" class="form-label">Teks Tombol</label>
                            <input type="text" id="cta_button_text" name="cta_button_text" 
                                   value="{{ old('cta_button_text', $settings['cta_button_text'] ?? '') }}" 
                                   class="form-input" placeholder="Daftar Sekarang">
                        </div>
                        
                        <div class="form-group">
                            <label for="cta_button_url" class="form-label">URL Tombol</label>
                            <input type="url" id="cta_button_url" name="cta_button_url" 
                                   value="{{ old('cta_button_url', $settings['cta_button_url'] ?? '') }}" 
                                   class="form-input" placeholder="https://daftar.company.com">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="cta_whatsapp_number" class="form-label">Nomor WhatsApp CTA</label>
                            <input type="text" id="cta_whatsapp_number" name="cta_whatsapp_number" 
                                   value="{{ old('cta_whatsapp_number', $settings['cta_whatsapp_number'] ?? '') }}" 
                                   class="form-input" placeholder="628xxxxxxxxx">
                        </div>
                        
                        <div class="form-group">
                            <label for="cta_whatsapp_message" class="form-label">Pesan WhatsApp Default</label>
                            <input type="text" id="cta_whatsapp_message" name="cta_whatsapp_message" 
                                   value="{{ old('cta_whatsapp_message', $settings['cta_whatsapp_message'] ?? '') }}" 
                                   class="form-input" placeholder="Halo, saya tertarik dengan aplikasi server pulsa">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection