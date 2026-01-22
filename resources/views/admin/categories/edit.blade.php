@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input">{{ old('description', $category->description) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="parent_id" class="form-label">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-input">
                        <option value="">None (Top Level)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                    {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
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
                    <input type="text" id="meta_title" name="meta_title" 
                           value="{{ old('meta_title', $category->meta_title) }}" 
                           class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" 
                              class="form-input">{{ old('meta_description', $category->meta_description) }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
    </form>
</div>
@endsection