@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-6">
            <!-- Site Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Site Information</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="site_name" class="form-label">Site Name *</label>
                        <input type="text" id="site_name" name="site_name" 
                               value="{{ old('site_name', $settings['site_name'] ?? '') }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="site_description" class="form-label">Site Description</label>
                        <textarea id="site_description" name="site_description" rows="3" 
                                  class="form-input">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="site_logo" class="form-label">Site Logo</label>
                            <input type="file" id="site_logo" name="site_logo" accept="image/*" 
                                   class="form-input">
                            @if(isset($settings['site_logo']) && $settings['site_logo'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" 
                                         alt="Current Logo" class="h-16 w-auto">
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="site_favicon" class="form-label">Favicon</label>
                            <input type="file" id="site_favicon" name="site_favicon" accept="image/*" 
                                   class="form-input">
                            @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" 
                                         alt="Current Favicon" class="h-8 w-8">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" 
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" 
                               class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" 
                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" 
                               class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_address" class="form-label">Contact Address</label>
                        <textarea id="contact_address" name="contact_address" rows="3" 
                                  class="form-input">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection