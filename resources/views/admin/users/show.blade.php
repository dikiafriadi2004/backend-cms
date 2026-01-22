@extends('layouts.admin')

@section('title', $user->name)

@section('header-actions')
    @can('edit users')
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit User
        </a>
    @endcan
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-body">
                <div class="flex items-center mb-6">
                    <img class="h-20 w-20 rounded-full object-cover mr-6" 
                         src="{{ $user->avatar_url }}" 
                         alt="{{ $user->name }}">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex items-center mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->status) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($user->bio)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Bio</h3>
                        <p class="text-gray-700">{{ $user->bio }}</p>
                    </div>
                @endif
                
                <!-- Recent Posts -->
                @if($user->posts->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Posts</h3>
                        <div class="space-y-3">
                            @foreach($user->posts->take(5) as $post)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $post->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($post->status === 'published') bg-green-100 text-green-800
                                        @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Recent Pages -->
                @if($user->pages->count() > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Pages</h3>
                        <div class="space-y-3">
                            @foreach($user->pages->take(5) as $page)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $page->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $page->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($page->status === 'published') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($page->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- User Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">User Information</h3>
            </div>
            <div class="card-body space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Joined:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->updated_at->format('M d, Y') }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Posts:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->posts->count() }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Pages:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->pages->count() }}</span>
                </div>
            </div>
        </div>
        
        <!-- Roles -->
        @if($user->roles->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Roles</h3>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    @foreach($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection