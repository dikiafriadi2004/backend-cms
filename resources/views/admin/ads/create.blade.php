@extends('layouts.admin')

@section('title', 'Tambah Iklan')

@section('content')
<div class="ads-form-container">
    <!-- Ultra Modern Header -->
    <div class="form-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-content">
                        <div class="header-badge">
                            <i class="fas fa-sparkles"></i>
                            <span>Ads Creator</span>
                        </div>
                        <h1 class="header-title">
                            Buat Iklan Baru
                        </h1>
                        <p class="header-subtitle">
                            Wizard interaktif untuk membuat iklan yang efektif dan profesional
                        </p>
                        <div class="progress-wizard">
                            <div class="wizard-step active" data-step="1">
                                <div class="step-circle">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <span class="step-text">Pilih Tipe</span>
                            </div>
                            <div class="wizard-connector"></div>
                            <div class="wizard-step" data-step="2">
                                <div class="step-circle">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <span class="step-text">Isi Detail</span>
                            </div>
                            <div class="wizard-connector"></div>
                            <div class="wizard-step" data-step="3">
                                <div class="step-circle">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <span class="step-text">Preview</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('admin.ads.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="form-main">
        <div class="container-fluid">
            <form action="{{ route('admin.ads.store') }}" method="POST" id="adForm" class="ultra-form">
                @csrf
                
                <!-- Step 1: Ad Type Selection -->
                <div class="form-step active" id="step1">
                    <div class="step-container">
                        <div class="step-header">
                            <h2 class="step-title">Pilih Tipe Iklan</h2>
                            <p class="step-description">Pilih jenis iklan yang ingin Anda buat untuk memulai</p>
                        </div>
                        
                        <div class="ad-types-grid">
                            <div class="ad-type-option" data-type="manual_banner">
                                <div class="option-icon">
                                    <div class="icon-bg bg-gradient-primary">
                                        <i class="fas fa-image"></i>
                                    </div>
                                </div>
                                <div class="option-content">
                                    <h3 class="option-title">Manual Banner</h3>
                                    <p class="option-description">Upload gambar banner dengan link tujuan yang dapat dikustomisasi</p>
                                    <div class="option-features">
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Custom Image
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Link Control
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Size Options
                                        </span>
                                    </div>
                                </div>
                                <div class="option-selector">
                                    <div class="selector-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="ad-type-option" data-type="manual_text">
                                <div class="option-icon">
                                    <div class="icon-bg bg-gradient-secondary">
                                        <i class="fas fa-link"></i>
                                    </div>
                                </div>
                                <div class="option-content">
                                    <h3 class="option-title">Manual Text Link</h3>
                                    <p class="option-description">Buat link teks yang menarik dengan judul dan deskripsi custom</p>
                                    <div class="option-features">
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Custom Text
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Description
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            CTA Button
                                        </span>
                                    </div>
                                </div>
                                <div class="option-selector">
                                    <div class="selector-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="ad-type-option" data-type="adsense">
                                <div class="option-icon">
                                    <div class="icon-bg bg-gradient-success">
                                        <i class="fab fa-google"></i>
                                    </div>
                                </div>
                                <div class="option-content">
                                    <h3 class="option-title">Google AdSense</h3>
                                    <p class="option-description">Integrasikan kode iklan dari Google AdSense untuk monetisasi</p>
                                    <div class="option-features">
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Auto Ads
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            High Revenue
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Easy Setup
                                        </span>
                                    </div>
                                </div>
                                <div class="option-selector">
                                    <div class="selector-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="ad-type-option" data-type="adsera">
                                <div class="option-icon">
                                    <div class="icon-bg bg-gradient-warning">
                                        <i class="fas fa-code"></i>
                                    </div>
                                </div>
                                <div class="option-content">
                                    <h3 class="option-title">Adsera Network</h3>
                                    <p class="option-description">Pasang kode iklan dari jaringan Adsera untuk monetisasi lokal</p>
                                    <div class="option-features">
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Local Ads
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            Fast Payment
                                        </span>
                                        <span class="feature-tag">
                                            <i class="fas fa-check"></i>
                                            ID Support
                                        </span>
                                    </div>
                                </div>
                                <div class="option-selector">
                                    <div class="selector-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="type" id="adType" value="{{ old('type') }}">
                        @error('type')
                            <div class="error-message">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Step 2: Basic Information -->
                <div class="form-step" id="step2">
                    <div class="step-container">
                        <div class="step-header">
                            <h2 class="step-title">Informasi Dasar</h2>
                            <p class="step-description">Isi informasi dasar untuk iklan Anda</p>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-section">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="fas fa-info-circle"></i>
                                        Detail Iklan
                                    </h3>
                                </div>
                                
                                <div class="form-group-modern">
                                    <div class="input-wrapper">
                                        <input type="text" class="form-input @error('name') error @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
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
                                                    <option value="{{ $key }}" {{ old('position') == $key ? 'selected' : '' }}>
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
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
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

                            <div class="form-section">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="fas fa-calendar-alt"></i>
                                        Jadwal Tayang
                                    </h3>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group-modern">
                                        <div class="input-wrapper">
                                            <input type="datetime-local" class="form-input @error('start_date') error @enderror" 
                                                   id="start_date" name="start_date" value="{{ old('start_date') }}">
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
                                                   id="end_date" name="end_date" value="{{ old('end_date') }}">
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Dynamic Content -->
                <div class="form-step" id="step3">
                    <div class="step-container">
                        <div class="step-header">
                            <h2 class="step-title">Pengaturan Iklan</h2>
                            <p class="step-description">Konfigurasi detail sesuai tipe iklan yang dipilih</p>
                        </div>
                        
                        <div id="dynamicContent">
                            <!-- Content will be loaded dynamically -->
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <div class="actions-container">
                        <div class="actions-left">
                            <button type="button" class="btn-secondary" id="prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left"></i>
                                <span>Sebelumnya</span>
                            </button>
                        </div>
                        
                        <div class="actions-center">
                            <div class="form-switches">
                                <div class="switch-group">
                                    <input type="checkbox" class="switch-input" id="status" name="status" value="1" 
                                           {{ old('status', true) ? 'checked' : '' }}>
                                    <label for="status" class="switch-label">
                                        <span class="switch-slider"></span>
                                        <span class="switch-text">Aktifkan Iklan</span>
                                    </label>
                                </div>
                                
                                <div class="switch-group">
                                    <input type="checkbox" class="switch-input" id="open_new_tab" name="open_new_tab" value="1" 
                                           {{ old('open_new_tab', true) ? 'checked' : '' }}>
                                    <label for="open_new_tab" class="switch-label">
                                        <span class="switch-slider"></span>
                                        <span class="switch-text">Buka di Tab Baru</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="actions-right">
                            <button type="button" class="btn-primary" id="nextBtn">
                                <span>Selanjutnya</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            
                            <button type="submit" class="btn-success" id="submitBtn" style="display: none;">
                                <i class="fas fa-save"></i>
                                <span>Simpan Iklan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating Help Panel -->
    <div class="help-panel" id="helpPanel">
        <div class="help-header">
            <h4 class="help-title">
                <i class="fas fa-question-circle"></i>
                Bantuan
            </h4>
            <button class="help-close" onclick="toggleHelp()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="help-content" id="helpContent">
            <div class="help-placeholder">
                <i class="fas fa-hand-point-up"></i>
                <p>Pilih tipe iklan untuk melihat panduan</p>
            </div>
        </div>
    </div>

    <!-- Help Toggle Button -->
    <button class="help-toggle" onclick="toggleHelp()">
        <i class="fas fa-question-circle"></i>
        <span>Bantuan</span>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    
    // Elements
    const adTypeOptions = document.querySelectorAll('.ad-type-option');
    const adTypeInput = document.getElementById('adType');
    const dynamicContent = document.getElementById('dynamicContent');
    const helpContent = document.getElementById('helpContent');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const wizardSteps = document.querySelectorAll('.wizard-step');
    const formSteps = document.querySelectorAll('.form-step');

    // Ad type selection
    adTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            const type = this.dataset.type;
            
            // Remove active class from all options
            adTypeOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add active class to clicked option
            this.classList.add('selected');
            
            // Set hidden input value
            adTypeInput.value = type;
            
            // Load help content
            loadHelpContent(type);
            
            // Enable next button
            nextBtn.disabled = false;
            
            // Add animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Navigation
    nextBtn.addEventListener('click', function() {
        if (currentStep < totalSteps) {
            if (currentStep === 1) {
                loadDynamicContent(adTypeInput.value);
            }
            goToStep(currentStep + 1);
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    function goToStep(step) {
        // Hide current step
        formSteps[currentStep - 1].classList.remove('active');
        wizardSteps[currentStep - 1].classList.remove('active');
        
        // Show new step
        currentStep = step;
        formSteps[currentStep - 1].classList.add('active');
        wizardSteps[currentStep - 1].classList.add('active');
        
        // Update buttons
        prevBtn.style.display = currentStep > 1 ? 'flex' : 'none';
        nextBtn.style.display = currentStep < totalSteps ? 'flex' : 'none';
        submitBtn.style.display = currentStep === totalSteps ? 'flex' : 'none';
        
        // Scroll to top
        document.querySelector('.form-main').scrollIntoView({ behavior: 'smooth' });
    }

    function loadDynamicContent(type) {
        let content = '';
        
        switch(type) {
            case 'manual_banner':
                content = `
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-image"></i>
                                Pengaturan Banner
                            </h3>
                            <p class="section-description">Upload dan konfigurasi banner iklan Anda</p>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <input type="url" class="form-input" id="image_url" name="image_url" required>
                                    <label for="image_url" class="form-label">
                                        <span class="label-text">URL Gambar</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-link"></i>
                                    Contoh: https://example.com/images/banner-promo.jpg
                                </div>
                            </div>
                            
                            <div class="form-group-modern">
                                <div class="input-wrapper">
                                    <input type="number" class="form-input" id="width" name="width" min="1" required>
                                    <label for="width" class="form-label">
                                        <span class="label-text">Lebar (px)</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="preset-sizes">
                                    <button type="button" class="size-preset" data-width="728" data-height="90">
                                        <span class="size-name">Leaderboard</span>
                                        <span class="size-dim">728×90</span>
                                    </button>
                                    <button type="button" class="size-preset" data-width="300" data-height="250">
                                        <span class="size-name">Rectangle</span>
                                        <span class="size-dim">300×250</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group-modern">
                                <div class="input-wrapper">
                                    <input type="number" class="form-input" id="height" name="height" min="1" required>
                                    <label for="height" class="form-label">
                                        <span class="label-text">Tinggi (px)</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                            </div>
                            
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <input type="url" class="form-input" id="banner_link_url" name="link_url">
                                    <label for="banner_link_url" class="form-label">
                                        <span class="label-text">Link Tujuan</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-external-link-alt"></i>
                                    URL yang akan dibuka saat banner diklik
                                </div>
                            </div>
                            
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <input type="text" class="form-input" id="alt_text" name="alt_text">
                                    <label for="alt_text" class="form-label">
                                        <span class="label-text">Alt Text</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-universal-access"></i>
                                    Deskripsi gambar untuk aksesibilitas
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
                
            case 'manual_text':
                content = `
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-link"></i>
                                Pengaturan Text Link
                            </h3>
                            <p class="section-description">Buat link teks yang menarik dan efektif</p>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <input type="text" class="form-input" id="title" name="title" required>
                                    <label for="title" class="form-label">
                                        <span class="label-text">Judul Link</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-heading"></i>
                                    Contoh: "Dapatkan Diskon 50% Hari Ini!"
                                </div>
                            </div>
                            
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <textarea class="form-input" id="description" name="description" rows="3"></textarea>
                                    <label for="description" class="form-label">
                                        <span class="label-text">Deskripsi</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-align-left"></i>
                                    Deskripsi tambahan untuk menarik perhatian
                                </div>
                            </div>
                            
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <input type="url" class="form-input" id="text_link_url" name="link_url" required>
                                    <label for="text_link_url" class="form-label">
                                        <span class="label-text">Link Tujuan</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-external-link-alt"></i>
                                    URL yang akan dibuka saat link diklik
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
                
            case 'adsense':
                content = `
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fab fa-google"></i>
                                Kode Google AdSense
                            </h3>
                            <p class="section-description">Paste kode iklan dari dashboard AdSense Anda</p>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <textarea class="form-input code-input" id="code" name="code" rows="8" required></textarea>
                                    <label for="code" class="form-label">
                                        <span class="label-text">Kode AdSense</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fab fa-google"></i>
                                    Copy kode dari dashboard Google AdSense Anda
                                </div>
                            </div>
                            
                            <div class="code-example">
                                <div class="example-header">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Contoh Kode AdSense:</span>
                                </div>
                                <div class="example-code">
&lt;script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXX"&gt;&lt;/script&gt;
&lt;ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-XXXXXXXXXX"
     data-ad-slot="XXXXXXXXXX"&gt;&lt;/ins&gt;
&lt;script&gt;
     (adsbygoogle = window.adsbygoogle || []).push({});
&lt;/script&gt;
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
                
            case 'adsera':
                content = `
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-code"></i>
                                Kode Adsera
                            </h3>
                            <p class="section-description">Paste kode iklan dari dashboard Adsera Anda</p>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group-modern full-width">
                                <div class="input-wrapper">
                                    <textarea class="form-input code-input" id="code" name="code" rows="8" required></textarea>
                                    <label for="code" class="form-label">
                                        <span class="label-text">Kode Adsera</span>
                                        <span class="label-required">*</span>
                                    </label>
                                    <div class="input-border"></div>
                                </div>
                                <div class="field-help">
                                    <i class="fas fa-code"></i>
                                    Copy kode dari dashboard Adsera Anda
                                </div>
                            </div>
                            
                            <div class="code-example">
                                <div class="example-header">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Contoh Kode Adsera:</span>
                                </div>
                                <div class="example-code">
&lt;script type="text/javascript" src="https://adsera.com/ads/XXXXXX.js"&gt;&lt;/script&gt;
&lt;div id="adsera-XXXXXX"&gt;&lt;/div&gt;
&lt;script type="text/javascript"&gt;
    adsera_show('XXXXXX');
&lt;/script&gt;
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                break;
        }
        
        dynamicContent.innerHTML = content;
        
        // Add event listeners for preset sizes
        if (type === 'manual_banner') {
            document.querySelectorAll('.size-preset').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('width').value = this.dataset.width;
                    document.getElementById('height').value = this.dataset.height;
                    
                    // Add visual feedback
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        }
    }

    function loadHelpContent(type) {
        let content = '';
        
        switch(type) {
            case 'manual_banner':
                content = `
                    <div class="help-section">
                        <h5 class="help-title">
                            <i class="fas fa-image"></i>
                            Manual Banner
                        </h5>
                        <div class="help-item">
                            <h6>Ukuran Standar:</h6>
                            <ul>
                                <li>Leaderboard: 728×90px</li>
                                <li>Rectangle: 300×250px</li>
                                <li>Banner: 468×60px</li>
                                <li>Square: 250×250px</li>
                            </ul>
                        </div>
                        <div class="help-item">
                            <h6>Tips Penting:</h6>
                            <ul>
                                <li>Gunakan gambar berkualitas tinggi</li>
                                <li>Format JPG/PNG/GIF</li>
                                <li>Ukuran file maksimal 2MB</li>
                                <li>Pastikan URL gambar dapat diakses</li>
                            </ul>
                        </div>
                    </div>
                `;
                break;
                
            case 'manual_text':
                content = `
                    <div class="help-section">
                        <h5 class="help-title">
                            <i class="fas fa-link"></i>
                            Manual Text Link
                        </h5>
                        <div class="help-item">
                            <h6>Best Practices:</h6>
                            <ul>
                                <li>Judul singkat dan menarik</li>
                                <li>Gunakan call-to-action yang jelas</li>
                                <li>Deskripsi maksimal 2-3 kalimat</li>
                                <li>Link harus valid dan aman</li>
                            </ul>
                        </div>
                        <div class="help-item">
                            <h6>Contoh Judul Efektif:</h6>
                            <ul>
                                <li>"Dapatkan Diskon 50% Hari Ini!"</li>
                                <li>"Promo Terbatas - Jangan Sampai Terlewat"</li>
                                <li>"Klik Disini untuk Penawaran Spesial"</li>
                            </ul>
                        </div>
                    </div>
                `;
                break;
                
            case 'adsense':
                content = `
                    <div class="help-section">
                        <h5 class="help-title">
                            <i class="fab fa-google"></i>
                            Google AdSense
                        </h5>
                        <div class="help-item">
                            <h6>Cara Mendapatkan Kode:</h6>
                            <ol>
                                <li>Login ke dashboard AdSense</li>
                                <li>Pilih "Ads" → "By ad unit"</li>
                                <li>Klik "Get code" pada unit iklan</li>
                                <li>Copy seluruh kode HTML</li>
                            </ol>
                        </div>
                        <div class="help-item">
                            <h6>Penting Diingat:</h6>
                            <ul>
                                <li>Pastikan akun AdSense sudah disetujui</li>
                                <li>Jangan edit kode yang diberikan</li>
                                <li>Satu kode untuk satu posisi</li>
                            </ul>
                        </div>
                    </div>
                `;
                break;
                
            case 'adsera':
                content = `
                    <div class="help-section">
                        <h5 class="help-title">
                            <i class="fas fa-code"></i>
                            Adsera Network
                        </h5>
                        <div class="help-item">
                            <h6>Cara Mendapatkan Kode:</h6>
                            <ol>
                                <li>Login ke dashboard Adsera</li>
                                <li>Pilih "Ad Units" atau "Iklan"</li>
                                <li>Klik "Get Code" pada unit iklan</li>
                                <li>Copy seluruh kode JavaScript</li>
                            </ol>
                        </div>
                        <div class="help-item">
                            <h6>Catatan Penting:</h6>
                            <ul>
                                <li>Pastikan akun Adsera aktif</li>
                                <li>Kode berupa JavaScript</li>
                                <li>Jangan ubah ID dalam kode</li>
                            </ul>
                        </div>
                    </div>
                `;
                break;
        }
        
        helpContent.innerHTML = content;
    }

    // Set old type if exists
    const oldType = '{{ old("type") }}';
    if (oldType) {
        const option = document.querySelector(`[data-type="${oldType}"]`);
        if (option) {
            option.click();
        }
    }

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

// Help panel toggle
function toggleHelp() {
    const helpPanel = document.getElementById('helpPanel');
    helpPanel.classList.toggle('active');
}
</script>

<style>
/* Ultra Modern Ads Creator Styling */
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
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-md);
}

.header-title {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 1.25rem;
    color: var(--secondary-color);
    margin-bottom: 2rem;
    font-weight: 500;
}

/* Progress Wizard */
.progress-wizard {
    display: flex;
    align-items: center;
    gap: 0;
    margin-top: 2rem;
}

.wizard-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 2;
}

.step-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(107, 114, 128, 0.1);
    border: 3px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--secondary-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.step-circle::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    opacity: 0;
    transition: opacity 0.4s ease;
}

