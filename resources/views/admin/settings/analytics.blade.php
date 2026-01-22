@extends('layouts.admin')

@section('title', 'Analytics Settings')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.settings.analytics.update') }}">
        @csrf
        
        <div class="space-y-6">
            <!-- Google Analytics -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Google Analytics</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                        <input type="text" id="google_analytics_id" name="google_analytics_id" 
                               value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" 
                               class="form-input" placeholder="G-XXXXXXXXXX">
                        <p class="text-sm text-gray-500 mt-1">Your Google Analytics 4 Measurement ID</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="google_tag_manager_id" class="form-label">Google Tag Manager ID</label>
                        <input type="text" id="google_tag_manager_id" name="google_tag_manager_id" 
                               value="{{ old('google_tag_manager_id', $settings['google_tag_manager_id'] ?? '') }}" 
                               class="form-input" placeholder="GTM-XXXXXXX">
                        <p class="text-sm text-gray-500 mt-1">Your Google Tag Manager Container ID</p>
                    </div>
                </div>
            </div>
            
            <!-- Facebook Pixel -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Facebook Pixel</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="facebook_pixel_id" class="form-label">Facebook Pixel ID</label>
                        <input type="text" id="facebook_pixel_id" name="facebook_pixel_id" 
                               value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id'] ?? '') }}" 
                               class="form-input" placeholder="123456789012345">
                        <p class="text-sm text-gray-500 mt-1">Your Facebook Pixel ID for tracking conversions</p>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    Save Analytics Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection