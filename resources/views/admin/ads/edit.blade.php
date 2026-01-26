@extends('layouts.admin')

@section('title', 'Edit Iklan')

@section('content')
<div class="ads-form-container">
    <!-- Ultra Modern Header -->
    <div class="form-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-content">
                        <div class="header-badge">
                            <i class="fas fa-edit"></i>
                            <span>Ads Editor</span>
                        </div>
                        <h1 class="header-title">
                            Edit Iklan: {{ $ad->name }}
                        </h1>
                        <p class="header-subtitle">
                            Perbarui pengaturan dan konfigurasi iklan dengan mudah
                        </p>
                        <div class="ad-status-info">
                            <div class="status-item">
                                <span class="status-label">Status:</span>
                                <span class="status-badge status-{{ $ad->status ? 'active' : 'inactive' }}">
                                    <i class="fas fa-{{ $ad->status ? 'check-circle' : 'pause-circle' }}"></i>
                                    {{ $ad->status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Tipe:</span>
                                <span class="type-badge type-{{ $ad->type }}">
                                    <i class="fas fa-{{ 
                                        $ad->type === 'manual_banner' ? 'image' : 
                                        ($ad->type === 'manual_text' ? 'link' : 
                                        ($ad->type === 'adsense' ? 'google' : 'code')) 
                                    }}"></i>
                                    {{ \App\Models\AdSpace::TYPES[$ad->type] ?? $ad->type }}
                                </span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Performa:</span>
                                <span class="performance-summary">
                                    {{ number_format($ad->view_count) }} views • {{ number_format($ad->click_count) }} clicks • {{ $ad->getClickThroughRate() }}% CTR
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="header-actions">
                        <a href="{{ route('admin.ads.analytics', $ad) }}" class="btn-analytics">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                        <a href="{{ route('admin.ads.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="form-main">
        <div class="container-fluid">
            <form action="{{ route('admin.ads.update', $ad) }}" method="POST" class="ultra-form">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-info-circle"></i>
                                    Informasi Dasar
                                </h3>
                                <p class="section-description">Pengaturan dasar dan identitas iklan</p>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group-modern full-width">
                                    <div class="input-wrapper">
                                        <input type="text" class="form-input @error('name') error @enderror" 
                                               id="name" name="name" value="{{ old('name', $ad->name) }}" required>
                                        <label for="name" class="form-label">
                                            <span class="label-text">Nama Iklan</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-border"></div>
                                    </div>
                                    @error('name')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                    <div class="field-help">
                                        <i class="fas fa-lightbulb"></i>
                                        Nama internal untuk identifikasi (tidak ditampilkan ke pengunjung)
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group-modern">
                                        <div class="input-wrapper">
                                            <select class="form-input @error('position') error @enderror" 
                                                    id="position" name="position" required>
                                                <option value="">Pilih Posisi</option>
                                                @foreach($positions as $key => $value)
                                                    <option value="{{ $key }}" {{ old('position', $ad->position) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="position" class="form-label">
                                                <span class="label-text">Posisi Iklan</span>
                                                <span class="label-required">*</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('position')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <div class="input-wrapper">
                                            <input type="number" class="form-input @error('sort_order') error @enderror" 
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $ad->sort_order) }}" min="0">
                                            <label for="sort_order" class="form-label">
                                                <span class="label-text">Urutan Tampil</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('sort_order')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                        <div class="field-help">
                                            <i class="fas fa-sort-numeric-down"></i>
                                            Angka kecil akan ditampilkan lebih dulu
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ad Type Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-layer-group"></i>
                                    Tipe Iklan
                                </h3>
                                <p class="section-description">Ubah jenis iklan dan konfigurasinya</p>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group-modern full-width">
                                    <div class="input-wrapper">
                                        <select class="form-input @error('type') error @enderror" 
                                                id="type" name="type" required onchange="toggleAdFields()">
                                            <option value="">Pilih Tipe Iklan</option>
                                            @foreach($types as $key => $value)
                                                <option value="{{ $key }}" {{ old('type', $ad->type) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="type" class="form-label">
                                            <span class="label-text">Tipe Iklan</span>
                                            <span class="label-required">*</span>
                                        </label>
                                        <div class="input-border"></div>
                                    </div>
                                    @error('type')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Content Based on Ad Type -->
                        <div id="dynamicContent">
                            <!-- Manual Banner Fields -->
                            <div id="manual-banner-fields" class="form-section" style="display: none;">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="fas fa-image"></i>
                                        Pengaturan Banner
                                    </h3>
                                    <p class="section-description">Konfigurasi gambar banner dan dimensinya</p>
                                </div>
                                
                                <div class="form-grid">
                                    @if($ad->image_url)
                                        <div class="current-preview full-width">
                                            <div class="preview-header">
                                                <h4>Preview Saat Ini</h4>
                                            </div>
                                            <div class="preview-container">
                                                <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text }}" 
                                                     class="preview-image">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="form-group-modern full-width">
                                        <div class="input-wrapper">
                                            <input type="url" class="form-input @error('image_url') error @enderror" 
                                                   id="image_url" name="image_url" value="{{ old('image_url', $ad->image_url) }}">
                                            <label for="image_url" class="form-label">
                                                <span class="label-text">URL Gambar</span>
                                                <span class="label-required">*</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('image_url')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                        <div class="field-help">
                                            <i class="fas fa-link"></i>
                                            URL gambar banner yang akan ditampilkan
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <input type="number" class="form-input @error('width') error @enderror" 
                                                       id="width" name="width" value="{{ old('width', $ad->width) }}" min="1">
                                                <label for="width" class="form-label">
                                                    <span class="label-text">Lebar (px)</span>
                                                    <span class="label-required">*</span>
                                                </label>
                                                <div class="input-border"></div>
                                            </div>
                                            @error('width')
                                                <div class="field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <input type="number" class="form-input @error('height') error @enderror" 
                                                       id="height" name="height" value="{{ old('height', $ad->height) }}" min="1">
                                                <label for="height" class="form-label">
                                                    <span class="label-text">Tinggi (px)</span>
                                                    <span class="label-required">*</span>
                                                </label>
                                                <div class="input-border"></div>
                                            </div>
                                            @error('height')
                                                <div class="field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="preset-sizes full-width">
                                        <h5>Ukuran Standar</h5>
                                        <div class="size-grid">
                                            @foreach($bannerSizes as $name => $size)
                                                <button type="button" class="size-preset" 
                                                        onclick="setSize({{ $size['width'] }}, {{ $size['height'] }})">
                                                    <span class="size-name">{{ ucwords(str_replace('_', ' ', $name)) }}</span>
                                                    <span class="size-dim">{{ $size['width'] }}×{{ $size['height'] }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <input type="url" class="form-input @error('link_url') error @enderror" 
                                                       id="link_url" name="link_url" value="{{ old('link_url', $ad->link_url) }}">
                                                <label for="link_url" class="form-label">
                                                    <span class="label-text">Link Tujuan</span>
                                                </label>
                                                <div class="input-border"></div>
                                            </div>
                                            @error('link_url')
                                                <div class="field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-input @error('alt_text') error @enderror" 
                                                       id="alt_text" name="alt_text" value="{{ old('alt_text', $ad->alt_text) }}">
                                                <label for="alt_text" class="form-label">
                                                    <span class="label-text">Alt Text</span>
                                                </label>
                                                <div class="input-border"></div>
                                            </div>
                                            @error('alt_text')
                                                <div class="field-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Text Fields -->
                            <div id="manual-text-fields" class="form-section" style="display: none;">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="fas fa-link"></i>
                                        Pengaturan Text Link
                                    </h3>
                                    <p class="section-description">Konfigurasi teks dan link tujuan</p>
                                </div>
                                
                                <div class="form-grid">
                                    <div class="form-group-modern full-width">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-input @error('title') error @enderror" 
                                                   id="title" name="title" value="{{ old('title', $ad->title) }}">
                                            <label for="title" class="form-label">
                                                <span class="label-text">Judul Link</span>
                                                <span class="label-required">*</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('title')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group-modern full-width">
                                        <div class="input-wrapper">
                                            <textarea class="form-input @error('description') error @enderror" 
                                                      id="description" name="description" rows="3">{{ old('description', $ad->description) }}</textarea>
                                            <label for="description" class="form-label">
                                                <span class="label-text">Deskripsi</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('description')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group-modern full-width">
                                        <div class="input-wrapper">
                                            <input type="url" class="form-input @error('link_url') error @enderror" 
                                                   id="link_url_text" name="link_url" value="{{ old('link_url', $ad->link_url) }}">
                                            <label for="link_url_text" class="form-label">
                                                <span class="label-text">Link Tujuan</span>
                                                <span class="label-required">*</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('link_url')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Code Fields for AdSense/Adsera -->
                            <div id="code-fields" class="form-section" style="display: none;">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="fas fa-code"></i>
                                        Kode Iklan
                                    </h3>
                                    <p class="section-description">Paste kode iklan dari dashboard provider</p>
                                </div>
                                
                                <div class="form-grid">
                                    <div class="form-group-modern full-width">
                                        <div class="input-wrapper">
                                            <textarea class="form-input code-input @error('code') error @enderror" 
                                                      id="code" name="code" rows="12">{{ old('code', $ad->code) }}</textarea>
                                            <label for="code" class="form-label">
                                                <span class="label-text">Kode Iklan</span>
                                                <span class="label-required">*</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('code')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                        <div class="field-help">
                                            <i class="fas fa-info-circle"></i>
                                            Copy kode lengkap dari dashboard provider iklan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Settings -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-calendar-alt"></i>
                                    Jadwal Tayang
                                </h3>
                                <p class="section-description">Atur periode aktif iklan</p>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-row">
                                    <div class="form-group-modern">
                                        <div class="input-wrapper">
                                            <input type="datetime-local" class="form-input @error('start_date') error @enderror" 
                                                   id="start_date" name="start_date" 
                                                   value="{{ old('start_date', $ad->start_date ? $ad->start_date->format('Y-m-d\TH:i') : '') }}">
                                            <label for="start_date" class="form-label">
                                                <span class="label-text">Tanggal Mulai</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('start_date')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                        <div class="field-help">
                                            <i class="fas fa-play"></i>
                                            Kosongkan untuk mulai sekarang
                                        </div>
                                    </div>

                                    <div class="form-group-modern">
                                        <div class="input-wrapper">
                                            <input type="datetime-local" class="form-input @error('end_date') error @enderror" 
                                                   id="end_date" name="end_date" 
                                                   value="{{ old('end_date', $ad->end_date ? $ad->end_date->format('Y-m-d\TH:i') : '') }}">
                                            <label for="end_date" class="form-label">
                                                <span class="label-text">Tanggal Berakhir</span>
                                            </label>
                                            <div class="input-border"></div>
                                        </div>
                                        @error('end_date')
                                            <div class="field-error">{{ $message }}</div>
                                        @enderror
                                        <div class="field-help">
                                            <i class="fas fa-stop"></i>
                                            Kosongkan untuk tayang permanen
                                        </div>
                                    </div>
                                </div>
                                
                                @if($ad->end_date && $ad->daysRemaining() !== null)
                                    <div class="schedule-alert">
                                        <i class="fas fa-clock"></i>
                                        <span><strong>{{ $ad->daysRemaining() }} hari lagi</strong> iklan ini akan berakhir</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Performance Stats -->
                        <div class="sidebar-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-chart-line"></i>
                                    Performa Saat Ini
                                </h3>
                            </div>
                            
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-icon bg-gradient-info">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-value">{{ number_format($ad->view_count) }}</div>
                                        <div class="stat-label">Total Views</div>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon bg-gradient-success">
                                        <i class="fas fa-mouse-pointer"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-value">{{ number_format($ad->click_count) }}</div>
                                        <div class="stat-label">Total Clicks</div>
                                    </div>
                                </div>
                                
                                <div class="stat-item full-width">
                                    <div class="stat-icon bg-gradient-warning">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-value">{{ $ad->getClickThroughRate() }}%</div>
                                        <div class="stat-label">Click Through Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="sidebar-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-cog"></i>
                                    Pengaturan
                                </h3>
                            </div>
                            
                            <div class="settings-grid">
                                <div class="switch-group">
                                    <input type="checkbox" class="switch-input" id="status" name="status" value="1" 
                                           {{ old('status', $ad->status) ? 'checked' : '' }}>
                                    <label for="status" class="switch-label">
                                        <span class="switch-slider"></span>
                                        <span class="switch-text">Aktifkan Iklan</span>
                                    </label>
                                </div>
                                
                                <div class="switch-group">
                                    <input type="checkbox" class="switch-input" id="open_new_tab" name="open_new_tab" value="1" 
                                           {{ old('open_new_tab', $ad->open_new_tab) ? 'checked' : '' }}>
                                    <label for="open_new_tab" class="switch-label">
                                        <span class="switch-slider"></span>
                                        <span class="switch-text">Buka di Tab Baru</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="sidebar-section">
                            <div class="action-buttons">
                                <button type="submit" class="btn-success full-width">
                                    <i class="fas fa-save"></i>
                                    <span>Update Iklan</span>
                                </button>
                                
                                <a href="{{ route('admin.ads.index') }}" class="btn-secondary full-width">
                                    <i class="fas fa-times"></i>
                                    <span>Batal</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form based on current ad type
    toggleAdFields();
    
    // Form input animations
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Check if input has value on load
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
});

