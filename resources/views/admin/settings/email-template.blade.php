@extends('layouts.admin')

@section('title', 'Template & Logo Email')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Template & Logo Email</h1>
        <p class="text-gray-600">Konfigurasi tampilan dan logo untuk email yang dikirim</p>
    </div>

    <!-- Logo Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('admin.settings.email-template.update') }}" enctype="multipart/form-data" class="divide-y divide-gray-200">
            @csrf
            
            <!-- Logo Configuration -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Konfigurasi Logo</h2>
                
                <!-- Current Logo Preview -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview Logo Saat Ini</label>
                    <div class="border border-gray-200 rounded-lg p-6 bg-gradient-to-br from-gray-50 to-gray-100 text-center">
                        @if(email_logo_url())
                            <div class="inline-block p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                                <img src="{{ email_logo_url() }}" 
                                     alt="{{ setting('site_name', config('app.name')) }}" 
                                     style="width: {{ setting('email_logo_width', '150') }}px; height: {{ setting('email_logo_height', '60') }}px; object-fit: contain;"
                                     class="mx-auto"
                                     id="logo-preview">
                            </div>
                            <p class="text-sm text-gray-500 mt-3">
                                Ukuran: {{ setting('email_logo_width', '150') }}px × {{ setting('email_logo_height', '60') }}px
                            </p>
                        @else
                            <div class="py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 mt-2">Belum ada logo yang diupload</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Logo Upload -->
                <div class="mb-6">
                    <label for="logo_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Logo Baru
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="logo_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG, SVG (Max. 2MB)</p>
                            </div>
                            <input id="logo_file" name="logo_file" type="file" class="hidden" accept="image/*" onchange="previewLogo(this)">
                        </label>
                    </div>
                </div>
                
                <!-- Logo Size Configuration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email_logo_width" class="block text-sm font-medium text-gray-700 mb-2">
                            Lebar Logo (px)
                        </label>
                        <input type="number" id="email_logo_width" name="email_logo_width" 
                               value="{{ old('email_logo_width', setting('email_logo_width', '150')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="150" min="50" max="500">
                    </div>
                    
                    <div>
                        <label for="email_logo_height" class="block text-sm font-medium text-gray-700 mb-2">
                            Tinggi Logo (px)
                        </label>
                        <input type="number" id="email_logo_height" name="email_logo_height" 
                               value="{{ old('email_logo_height', setting('email_logo_height', '60')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="60" min="30" max="200">
                    </div>
                </div>
                
                <!-- Hidden field for logo URL (will be set after upload) -->
                <input type="hidden" id="email_logo_url" name="email_logo_url" value="{{ setting('email_logo_url') }}">
            </div>

            <!-- Company Information -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Perusahaan</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Perusahaan
                        </label>
                        <textarea id="company_address" name="company_address" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jl. Contoh No. 123, Jakarta 12345, Indonesia">{{ old('company_address', setting('company_address', '')) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Alamat lengkap yang akan ditampilkan di email</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_website" class="block text-sm font-medium text-gray-700 mb-2">
                                Website Perusahaan
                            </label>
                            <input type="url" id="company_website" name="company_website" 
                                   value="{{ old('company_website', setting('company_website', '')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://kontercms.com">
                        </div>
                        
                        <div>
                            <label for="response_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Respon
                            </label>
                            <input type="text" id="response_time" name="response_time" 
                                   value="{{ old('response_time', setting('response_time', '24-48 jam pada hari kerja')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="24-48 jam pada hari kerja">
                        </div>
                    </div>
                    
                    <div>
                        <label for="business_hours" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Operasional
                        </label>
                        <textarea id="business_hours" name="business_hours" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Senin - Jumat: 09:00 - 17:00 WIB&#10;Sabtu: 09:00 - 14:00 WIB&#10;Minggu: Tutup">{{ old('business_hours', setting('business_hours', '')) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Jam operasional yang akan ditampilkan di email konfirmasi</p>
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

    <!-- Email Template Preview -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Preview Template Email</h2>
        <p class="text-gray-600 mb-4">Kirim email test untuk melihat tampilan template dengan logo dan setting terbaru</p>
        
        <form method="POST" action="{{ route('admin.settings.email-template.test') }}" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="test_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Tujuan
                    </label>
                    <input type="email" id="test_email" name="test_email" 
                           value="{{ auth()->user()->email }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="test@example.com" required>
                </div>
                
                <div>
                    <label for="template_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Template
                    </label>
                    <select id="template_type" name="template_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="admin">Email Notifikasi Admin</option>
                        <option value="user">Email Konfirmasi User</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview Template
                </button>
            </div>
        </form>
    </div>

    <!-- Template Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informasi Template Email</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Email Admin:</strong> Dikirim ke admin saat ada kontak baru masuk</li>
                        <li><strong>Email User:</strong> Dikirim ke user sebagai konfirmasi pengiriman pesan</li>
                        <li><strong>Logo:</strong> Akan ditampilkan di bagian atas setiap email</li>
                        <li><strong>Bahasa:</strong> Semua template menggunakan bahasa Indonesia</li>
                        <li><strong>Queue:</strong> Email dikirim langsung tanpa queue (cocok untuk VPS)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview logo upload
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.querySelector('.border.border-gray-200.rounded-lg.p-6.bg-gradient-to-br');
            const width = document.getElementById('email_logo_width').value || '150';
            const height = document.getElementById('email_logo_height').value || '60';
            
            previewContainer.innerHTML = `
                <div class="inline-block p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                    <img src="${e.target.result}" 
                         alt="Logo Preview" 
                         style="width: ${width}px; height: ${height}px; object-fit: contain;"
                         class="mx-auto"
                         id="logo-preview">
                </div>
                <p class="text-sm text-gray-500 mt-3">
                    Ukuran: ${width}px × ${height}px
                </p>
                <p class="text-xs text-blue-600 mt-1">
                    Logo baru akan disimpan setelah klik "Simpan Pengaturan"
                </p>
            `;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Live preview logo size changes
document.getElementById('email_logo_width').addEventListener('input', updateLogoPreview);
document.getElementById('email_logo_height').addEventListener('input', updateLogoPreview);

function updateLogoPreview() {
    const width = document.getElementById('email_logo_width').value || '150';
    const height = document.getElementById('email_logo_height').value || '60';
    
    const previewImg = document.getElementById('logo-preview');
    const previewText = document.querySelector('.text-sm.text-gray-500.mt-3');
    
    if (previewImg) {
        previewImg.style.width = width + 'px';
        previewImg.style.height = height + 'px';
    }
    
    if (previewText) {
        previewText.innerHTML = `Ukuran: ${width}px × ${height}px`;
    }
}

// Drag and drop functionality
const dropZone = document.querySelector('label[for="logo_file"]');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-500', 'bg-blue-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('logo_file').files = files;
        previewLogo(document.getElementById('logo_file'));
    }
});
</script>
@endsection