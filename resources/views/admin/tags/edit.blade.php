@extends('layouts.admin')

@section('title', 'Edit Tag')

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.tags.update', $tag) }}">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Tag Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input">{{ old('description', $tag->description) }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Tag</button>
        </div>
    </form>
</div>
@endsection