function toggleAdFields() {
    const type = document.getElementById('type').value;
    const manualBannerFields = document.getElementById('manual-banner-fields');
    const manualTextFields = document.getElementById('manual-text-fields');
    const codeFields = document.getElementById('code-fields');
    
    // Hide all fields first
    manualBannerFields.style.display = 'none';
    manualTextFields.style.display = 'none';
    codeFields.style.display = 'none';
    
    // Reset required fields
    document.getElementById('image_url').required = false;
    document.getElementById('width').required = false;
    document.getElementById('height').required = false;
    document.getElementById('title').required = false;
    document.getElementById('link_url_text').required = false;
    document.getElementById('code').required = false;
    
    if (type === 'manual_banner') {
        manualBannerFields.style.display = 'block';
        document.getElementById('image_url').required = true;
        document.getElementById('width').required = true;
        document.getElementById('height').required = true;
    } else if (type === 'manual_text') {
        manualTextFields.style.display = 'block';
        document.getElementById('title').required = true;
        document.getElementById('link_url_text').required = true;
    } else if (type === 'adsense' || type === 'adsera') {
        codeFields.style.display = 'block';
        document.getElementById('code').required = true;
        
        // Update section title based on type
        const sectionTitle = codeFields.querySelector('.section-title');
        if (type === 'adsense') {
            sectionTitle.innerHTML = '<i class="fab fa-google"></i>Kode Google AdSense';
        } else {
            sectionTitle.innerHTML = '<i class="fas fa-code"></i>Kode Adsera';
        }
    }
}

