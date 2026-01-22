@extends('layouts.admin')

@section('title', 'Create Tag')

@section('header-actions')
<div class="flex space-x-2">
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Tags
    </a>
</div>
@endsection

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.tags.store') }}">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Tag Information</h3>
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
                              class="form-input" placeholder="Brief description of the tag...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="color" class="form-label">Color</label>
                    <input type="color" id="color" name="color" value="{{ old('color', '#10b981') }}" 
                           class="form-input w-20 h-10">
                    <p class="text-xs text-gray-500 mt-1">Tag color for visual identification</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Tag
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