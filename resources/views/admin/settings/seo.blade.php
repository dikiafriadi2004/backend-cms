@extends('layouts.admin')

@section('title', 'SEO Settings')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.settings.seo.update') }}">
        @csrf
        
        <div class="space-y-6">
            <!-- Meta Tags -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Meta Tags</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="meta_title" class="form-label">Default Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" 
                               value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" 
                               class="form-input">
                        <p class="text-sm text-gray-500 mt-1">Used when page doesn't have specific meta title</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description" class="form-label">Default Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" 
                                  class="form-input">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Used when page doesn't have specific meta description</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_keywords" class="form-label">Default Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" 
                               value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" 
                               class="form-input">
                        <p class="text-sm text-gray-500 mt-1">Separate keywords with commas</p>
                    </div>
                </div>
            </div>
            
            <!-- Search Engine Verification -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Search Engine Verification</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="google_site_verification" class="form-label">Google Site Verification</label>
                        <input type="text" id="google_site_verification" name="google_site_verification" 
                               value="{{ old('google_site_verification', $settings['google_site_verification'] ?? '') }}" 
                               class="form-input">
                        <p class="text-sm text-gray-500 mt-1">Google Search Console verification code</p>
                    </div>
                </div>
            </div>
            
            <!-- Robots.txt -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Robots.txt</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="robots_txt" class="form-label">Robots.txt Content</label>
                        <textarea id="robots_txt" name="robots_txt" rows="8" 
                                  class="form-input font-mono text-sm">{{ old('robots_txt', $settings['robots_txt'] ?? '') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Configure search engine crawling rules</p>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    Save SEO Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection