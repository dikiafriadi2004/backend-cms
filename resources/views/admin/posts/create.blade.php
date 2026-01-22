@extends('layouts.admin')

@section('title', 'Create Post')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Posts
    </a>
</div>
@endsection

@section('content')
<div>
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" id="post-form">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Post Content</h3>
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
                            <textarea id="excerpt" name="excerpt" rows="3" maxlength="300"
                                      class="form-input" placeholder="Ringkasan singkat artikel (maksimal 300 karakter)...">{{ old('excerpt') }}</textarea>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">Ringkasan singkat yang akan ditampilkan di halaman daftar artikel</p>
                                <span id="excerpt-counter" class="text-xs text-gray-400">0/300</span>
                            </div>
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
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="publish-date-group" style="display: none;">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" id="published_at" name="published_at" 
                                   value="{{ old('published_at') }}" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" 
                                       {{ old('featured') ? 'checked' : '' }} class="form-checkbox">
                                <span class="ml-2 text-sm text-gray-700">Featured Post</span>
                            </label>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <button type="submit" name="action" value="save" class="btn btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Post
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
                
                <!-- Category & Tags -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-900">Category & Tags</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tags</label>
                            <div class="space-y-2">
                                <!-- Add New Tag -->
                                <div class="flex gap-2 mb-3">
                                    <input type="text" id="new-tag-input" placeholder="Add new tag..." 
                                           class="form-input flex-1">
                                    <button type="button" id="add-tag-btn" class="btn btn-secondary">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Tag
                                    </button>
                                </div>
                                
                                <!-- Existing Tags -->
                                <div class="max-h-40 overflow-y-auto border rounded-md p-2" id="tags-container">
                                    @foreach($tags as $tag)
                                        <label class="flex items-center hover:bg-gray-50 p-1 rounded tag-item">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} 
                                                   class="form-checkbox">
                                            <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                            <span class="ml-auto text-xs px-2 py-1 rounded-full" 
                                                  style="background-color: {{ $tag->color ?? '#10b981' }}20; color: {{ $tag->color ?? '#10b981' }}">
                                                {{ $tag->posts_count ?? 0 }} posts
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
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
    
    // Show/hide publish date based on status
    const statusSelect = document.getElementById('status');
    const publishDateGroup = document.getElementById('publish-date-group');
    
    statusSelect.addEventListener('change', function() {
        if (this.value === 'scheduled') {
            publishDateGroup.style.display = 'block';
        } else {
            publishDateGroup.style.display = 'none';
        }
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
    
    // Add new tag functionality
    const newTagInput = document.getElementById('new-tag-input');
    const addTagBtn = document.getElementById('add-tag-btn');
    const tagsContainer = document.getElementById('tags-container');
    
    addTagBtn.addEventListener('click', function() {
        const tagName = newTagInput.value.trim();
        if (!tagName) {
            alert('Please enter a tag name');
            return;
        }
        
        // Check if tag already exists
        const existingTags = Array.from(tagsContainer.querySelectorAll('.tag-item span')).map(span => span.textContent.trim());
        if (existingTags.includes(tagName)) {
            alert('Tag already exists');
            return;
        }
        
        // Create new tag via AJAX
        fetch('/admin/tags/quick-create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: tagName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new tag to the list
                const newTagElement = document.createElement('label');
                newTagElement.className = 'flex items-center hover:bg-gray-50 p-1 rounded tag-item';
                newTagElement.innerHTML = `
                    <input type="checkbox" name="tags[]" value="${data.tag.id}" checked class="form-checkbox">
                    <span class="ml-2 text-sm text-gray-700">${data.tag.name}</span>
                    <span class="ml-auto text-xs px-2 py-1 rounded-full" 
                          style="background-color: ${data.tag.color}20; color: ${data.tag.color}">
                        0 posts
                    </span>
                `;
                tagsContainer.appendChild(newTagElement);
                newTagInput.value = '';
            } else {
                alert('Error creating tag: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating tag');
        });
    });
    
    // Allow Enter key to add tag
    newTagInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTagBtn.click();
        }
    });
    
    // Excerpt character counter
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCounter = document.getElementById('excerpt-counter');
    
    function updateExcerptCounter() {
        const currentLength = excerptTextarea.value.length;
        const maxLength = 300;
        excerptCounter.textContent = `${currentLength}/${maxLength}`;
        
        if (currentLength > maxLength * 0.9) {
            excerptCounter.classList.add('text-red-500');
            excerptCounter.classList.remove('text-gray-400');
        } else {
            excerptCounter.classList.add('text-gray-400');
            excerptCounter.classList.remove('text-red-500');
        }
    }
    
    excerptTextarea.addEventListener('input', updateExcerptCounter);
    updateExcerptCounter(); // Initial count
});
</script>
@endpush
@endsection