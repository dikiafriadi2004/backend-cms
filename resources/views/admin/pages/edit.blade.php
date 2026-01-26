@extends('layouts.admin')

@section('title', 'Edit Page')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Pages
    </a>
    <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        View Page
    </a>
</div>
@endsection

@section('content')
<div>
    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" id="page-form">
        @csrf
        @method('PUT')
        
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
                            <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" 
                                   class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" 
                                   class="form-input">
                            <p class="text-xs text-gray-500 mt-1">URL-friendly version of the title</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" rows="3" 
                                      class="form-input" placeholder="Brief description of the page...">{{ old('excerpt', $page->excerpt) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="content" class="form-label">Content *</label>
                            <textarea id="content" name="content" class="tinymce-editor">{{ old('content', $page->content) }}</textarea>
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
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" 
                                   class="form-input" maxlength="60">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" 
                                      class="form-input" maxlength="160" placeholder="Brief description for search engines...">{{ old('meta_description', $page->meta_description) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" 
                                   class="form-input" placeholder="keyword1, keyword2, keyword3">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Update Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Update</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="template" class="form-label">Page Template</label>
                            <select id="template" name="template" class="form-select">
                                <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="blog" {{ old('template', $page->template) == 'blog' ? 'selected' : '' }}>Blog/Posts</option>
                                <option value="contact" {{ old('template', $page->template) == 'contact' ? 'selected' : '' }}>Contact</option>
                                <option value="about" {{ old('template', $page->template) == 'about' ? 'selected' : '' }}>About</option>
                                <option value="services" {{ old('template', $page->template) == 'services' ? 'selected' : '' }}>Services</option>
                                <option value="privacy" {{ old('template', $page->template) == 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                <option value="terms" {{ old('template', $page->template) == 'terms' ? 'selected' : '' }}>Terms of Service</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" 
                                   class="form-input" min="0">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <button type="submit" name="action" value="update" class="btn btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Update Page
                            </button>
                            <button type="submit" name="action" value="update_and_continue" class="btn btn-secondary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update & Continue Editing
                            </button>
                        </div>
                        
                        <div class="pt-2 border-t">
                            <p class="text-xs text-gray-500">
                                Created: {{ $page->created_at->format('M d, Y H:i') }}<br>
                                Last updated: {{ $page->updated_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Featured Image</h3>
                    </div>
                    <div class="card-body">
                        @if($page->getFirstMediaUrl('thumbnail'))
                            <div class="mb-4">
                                <div class="relative inline-block">
                                    <img src="{{ $page->getFirstMediaUrl('thumbnail') }}" alt="Current thumbnail" class="max-w-full h-32 object-cover rounded">
                                    <button type="button" id="remove-current-thumbnail" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Current featured image</p>
                                <input type="hidden" name="remove_thumbnail" id="remove_thumbnail_input" value="0">
                            </div>
                        @endif
                        
                        <div class="form-group">
                            <input type="file" id="thumbnail" name="thumbnail" 
                                   class="form-input" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Upload new image to replace current one. Recommended size: 1200x630px</p>
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
                                       {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }} class="form-checkbox">
                                <span class="ml-2 text-sm text-gray-700">Show in Menu</span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_homepage" value="1" 
                                       {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }} class="form-checkbox">
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
    // Auto-generate slug from title (only if slug is empty)
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;
    
    titleInput.addEventListener('input', function() {
        // Only auto-generate if slug is empty or matches the original
        if (!slugInput.value || slugInput.value === originalSlug) {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
    
    // Image preview
    const thumbnailInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnail-preview');
    const previewImage = document.getElementById('preview-image');
    const removePreviewBtn = document.getElementById('remove-preview');
    const removeThumbnailBtn = document.getElementById('remove-current-thumbnail');
    const removeThumbnailInput = document.getElementById('remove_thumbnail_input');
    
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
    
    if (removePreviewBtn) {
        removePreviewBtn.addEventListener('click', function() {
            thumbnailInput.value = '';
            previewContainer.classList.add('hidden');
        });
    }
    
    if (removeThumbnailBtn) {
        removeThumbnailBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove the current thumbnail?')) {
                removeThumbnailInput.value = '1';
                this.closest('.mb-4').style.display = 'none';
            }
        });
    }
});
</script>
@endpush
@endsection