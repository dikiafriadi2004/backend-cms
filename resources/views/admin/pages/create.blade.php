@extends('layouts.admin')

@section('title', 'Create Page')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Pages
    </a>
</div>
@endsection

@section('content')
<div>
    <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data" id="page-form">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Page Content</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                   class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                                   class="form-input" readonly>
                            <p class="text-xs text-gray-500 mt-1">Auto-generated from title</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" rows="3" 
                                      class="form-input" placeholder="Brief description of the page...">{{ old('excerpt') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="content" class="form-label">Content *</label>
                            <textarea id="content" name="content" class="tinymce-editor">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- SEO Section -->
                <div class="card">
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
                        
                        <div class="form-group">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" 
                                   class="form-input" placeholder="keyword1, keyword2, keyword3">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Publish</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="template" class="form-label">Page Template</label>
                            <select id="template" name="template" class="form-select">
                                <option value="default" {{ old('template', 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="contact" {{ old('template') == 'contact' ? 'selected' : '' }}>Contact</option>
                                <option value="about" {{ old('template') == 'about' ? 'selected' : '' }}>About</option>
                                <option value="services" {{ old('template') == 'services' ? 'selected' : '' }}>Services</option>
                                <option value="privacy" {{ old('template') == 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                <option value="terms" {{ old('template') == 'terms' ? 'selected' : '' }}>Terms of Service</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                   class="form-input" min="0">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <button type="submit" name="action" value="save" class="btn btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Page
                            </button>
                            <button type="submit" name="action" value="save_and_continue" class="btn btn-secondary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Save & Continue Editing
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="file" id="thumbnail" name="thumbnail" 
                                   class="form-input" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x630px</p>
                        </div>
                        <div id="thumbnail-preview" class="mt-2 hidden">
                            <div class="relative">
                                <img id="preview-image" src="" alt="Preview" class="max-w-full h-32 object-cover rounded">
                                <button type="button" id="remove-preview" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Page Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Page Settings</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label class="flex items-center">
                                <input type="checkbox" name="show_in_menu" value="1" 
                                       {{ old('show_in_menu', true) ? 'checked' : '' }} class="form-checkbox">
                                <span class="ml-2 text-sm text-gray-700">Show in Menu</span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_homepage" value="1" 
                                       {{ old('is_homepage') ? 'checked' : '' }} class="form-checkbox">
                                <span class="ml-2 text-sm text-gray-700">Set as Homepage</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugInput.value = slug;
    });
    
    // Image preview
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnail-preview');
    const previewImage = document.getElementById('preview-image');
    const removePreviewBtn = document.getElementById('remove-preview');
    
    thumbnailInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    });
    
    removePreviewBtn.addEventListener('click', function() {
        thumbnailInput.value = '';
        previewContainer.classList.add('hidden');
    });
});
</script>
@endpush
@endsection