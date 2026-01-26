@extends('layouts.admin')

@section('title', 'Balas Kontak')

@section('subtitle', 'Kirim balasan profesional untuk pertanyaan kontak')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.contacts.show', $contact) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Kontak
    </a>
</div>
@endsection

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Contact Summary Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900">Balas Pesan dari {{ $contact->name }}</h2>
                <p class="text-sm text-gray-600">{{ $contact->subject }} • {{ $contact->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                    {{ $contact->status === 'new' ? 'bg-blue-100 text-blue-800' : 
                       ($contact->status === 'read' ? 'bg-yellow-100 text-yellow-800' : 
                        ($contact->status === 'replied' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ $contact->status === 'new' ? 'Baru' : ($contact->status === 'read' ? 'Dibaca' : ($contact->status === 'replied' ? 'Dibalas' : ucfirst($contact->status))) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content - 3 Column Grid Layout (2/3 + 1/3) -->
    <form id="reply-form" action="{{ route('admin.contacts.reply.send', $contact) }}" method="POST">
        @csrf
        
        <!-- 3 Column Grid: 2 columns for form (left) and 1 column for sidebar (right) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Reply Form (2/3 width) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Compose Reply</h3>
                                <p class="text-blue-100 text-sm">Tulis balasan profesional</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6 space-y-6">
                        <!-- Recipient -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Kepada</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       value="{{ $contact->name }} <{{ $contact->email }}>" 
                                       readonly>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="space-y-2">
                            <label for="subject" class="block text-sm font-semibold text-gray-700">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="subject"
                                       name="subject"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-300 focus:ring-red-500 @enderror" 
                                       value="{{ old('subject', 'Re: ' . $contact->subject) }}" 
                                       placeholder="Masukkan subjek email..."
                                       required>
                            </div>
                            @error('subject')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 000 2v4a1 1 0 102 0V7a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-semibold text-gray-700">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent @error('message') border-red-300 focus-within:ring-red-500 @enderror">
                                <textarea class="tinymce-editor" 
                                          id="message" 
                                          name="message" 
                                          required>{{ old('message', "<p>Kepada Yth. Bapak/Ibu {$contact->name},</p>

<p>Terima kasih telah menghubungi kami terkait <strong>\"" . $contact->subject . "\"</strong>. Kami telah menerima pesan Anda dan sangat menghargai waktu yang telah Anda luangkan untuk menghubungi kami.</p>

<p>Kami akan meninjau pertanyaan Anda dengan seksama dan akan segera memberikan tanggapan secepatnya. Tim kami berkomitmen untuk memberikan bantuan terbaik kepada Anda.</p>

<p>Apabila Anda memiliki pertanyaan mendesak atau memerlukan bantuan segera, jangan ragu untuk menghubungi kami langsung.</p>

<p>Terima kasih atas kesabaran Anda dan telah mempercayai layanan kami.</p>

<br>

<p><strong>Hormat kami,</strong></p>
<p>" . (setting('company_name') ?: config('app.name')) . "<br>
Tim Customer Service</p>

<hr>

<p style=\"font-size: 12px; color: #666;\">
<strong>Informasi Kontak:</strong><br>
Email: " . (setting('contact_email') ?: config('mail.from.address')) . "<br>
" . (setting('contact_phone') ? "Telepon: " . setting('contact_phone') . "<br>" : "") . "
" . (setting('contact_address') ? "Alamat: " . setting('contact_address') . "<br>" : "") . "
Website: " . config('app.url') . "
</p>") }}</textarea>
                            </div>
                            @error('message')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 000 2v4a1 1 0 102 0V7a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Editor siap digunakan
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.contacts.show', $contact) }}" 
                                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Kirim Balasan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Sidebar (1/3 width) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Kontak
                        </h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <!-- Name -->
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $contact->name }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</p>
                                <a href="mailto:{{ $contact->email }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 mt-1 block break-all">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>

                        @if($contact->phone)
                        <!-- Phone -->
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Telepon</p>
                                <a href="tel:{{ $contact->phone }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 mt-1 block">
                                    {{ $contact->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($contact->company)
                        <!-- Company -->
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Perusahaan</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $contact->company }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Message Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Detail Pesan
                        </h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <!-- Subject -->
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Subjek</p>
                            <p class="text-sm font-semibold text-gray-900 mt-1 break-words">{{ $contact->subject }}</p>
                        </div>

                        <!-- Date -->
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal</p>
                            <p class="text-sm text-gray-700 mt-1">{{ $contact->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Original Message -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Pesan Asli
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 max-h-40 overflow-y-auto">
                            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Help Info -->
                <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Editor</h4>
                            <p class="text-xs text-blue-800 leading-relaxed">Gunakan toolbar editor untuk memformat teks, menambahkan gambar, dan membuat email yang profesional.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// TinyMCE initialization
function checkTinyMCEAvailability() {
    return typeof tinymce !== 'undefined';
}

function initializeTinyMCE() {
    if (!checkTinyMCEAvailability()) {
        console.error('❌ TinyMCE not available');
        return false;
    }
    
    try {
        tinymce.init({
            selector: '#message',
            height: 400,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image link | code',
            branding: false,
            promotion: false,
            statusbar: true,
            plugins_url: false,
            external_plugins: {},
            license_key: 'gpl',
            content_style: `
                body { 
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                    font-size: 14px; 
                    line-height: 1.6; 
                    color: #333;
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 20px;
                }
                img { max-width: 100%; height: auto; }
            `,
            setup: function(editor) {
                editor.on('init', function() {
                    console.log('✅ TinyMCE initialized successfully!');
                });
            }
        });
        return true;
    } catch (error) {
        console.error('❌ Error initializing TinyMCE:', error);
        return false;
    }
}

// Initialize TinyMCE
document.addEventListener('DOMContentLoaded', function() {
    if (checkTinyMCEAvailability()) {
        initializeTinyMCE();
    } else {
        let attempts = 0;
        const maxAttempts = 20;
        const intervalId = setInterval(function() {
            attempts++;
            if (checkTinyMCEAvailability()) {
                clearInterval(intervalId);
                initializeTinyMCE();
            } else if (attempts >= maxAttempts) {
                console.error('❌ TinyMCE not found after', maxAttempts, 'attempts');
                clearInterval(intervalId);
            }
        }, 250);
    }
});

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reply-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
                tinymce.triggerSave();
            }
        });
    }
});
</script>
@endpush