function setSize(width, height) {
    document.getElementById('width').value = width;
    document.getElementById('height').value = height;
    
    // Add visual feedback
    event.target.style.transform = 'scale(0.95)';
    setTimeout(() => {
        event.target.style.transform = 'scale(1)';
    }, 150);
}
</script>

<!-- Include the same ultra-modern CSS from create form -->
<style>
/* Ultra Modern Ads Editor Styling */
:root {
    --primary-color: #6366f1;
    --primary-light: #a5b4fc;
    --primary-dark: #4338ca;
    --success-color: #10b981;
    --success-light: #6ee7b7;
    --warning-color: #f59e0b;
    --warning-light: #fcd34d;
    --info-color: #06b6d4;
    --info-light: #67e8f9;
    --danger-color: #ef4444;
    --danger-light: #fca5a5;
    --secondary-color: #6b7280;
    --secondary-light: #d1d5db;
    --dark-color: #1f2937;
    --light-color: #f9fafb;
    --border-radius: 16px;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Main Container */
.ads-form-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
    overflow-x: hidden;
}

.ads-form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 300px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--info-color) 100%);
    opacity: 0.1;
    z-index: 0;
}

/* Ultra Modern Header */
.form-header {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding: 2rem 0;
    position: relative;
    z-index: 10;
    box-shadow: var(--shadow-lg);
}

