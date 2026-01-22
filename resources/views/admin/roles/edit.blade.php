@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="form-container-wide">
    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Role Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Role Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Role Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" 
                               class="form-input" required>
                    </div>
                </div>
            </div>
            
            <!-- Permissions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Permissions</h3>
                </div>
                <div class="card-body">
                    @foreach($permissions as $group => $groupPermissions)
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach($groupPermissions as $permission)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                               {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }} 
                                               class="rounded">
                                        <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2 mt-6">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Role</button>
        </div>
    </form>
</div>
@endsection