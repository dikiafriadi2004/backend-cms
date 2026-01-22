@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="form-container">
    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-6">
            <!-- User Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="form-group">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" name="bio" rows="3" 
                                  class="form-input">{{ old('bio') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" 
                               class="form-input">
                        <p class="text-sm text-gray-500 mt-1">Max size: 2MB</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="flex items-center">
                            <input type="checkbox" name="status" value="1" 
                                   {{ old('status', true) ? 'checked' : '' }} class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Active User</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Roles -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Roles</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-2">
                        @foreach($roles as $role)
                            <label class="flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }} 
                                       class="rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>
</div>
@endsection