.wizard-step.active .step-circle {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
    box-shadow: var(--shadow-lg);
}

.wizard-step.active .step-circle::before {
    opacity: 1;
}

.step-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--secondary-color);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: color 0.3s ease;
}

.wizard-step.active .step-text {
    color: var(--primary-color);
    font-weight: 700;
}

.wizard-connector {
    width: 80px;
    height: 3px;
    background: #e5e7eb;
    margin: 0 -10px;
    position: relative;
    z-index: 1;
}

/* Back Button */
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

/* Form Steps */
.form-step {
    display: none;
    animation: fadeInUp 0.6s ease forwards;
}

.form-step.active {
    display: block;
}

.step-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 3rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.step-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--info-color), var(--success-color));
}

.step-header {
    text-align: center;
    margin-bottom: 3rem;
}

.step-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 1rem;
}

.step-description {
    font-size: 1.125rem;
    color: var(--secondary-color);
    font-weight: 500;
}

/* Ad Type Selection Grid */
.ad-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.ad-type-option {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(229, 231, 235, 0.5);
    border-radius: var(--border-radius);
    padding: 2rem;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.ad-type-option::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(99, 102, 241, 0.1));
    opacity: 0;
    transition: opacity 0.4s ease;
}

.ad-type-option:hover {
    border-color: var(--primary-color);
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.ad-type-option:hover::before {
    opacity: 1;
}

.ad-type-option.selected {
    border-color: var(--primary-color);
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.ad-type-option.selected::before {
    opacity: 1;
}

.option-icon {
    margin-bottom: 1.5rem;
}

.icon-bg {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}

.icon-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background: inherit;
    filter: blur(20px);
    opacity: 0.3;
}

.option-content {
    text-align: center;
    position: relative;
    z-index: 2;
}

.option-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.75rem;
}

