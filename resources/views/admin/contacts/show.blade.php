@extends('layouts.admin')

@section('title', 'Detail Kontak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contacts.index') }}" 
                   class="text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Detail Kontak</h1>
            </div>
            <p class="text-gray-600">Lihat dan balas pesan kontak</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Status Update -->
            <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="inline">
                @csrf
                @method('PUT')
                <select name="status" onchange="this.form.submit()" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>Baru</option>
                    <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Dibaca</option>
                    <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Dibalas</option>
                    <option value="archived" {{ $contact->status === 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </form>
            
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                  class="inline" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Message -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Pesan</h2>
                    <div class="flex items-center gap-2">
                        @if($contact->status === 'new')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Baru
                        </span>
                        @elseif($contact->status === 'read')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Dibaca
                        </span>
                        @elseif($contact->status === 'replied')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Dibalas
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Diarsipkan
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $contact->subject }}</h3>
                        <p class="text-sm text-gray-500">{{ $contact->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Reply Button -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Balas Pesan</h2>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('admin.contacts.reply', $contact) }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Balas Pesan
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Info Sidebar -->
        <div class="space-y-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-lg font-medium text-gray-700">
                                    {{ strtoupper(substr($contact->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900">{{ $contact->name }}</div>
                            @if($contact->company)
                            <div class="text-sm text-gray-500">{{ $contact->company }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">
                                {{ $contact->email }}
                            </a>
                        </div>
                        
                        @if($contact->phone)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-800">
                                {{ $contact->phone }}
                            </a>
                        </div>
                        @endif
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $contact->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @if($contact->metadata)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h2>
                
                <div class="space-y-3 text-sm">
                    @foreach($contact->metadata as $key => $value)
                    <div class="flex justify-between">
                        <span class="text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                        <span class="text-gray-900">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection