@extends('layouts.admin')

@section('title', 'Edit Iklan')

@section('content')
<div class="modern-container">
    <!-- Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="header-content">
                <div class="header-main">
                    <nav class="breadcrumb-nav">
                        <span class="breadcrumb-item">
                            <i class="fas fa-bullhorn"></i>
                            Manajemen Iklan
                        </span>
                        <i class="fas fa-chevron-right"></i>
                        <span class="breadcrumb-current">Edit Iklan</span>
                    </nav>
                    <h1 class="page-title">
                        <span class="title-icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        {{ $ad->name }}
                    </h1>
                    <div class="status-badge {{ $ad->status ? 'active' : 'inactive' }}">
                        <div class="status-dot"></div>
                        <span>{{ $ad->status ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="form-section">
        <div class="container-fluid">
            <form action="{{ route('admin.ads.update', $ad) }}" method="POST" class="edit-form">
                @csrf
                @method('PUT')
                
                <div class="form-layout">
                    <!-- Main Content -->
                    <div class="form-main">
                        <!-- Basic Information -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="header-text">
                                    <h3>Informasi Dasar</h3>
                                    <p>Konfigurasi pengaturan dasar iklan Anda</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="adName" class="form-label">
                                        <i class="fas fa-tag"></i>
                                        Nama Iklan
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="adName"
                                           class="form-control" 
                                           value="{{ old('name', $ad->name) }}" 
                                           required>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="adPosition" class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Posisi Tampil
                                        </label>
                                        <select name="position" id="adPosition" class="form-control" required>
                                            @foreach($positions as $key => $value)
                                                <option value="{{ $key }}" {{ old('position', $ad->position) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="adType" class="form-label">
                                            <i class="fas fa-layer-group"></i>
                                            Tipe Iklan
                                        </label>
                                        <select name="type" id="adType" class="form-control" required>
                                            @foreach($types as $key => $value)
                                                <option value="{{ $key }}" {{ old('type', $ad->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Configuration -->
                        <div class="form-card" id="contentCard">
                            <div class="card-header">
                                <div class="header-icon" id="contentIcon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="header-text">
                                    <h3 id="contentTitle">Konfigurasi Konten</h3>
                                    <p id="contentDescription">Atur konten dan pengaturan iklan Anda</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Link URL -->
                                <div class="form-group" id="linkUrlGroup">
                                    <label for="linkUrl" class="form-label">
                                        <i class="fas fa-link"></i>
                                        URL Tujuan
                                    </label>
                                    <input type="url" 
                                           name="link_url" 
                                           id="linkUrl"
                                           class="form-control" 
                                           value="{{ old('link_url', $ad->link_url) }}">
                                    <small class="form-hint">URL tujuan ketika pengguna mengklik iklan</small>
                                </div>

                                <!-- Banner Fields -->
                                <div id="bannerFields" class="dynamic-content">
                                    <div class="form-group">
                                        <label for="imageUrl" class="form-label">
                                            <i class="fas fa-image"></i>
                                            URL Gambar Banner
                                        </label>
                                        <input type="url" 
                                               name="image_url" 
                                               id="imageUrl"
                                               class="form-control" 
                                               value="{{ old('image_url', $ad->image_url) }}">
                                        <small class="form-hint">Link langsung ke gambar banner berkualitas tinggi</small>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="bannerWidth" class="form-label">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                Lebar (pixel)
                                            </label>
                                            <input type="number" 
                                                   name="width" 
                                                   id="bannerWidth"
                                                   class="form-control" 
                                                   value="{{ old('width', $ad->width) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="bannerHeight" class="form-label">
                                                <i class="fas fa-arrows-alt-v"></i>
                                                Tinggi (pixel)
                                            </label>
                                            <input type="number" 
                                                   name="height" 
                                                   id="bannerHeight"
                                                   class="form-control" 
                                                   value="{{ old('height', $ad->height) }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="altText" class="form-label">
                                            <i class="fas fa-font"></i>
                                            Teks Alternatif
                                        </label>
                                        <input type="text" 
                                               name="alt_text" 
                                               id="altText"
                                               class="form-control" 
                                               value="{{ old('alt_text', $ad->alt_text) }}">
                                        <small class="form-hint">Teks deskriptif untuk aksesibilitas dan SEO</small>
                                    </div>
                                </div>

                                <!-- Code Fields -->
                                <div id="codeFields" class="dynamic-content">
                                    <div class="form-group">
                                        <label for="adCode" class="form-label">
                                            <i class="fas fa-code"></i>
                                            Kode Iklan
                                        </label>
                                        <textarea name="code" 
                                                  id="adCode"
                                                  class="form-control code-textarea" 
                                                  rows="10"
                                                  placeholder="Tempel kode iklan Anda di sini...">{{ old('code', $ad->code) }}</textarea>
                                        <small class="form-hint" id="codeHint">Tempel kode iklan lengkap dari penyedia Anda</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <div class="header-text">
                                    <h3>Pengaturan Lanjutan</h3>
                                    <p>Sesuaikan iklan untuk performa optimal</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="adTitle" class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Judul Internal
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="adTitle"
                                           class="form-control" 
                                           value="{{ old('title', $ad->title) }}">
                                </div>

                                <div class="form-group">
                                    <label for="adDescription" class="form-label">
                                        <i class="fas fa-align-left"></i>
                                        Deskripsi
                                    </label>
                                    <textarea name="description" 
                                              id="adDescription"
                                              class="form-control" 
                                              rows="3">{{ old('description', $ad->description) }}</textarea>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="startDate" class="form-label">
                                            <i class="fas fa-calendar-plus"></i>
                                            Tanggal Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               name="start_date" 
                                               id="startDate"
                                               class="form-control" 
                                               value="{{ old('start_date', $ad->start_date ? $ad->start_date->format('Y-m-d\TH:i') : '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="endDate" class="form-label">
                                            <i class="fas fa-calendar-minus"></i>
                                            Tanggal Berakhir
                                        </label>
                                        <input type="datetime-local" 
                                               name="end_date" 
                                               id="endDate"
                                               class="form-control" 
                                               value="{{ old('end_date', $ad->end_date ? $ad->end_date->format('Y-m-d\TH:i') : '') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sortOrder" class="form-label">
                                        <i class="fas fa-sort-numeric-down"></i>
                                        Prioritas Tampil
                                    </label>
                                    <input type="number" 
                                           name="sort_order" 
                                           id="sortOrder"
                                           class="form-control" 
                                           value="{{ old('sort_order', $ad->sort_order) }}" 
                                           min="0">
                                    <small class="form-hint">Angka lebih kecil memiliki prioritas lebih tinggi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="form-sidebar">
                        <!-- Control Panel -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                                <div class="header-text">
                                    <h3>Panel Kontrol</h3>
                                    <p>Kelola visibilitas dan perilaku</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="toggle-group">
                                    <div class="toggle-item">
                                        <input type="checkbox" 
                                               name="status" 
                                               value="1" 
                                               id="statusToggle" 
                                               {{ old('status', $ad->status) ? 'checked' : '' }}>
                                        <label for="statusToggle" class="toggle-label">
                                            <div class="toggle-switch">
                                                <div class="toggle-slider"></div>
                                            </div>
                                            <div class="toggle-content">
                                                <div class="toggle-title">Status Iklan</div>
                                                <div class="toggle-desc">Tampilkan iklan ini di website</div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="toggle-item">
                                        <input type="checkbox" 
                                               name="open_new_tab" 
                                               value="1" 
                                               id="newTabToggle" 
                                               {{ old('open_new_tab', $ad->open_new_tab) ? 'checked' : '' }}>
                                        <label for="newTabToggle" class="toggle-label">
                                            <div class="toggle-switch">
                                                <div class="toggle-slider"></div>
                                            </div>
                                            <div class="toggle-content">
                                                <div class="toggle-title">Buka di Tab Baru</div>
                                                <div class="toggle-desc">Buka link tujuan di tab browser baru</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i>
                                    Perbarui Iklan
                                </button>
                                
                                <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Modern Clean Styling */
.modern-container {
    min-height: 100vh;
    background: #f8fafc;
}

/* Header */
.page-header {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    padding: 2rem 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    color: #6b7280;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-current {
    font-weight: 600;
    color: #4f46e5;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-badge.inactive {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Form Section */
.form-section {
    padding: 2rem 0;
}

.form-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

/* Form Cards */
.form-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.form-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 2rem;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    border-radius: 16px 16px 0 0;
}

.header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
}

.header-text h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
}

.header-text p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.card-body {
    padding: 2rem;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1f2937;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-hint {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: #6b7280;
}

.code-textarea {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 0.8rem;
    line-height: 1.5;
    min-height: 200px;
    resize: vertical;
}

/* Dynamic Content */
.dynamic-content {
    display: none;
}

.dynamic-content.show {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Toggle Switches */
.toggle-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.toggle-item {
    position: relative;
}

.toggle-item input[type="checkbox"] {
    display: none;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
    padding: 1rem;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.toggle-label:hover {
    background: #f1f5f9;
    border-color: #d1d5db;
}

.toggle-switch {
    position: relative;
    width: 48px;
    height: 28px;
    background: #d1d5db;
    border-radius: 14px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.toggle-slider {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 24px;
    height: 24px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

input[type="checkbox"]:checked + .toggle-label .toggle-switch {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
}

input[type="checkbox"]:checked + .toggle-label .toggle-switch .toggle-slider {
    transform: translateX(20px);
}

.toggle-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.toggle-desc {
    font-size: 0.875rem;
    color: #6b7280;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
}

.btn-secondary {
    background: #f9fafb;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.btn-block {
    width: 100%;
    justify-content: center;
    margin-bottom: 0.75rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .form-layout {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adTypeSelect = document.getElementById('adType');
    const linkUrlGroup = document.getElementById('linkUrlGroup');
    const bannerFields = document.getElementById('bannerFields');
    const codeFields = document.getElementById('codeFields');
    const contentIcon = document.getElementById('contentIcon');
    const contentTitle = document.getElementById('contentTitle');
    const contentDescription = document.getElementById('contentDescription');
    const codeHint = document.getElementById('codeHint');

    // Type configurations
    const typeConfigs = {
        manual_banner: {
            icon: 'fas fa-image',
            title: 'Konfigurasi Banner',
            description: 'Desain dan konfigurasi iklan banner kustom Anda',
            showLink: true,
            showBanner: true,
            showCode: false,
            codeHint: ''
        },
        manual_text: {
            icon: 'fas fa-font',
            title: 'Konfigurasi Teks Link',
            description: 'Buat iklan berbasis teks yang menarik',
            showLink: true,
            showBanner: false,
            showCode: false,
            codeHint: ''
        },
        adsense: {
            icon: 'fab fa-google',
            title: 'Integrasi Google AdSense',
            description: 'Konfigurasi unit iklan Google AdSense Anda',
            showLink: false,
            showBanner: false,
            showCode: true,
            codeHint: 'Tempel kode unit iklan AdSense lengkap dari dashboard Google AdSense Anda. Jangan ubah kodenya.'
        },
        adsera: {
            icon: 'fas fa-ad',
            title: 'Integrasi Adsera',
            description: 'Siapkan unit iklan Adsera Anda',
            showLink: false,
            showBanner: false,
            showCode: true,
            codeHint: 'Tempel kode unit iklan Adsera lengkap dari dashboard Adsera Anda. Jaga semua parameter tetap utuh.'
        }
    };

    function updateContentSection() {
        const selectedType = adTypeSelect.value;
        const config = typeConfigs[selectedType] || typeConfigs.manual_banner;

        // Update header
        contentIcon.className = config.icon;
        contentTitle.textContent = config.title;
        contentDescription.textContent = config.description;

        // Update code hint
        if (codeHint) {
            codeHint.textContent = config.codeHint || 'Tempel kode iklan lengkap dari penyedia Anda';
        }

        // Show/hide fields
        linkUrlGroup.style.display = config.showLink ? 'block' : 'none';
        
        if (config.showBanner) {
            bannerFields.classList.add('show');
            bannerFields.style.display = 'block';
        } else {
            bannerFields.classList.remove('show');
            bannerFields.style.display = 'none';
        }

        if (config.showCode) {
            codeFields.classList.add('show');
            codeFields.style.display = 'block';
        } else {
            codeFields.classList.remove('show');
            codeFields.style.display = 'none';
        }

        // Update required attributes
        updateRequiredFields(config);
    }

    function updateRequiredFields(config) {
        const imageUrlField = document.querySelector('input[name="image_url"]');
        const widthField = document.querySelector('input[name="width"]');
        const heightField = document.querySelector('input[name="height"]');
        const codeField = document.querySelector('textarea[name="code"]');

        if (imageUrlField) {
            imageUrlField.required = config.showBanner;
        }
        if (widthField) {
            widthField.required = config.showBanner;
        }
        if (heightField) {
            heightField.required = config.showBanner;
        }
        if (codeField) {
            codeField.required = config.showCode;
        }
    }

    // Initialize on page load
    updateContentSection();

    // Update on type change
    adTypeSelect.addEventListener('change', updateContentSection);

    // Auto-resize textarea
    const codeTextarea = document.querySelector('.code-textarea');
    if (codeTextarea) {
        codeTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.max(200, this.scrollHeight) + 'px';
        });
    }
});
</script>
@endsection