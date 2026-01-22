@extends('layouts.admin')

@section('title', 'Social Media Settings')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.settings.social.update') }}">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Social Media Links</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="facebook_url" class="form-label">Facebook URL</label>
                    <input type="url" id="facebook_url" name="facebook_url" 
                           value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" 
                           class="form-input" placeholder="https://facebook.com/yourpage">
                </div>
                
                <div class="form-group">
                    <label for="twitter_url" class="form-label">Twitter URL</label>
                    <input type="url" id="twitter_url" name="twitter_url" 
                           value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" 
                           class="form-input" placeholder="https://twitter.com/youraccount">
                </div>
                
                <div class="form-group">
                    <label for="instagram_url" class="form-label">Instagram URL</label>
                    <input type="url" id="instagram_url" name="instagram_url" 
                           value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" 
                           class="form-input" placeholder="https://instagram.com/youraccount">
                </div>
                
                <div class="form-group">
                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" 
                           value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" 
                           class="form-input" placeholder="https://linkedin.com/company/yourcompany">
                </div>
                
                <div class="form-group">
                    <label for="youtube_url" class="form-label">YouTube URL</label>
                    <input type="url" id="youtube_url" name="youtube_url" 
                           value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" 
                           class="form-input" placeholder="https://youtube.com/c/yourchannel">
                </div>
            </div>
        </div>
        
        <!-- Save Button -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="btn btn-primary">
                Save Social Media Settings
            </button>
        </div>
    </form>
</div>
@endsection