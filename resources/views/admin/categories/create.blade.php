@extends('layouts.admin')

@section('title', 'Create Category')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Categories
    </a>
</div>
@endsection

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                           class="form-input" readonly>
                    <p class="text-xs text-gray-500 mt-1">Auto-generated from name</p>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input" placeholder="Brief description of the category...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="color" class="form-label">Color</label>
                    <input type="color" id="color" name="color" value="{{ old('color', '#3b82f6') }}" 
                           class="form-input w-20 h-10">
                    <p class="text-xs text-gray-500 mt-1">Category color for visual identification</p>
                </div>
            </div>
        </div>
        
        <!-- SEO Section -->
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
                           class="form-input" maxlength="60">
                    <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                </div>
                
                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" 
                              class="form-input" maxlength="160" placeholder="Brief description for search engines...">{{ old('meta_description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Category
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugInput.value = slug;
    });
});
</script>
@endpush
@endsection