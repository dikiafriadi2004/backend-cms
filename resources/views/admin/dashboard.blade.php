@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Welcome back! Here\'s what\'s happening with your content.')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Posts -->
    <div class="card animate-fade-in shadow-soft hover:shadow-glow transition-all duration-300">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-gradient-to-r from-blue-100 to-blue-200 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Posts</p>
                    <p class="text-3xl font-bold gradient-text">{{ $stats['posts'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">All content posts</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Published Posts -->
    <div class="card animate-fade-in shadow-soft hover:shadow-glow transition-all duration-300" style="animation-delay: 0.1s">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-gradient-to-r from-green-100 to-emerald-200 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Published</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['published_posts'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Live on website</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages -->
    <div class="card animate-fade-in shadow-soft hover:shadow-glow transition-all duration-300" style="animation-delay: 0.2s">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-gradient-to-r from-purple-100 to-purple-200 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pages</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['pages'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Static pages</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="card animate-fade-in shadow-soft hover:shadow-glow transition-all duration-300" style="animation-delay: 0.3s">
        <div class="card-body">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-gradient-to-r from-yellow-100 to-orange-200 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Users</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['users'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered users</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Overview -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Recent Posts -->
    <div class="card animate-slide-up shadow-soft">
        <div class="card-header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Recent Posts
                </h3>
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View all →
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($recent_posts->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_posts as $post)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors duration-200">
                                    <a href="{{ route('admin.posts.show', $post) }}">
                                        {{ Str::limit($post->title, 40) }}
                                    </a>
                                </h4>
                                <div class="flex items-center mt-1 space-x-2">
                                    <img class="w-4 h-4 rounded-full" src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}">
                                    <p class="text-xs text-gray-500">
                                        {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ml-3
                                @if($post->status === 'published') bg-green-100 text-green-800 border border-green-200
                                @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 mt-2">No posts yet</p>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary mt-4">Create your first post</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Pages -->
    <div class="card animate-slide-up shadow-soft" style="animation-delay: 0.1s">
        <div class="card-header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Recent Pages
                </h3>
                <a href="{{ route('admin.pages.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                    View all →
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($recent_pages->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_pages as $page)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900 hover:text-purple-600 transition-colors duration-200">
                                    <a href="{{ route('admin.pages.show', $page) }}">
                                        {{ Str::limit($page->title, 40) }}
                                    </a>
                                </h4>
                                <div class="flex items-center mt-1 space-x-2">
                                    <img class="w-4 h-4 rounded-full" src="{{ $page->user->avatar_url }}" alt="{{ $page->user->name }}">
                                    <p class="text-xs text-gray-500">
                                        {{ $page->user->name }} • {{ $page->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ml-3
                                @if($page->status === 'published') bg-green-100 text-green-800 border border-green-200
                                @else bg-yellow-100 text-yellow-800 border border-yellow-200 @endif">
                                {{ ucfirst($page->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <p class="text-gray-500 mt-2">No pages yet</p>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mt-4">Create your first page</a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.posts.create') }}" class="card hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
        <div class="card-body text-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-blue-100 to-blue-200 text-blue-600 mx-auto w-fit group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">New Post</h3>
            <p class="text-xs text-gray-500 mt-1">Create a new blog post</p>
        </div>
    </a>

    <a href="{{ route('admin.pages.create') }}" class="card hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
        <div class="card-body text-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-purple-100 to-purple-200 text-purple-600 mx-auto w-fit group-hover:from-purple-200 group-hover:to-purple-300 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-300">New Page</h3>
            <p class="text-xs text-gray-500 mt-1">Create a static page</p>
        </div>
    </a>

    <a href="{{ route('admin.filemanager.index') }}" class="card hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
        <div class="card-body text-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-green-100 to-emerald-200 text-green-600 mx-auto w-fit group-hover:from-green-200 group-hover:to-emerald-300 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-300">File Manager</h3>
            <p class="text-xs text-gray-500 mt-1">Manage media files</p>
        </div>
    </a>

    <a href="{{ route('admin.settings.index') }}" class="card hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
        <div class="card-body text-center">
            <div class="p-3 rounded-full bg-gradient-to-r from-yellow-100 to-orange-200 text-yellow-600 mx-auto w-fit group-hover:from-yellow-200 group-hover:to-orange-300 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300">Settings</h3>
            <p class="text-xs text-gray-500 mt-1">Configure your site</p>
        </div>
    </a>
</div>

<!-- Analytics Overview -->
<div class="card animate-slide-up shadow-soft">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Analytics Overview
        </h3>
    </div>
    <div class="card-body">
        <div class="text-center py-12">
            <div class="p-4 rounded-full bg-gradient-to-r from-indigo-100 to-purple-200 text-indigo-600 mx-auto w-fit">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-900">Google Analytics Integration</h3>
            <p class="mt-2 text-gray-500 max-w-md mx-auto">Configure Google Analytics to see detailed website statistics, visitor insights, and performance metrics right here on your dashboard.</p>
            <div class="mt-6">
                <a href="{{ route('admin.settings.analytics') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configure Analytics
                </a>
            </div>
        </div>
    </div>
</div>
@endsection