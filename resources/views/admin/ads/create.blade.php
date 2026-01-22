@extends('layouts.admin')

@section('title', 'Create Ad Space')

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.ads.store') }}">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Ad Space Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div class="form-group">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="position" class="form-label">Position *</label>
                    <select id="position" name="position" class="form-input" required>
                        <option value="">Select Position</option>
                        @foreach($positions as $key => $name)
                            <option value="{{ $key }}" {{ old('position') === $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="type" class="form-label">Type *</label>
                    <select id="type" name="type" class="form-input" required>
                        <option value="">Select Type</option>
                        @foreach($types as $key => $name)
                            <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="code" class="form-label">Ad Code *</label>
                    <textarea id="code" name="code" rows="8" 
                              class="form-input font-mono text-sm" required>{{ old('code') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Paste your ad code here (HTML/JavaScript)</p>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" 
                               {{ old('status', true) ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Ad Space</button>
        </div>
    </form>
</div>
@endsection