@extends('layouts.admin')

@section('title', 'Create Menu')

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.menus.store') }}">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Menu Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="name" class="form-label">Menu Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="location" class="form-label">Location *</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" 
                           class="form-input" required>
                    <p class="text-sm text-gray-500 mt-1">Unique identifier for this menu (e.g., main, footer, sidebar)</p>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Menu</button>
        </div>
    </form>
</div>
@endsection