.header-content {
    position: relative;
}

.header-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--success-color), var(--success-light));
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-md);
}

.header-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 1.125rem;
    color: var(--secondary-color);
    margin-bottom: 1.5rem;
    font-weight: 500;
}

/* Ad Status Info */
.ad-status-info {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    align-items: center;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--secondary-color);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-active {
    background: linear-gradient(135deg, var(--success-color), var(--success-light));
    color: white;
}

.status-inactive {
    background: linear-gradient(135deg, var(--warning-color), var(--warning-light));
    color: white;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
}

.performance-summary {
    font-size: 0.875rem;
    color: var(--dark-color);
    font-weight: 500;
}

/* Header Actions */
.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-analytics {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--info-color), var(--info-light));
    border: 2px solid var(--info-color);
    border-radius: 12px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-analytics:hover {
    background: linear-gradient(135deg, var(--info-light), var(--info-color));
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
    color: white;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(107, 114, 128, 0.2);
    border-radius: 12px;
    color: var(--secondary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-back:hover {
    background: white;
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

/* Main Form */
.form-main {
    padding: 3rem 0;
    position: relative;
    z-index: 5;
}

.ultra-form {
    position: relative;
}

/* Form Sections */
.form-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--info-color), var(--success-color));
}

.sidebar-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.section-header {
    margin-bottom: 2rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.section-title i {
    color: var(--primary-color);
}

.section-description {
    color: var(--secondary-color);
    font-size: 0.875rem;
}

/* Form Grid and Inputs */
.form-grid {
    display: grid;
    gap: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group-modern {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group-modern.full-width {
    grid-column: 1 / -1;
}

.input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 1.25rem 1rem 0.75rem;
    border: 2px solid rgba(229, 231, 235, 0.5);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    font-weight: 500;
    color: var(--dark-color);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-input.error {
    border-color: var(--danger-color);
    background: rgba(239, 68, 68, 0.05);
}

.form-label {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--secondary-color);
    font-weight: 600;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
    padding: 0 0.25rem;
}

.input-wrapper.focused .form-label,
.form-input:focus + .form-label,
.form-input:not(:placeholder-shown) + .form-label {
    top: 0;
    font-size: 0.75rem;
    color: var(--primary-color);
    background: white;
    padding: 0 0.5rem;
}

.label-required {
    color: var(--danger-color);
}

.input-border {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--info-color));
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.form-input:focus ~ .input-border {
    width: 100%;
}

/* Field Help and Errors */
.field-help {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    font-size: 0.875rem;
    color: var(--secondary-color);
}

.field-help i {
    color: var(--info-color);
}

.field-error {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    color: var(--danger-color);
    font-size: 0.875rem;
    font-weight: 600;
}

/* Current Preview */
.current-preview {
    margin-bottom: 2rem;
}

.preview-header h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 1rem;
}