.option-description {
    color: var(--secondary-color);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.option-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
}

.feature-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

.option-selector {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
}

.selector-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(229, 231, 235, 0.5);
    border: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: transparent;
    transition: all 0.3s ease;
}

.ad-type-option.selected .selector-circle {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

/* Form Grid and Sections */
.form-grid {
    display: grid;
    gap: 2rem;
}

.form-section {
    background: rgba(255, 255, 255, 0.6);
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid rgba(229, 231, 235, 0.3);
    backdrop-filter: blur(10px);
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

/* Modern Form Inputs */
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

.error-message {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 8px;
    padding: 1rem;
    color: var(--danger-color);
    font-weight: 600;
    margin-top: 1rem;
}

/* Preset Sizes */
.preset-sizes {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.size-preset {
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-preset:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.size-name {
    display: block;
    font-weight: 700;
}

.size-dim {
    display: block;
    opacity: 0.8;
}

/* Code Examples */
.code-example {
    background: rgba(248, 250, 252, 0.8);
    border: 1px solid rgba(229, 231, 235, 0.5);
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
    backdrop-filter: blur(10px);
}

.example-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 1rem;
}

.example-header i {
    color: var(--warning-color);
}

.example-code {
    background: var(--dark-color);
    color: #e5e7eb;
    padding: 1rem;
    border-radius: 8px;
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 0.875rem;
    line-height: 1.6;
    overflow-x: auto;
    white-space: pre;
}

.code-input {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-size: 0.875rem;
    line-height: 1.6;
}

/* Form Actions */
.form-actions {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(229, 231, 235, 0.3);
    padding: 2rem 0;
    margin-top: 3rem;
    position: sticky;
    bottom: 0;
    z-index: 20;
}

.actions-container {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.actions-left,
.actions-right {
    display: flex;
    gap: 1rem;
}

.actions-right {
    justify-content: flex-end;
}

.actions-center {
    display: flex;
    justify-content: center;
}

/* Form Switches */
.form-switches {
    display: flex;
    gap: 2rem;
    align-items: center;
}

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

/* Buttons */
.btn-secondary,
.btn-primary,
.btn-success {
    display: inline-flex;
    align-items: center;
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
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
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

/* Help Panel */
.help-panel {
    position: fixed;
    top: 50%;
    right: -400px;
    transform: translateY(-50%);
    width: 380px;
    max-height: 80vh;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    overflow: hidden;
}

.help-panel.active {
    right: 2rem;
}

.help-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(229, 231, 235, 0.3);
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
}

.help-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 700;
    margin: 0;
}

.help-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: background 0.3s ease;
}

.help-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.help-content {
    padding: 1.5rem;
    max-height: calc(80vh - 80px);
    overflow-y: auto;
}

.help-placeholder {
    text-align: center;
    color: var(--secondary-color);
    padding: 2rem 0;
}

.help-placeholder i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.help-section {
    animation: fadeInUp 0.4s ease forwards;
}

.help-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 1.5rem;
}

.help-item {
    margin-bottom: 1.5rem;
}

.help-item:last-child {
    margin-bottom: 0;
}

.help-item h6 {
    color: var(--dark-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.help-item ul,
.help-item ol {
    margin-bottom: 0;
    padding-left: 1.25rem;
}

.help-item li {
    margin-bottom: 0.5rem;
    color: var(--secondary-color);
    line-height: 1.5;
}

/* Help Toggle Button */
.help-toggle {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    border-radius: 50px;
    padding: 1rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
    z-index: 999;
}

.help-toggle:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .help-panel {
        width: 320px;
    }
    
    .help-panel.active {
        right: 1rem;
    }
    
    .help-toggle {
        bottom: 1rem;
        right: 1rem;
    }
}

@media (max-width: 768px) {
    .header-title {
        font-size: 2rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
    
    .progress-wizard {
        gap: 0;
    }
    
    .step-circle {
        width: 48px;
        height: 48px;
        font-size: 1rem;
    }
    
    .wizard-connector {
        width: 60px;
    }
    
    .ad-types-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .ad-type-option {
        padding: 1.5rem;
    }
    
    .icon-bg {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .step-container {
        padding: 2rem 1.5rem;
    }
    
    .step-title {
        font-size: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .actions-container {
        grid-template-columns: 1fr;
        gap: 1rem;
        text-align: center;
    }
    
    .form-switches {
        flex-direction: column;
        gap: 1rem;
    }
    
    .help-panel {
        width: calc(100vw - 2rem);
        right: -100vw;
    }
    
    .help-panel.active {
        right: 1rem;
    }
    
    .help-toggle span {
        display: none;
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.ad-type-option:hover .icon-bg {
    animation: pulse 2s infinite;
}

/* Scrollbar Styling */
.help-content::-webkit-scrollbar {
    width: 6px;
}

.help-content::-webkit-scrollbar-track {
    background: rgba(229, 231, 235, 0.3);
    border-radius: 3px;
}

.help-content::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 3px;
}

.help-content::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}
</style>
@endsection