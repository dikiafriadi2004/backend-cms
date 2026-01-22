@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                    <p class="text-sm text-gray-600">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       class="form-input" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="form-input" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" rows="4" 
                                          class="form-input" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Maximum 500 characters</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                    <p class="text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password *</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="form-input" required>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">New Password *</label>
                                <input type="password" id="password" name="password" 
                                       class="form-input" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 0h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Avatar -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Profile Picture</h3>
                </div>
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="avatar-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Current Avatar -->
                        <div class="mb-4">
                            @if($user->avatar)
                                <div class="relative inline-block">
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                                         class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-gray-200">
                                    <button type="button" id="remove-avatar" 
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm hover:bg-red-600 transform translate-x-2 -translate-y-2">
                                        ×
                                    </button>
                                </div>
                                <input type="hidden" name="remove_avatar" id="remove_avatar_input" value="0">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto flex items-center justify-center border-4 border-gray-200">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Upload New Avatar -->
                        <div class="form-group">
                            <input type="file" id="avatar" name="avatar" 
                                   class="form-input" accept="image/*">
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                        </div>
                        
                        <!-- Preview -->
                        <div id="avatar-preview" class="mt-4 hidden">
                            <img id="preview-avatar" src="" alt="Preview" 
                                 class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-200">
                        </div>
                        
                        <!-- Hidden fields to maintain other data -->
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="bio" value="{{ $user->bio }}">
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Avatar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Account Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Role:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->roles->first()->name ?? 'No Role' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Member Since:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Last Updated:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->updated_at->format('M d, Y H:i') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Avatar preview
    const avatarInput = document.getElementById('avatar');
    const previewContainer = document.getElementById('avatar-preview');
    const previewImage = document.getElementById('preview-avatar');
    const removeAvatarBtn = document.getElementById('remove-avatar');
    const removeAvatarInput = document.getElementById('remove_avatar_input');
    
    avatarInput.addEventListener('change', function(e) {
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
    
    if (removeAvatarBtn) {
        removeAvatarBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                removeAvatarInput.value = '1';
                document.getElementById('avatar-form').submit();
            }
        });
    }
});
</script>
@endpush
@endsection