.preview-container {
    background: rgba(248, 250, 252, 0.8);
    border: 1px solid rgba(229, 231, 235, 0.5);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: var(--shadow-md);
}

/* Preset Sizes */
.preset-sizes h5 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 1rem;
}

.size-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.75rem;
}

.size-preset {
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.size-preset:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.size-name {
    display: block;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.size-dim {
    display: block;
    opacity: 0.8;
}

/* Code Input */
.code-input {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 0.875rem;
    line-height: 1.6;
}

/* Schedule Alert */
.schedule-alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: 8px;
    padding: 1rem;
    color: var(--warning-color);
    font-weight: 600;
    margin-top: 1rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(248, 250, 252, 0.8);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(229, 231, 235, 0.3);
}

.stat-item.full-width {
    grid-column: 1 / -1;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--secondary-color);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.05em;
}

/* Settings Grid */
.settings-grid {
    display: grid;
    gap: 1.5rem;
}

/* Form Switches */
.switch-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.switch-input {
    display: none;
}

.switch-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-weight: 600;
    color: var(--dark-color);
}

.switch-slider {
    width: 48px;
    height: 24px;
    background: #e5e7eb;
    border-radius: 12px;
    position: relative;
    transition: all 0.3s ease;
}

.switch-slider::before {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.switch-input:checked + .switch-label .switch-slider {
    background: var(--primary-color);
}

.switch-input:checked + .switch-label .switch-slider::before {
    transform: translateX(24px);
}

/* Action Buttons */
.action-buttons {
    display: grid;
    gap: 1rem;
}

.btn-secondary,
.btn-primary,
.btn-success {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    border: 2px solid;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(107, 114, 128, 0.3);
    color: var(--secondary-color);
}

.btn-secondary:hover {
    background: white;
    border-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    text-decoration: none;
    color: var(--secondary-color);
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #059669);
    border-color: var(--success-color);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, var(--success-color));
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.full-width {
    width: 100%;
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, var(--info-color) 0%, #0891b2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .header-title {
        font-size: 2rem;
    }
    
    .ad-status-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .header-title {
        font-size: 1.75rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-analytics,
    .btn-back {
        width: 100%;
        justify-content: center;
    }
    
    .form-section,
    .sidebar-section {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .size-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section,
.sidebar-section {
    animation: fadeInUp 0.6s ease forwards;
}

.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }

.sidebar-section:nth-child(1) { animation-delay: 0.2s; }
.sidebar-section:nth-child(2) { animation-delay: 0.3s; }
.sidebar-section:nth-child(3) { animation-delay: 0.4s; }
</style>
@endsection