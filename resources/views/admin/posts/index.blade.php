@extends('layouts.admin')

@section('title', 'Posts')
@section('subtitle', 'Manage your blog posts and content')

@section('header-actions')
    @can('create posts')
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Post
        </a>
    @endcan
@endsection

@section('content')
<div class="card shadow-soft">
    <div class="card-header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <!-- Tabs -->
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('admin.posts.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ !request('view') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                    All Posts
                </a>
                <a href="{{ route('admin.posts.index', ['view' => 'trash']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200 flex items-center {{ request('view') === 'trash' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Trash
                    @if(isset($trashCount) && $trashCount > 0)
                        <span class="ml-1 bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">{{ $trashCount }}</span>
                    @endif
                </a>
            </div>
            
            <!-- Filters and Actions -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                @if(request('view') === 'trash' && $posts->count() > 0)
                    <form method="POST" action="{{ route('admin.posts.empty-trash') }}" 
                          class="inline" data-confirm-delete 
                          data-confirm-title="Empty Trash"
                          data-confirm-message="Are you sure you want to permanently delete all posts in trash? This action cannot be undone and will remove all associated media files.">
                        @csrf
                        <button type="submit" class="btn btn-danger text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Empty Trash
                        </button>
                    </form>
                @endif

                @if(request('view') !== 'trash')
                    <!-- Filters -->
                    <form method="GET" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search posts..." class="form-input text-sm w-full sm:w-auto">
                        
                        <select name="status" class="form-select text-sm w-full sm:w-auto">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                        
                        <select name="category" class="form-select text-sm w-full sm:w-auto">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="btn btn-secondary text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                            Filter
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($posts->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            @if(request('view') !== 'trash')
                                <th>Category</th>
                                <th>Status</th>
                                <th>Published</th>
                            @else
                                <th>Deleted</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($posts as $post)
                            <tr class="{{ request('view') === 'trash' ? 'opacity-75' : '' }}">
                                <td>
                                    <div class="flex items-center">
                                        @if($post->getFirstMediaUrl('thumbnail'))
                                            <img class="h-10 w-10 rounded object-cover mr-3" 
                                                 src="{{ $post->getFirstMediaUrl('thumbnail', 'thumb') }}" 
                                                 alt="{{ $post->title }}">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($post->title, 50) }}
                                            </div>
                                            @if($post->featured && request('view') !== 'trash')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm text-gray-900">{{ $post->user->name }}</td>
                                @if(request('view') !== 'trash')
                                    <td class="text-sm text-gray-900">
                                        {{ $post->category ? $post->category->name : '-' }}
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($post->status === 'published') bg-green-100 text-green-800
                                            @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-gray-500">
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}
                                    </td>
                                @else
                                    <td class="text-sm text-gray-500">
                                        {{ $post->deleted_at->format('M d, Y H:i') }}
                                    </td>
                                @endif
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if(request('view') === 'trash')
                                            <!-- Trash Actions -->
                                            @can('edit posts')
                                                <form method="POST" action="{{ route('admin.posts.restore', $post->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                        Restore
                                                    </button>
                                                </form>
                                            @endcan
                                            
                                            @can('delete posts')
                                                <form method="POST" action="{{ route('admin.posts.force-delete', $post->id) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Permanently Delete Post"
                                                      data-confirm-message="Are you sure you want to permanently delete '{{ $post->title }}'? This action cannot be undone and will remove all associated media files.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete Forever
                                                    </button>
                                                </form>
                                            @endcan
                                        @else
                                            <!-- Normal Actions -->
                                            <a href="{{ route('admin.posts.show', $post) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                            
                                            @can('edit posts')
                                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endcan
                                            
                                            @can('delete posts')
                                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Move to Trash"
                                                      data-confirm-message="Are you sure you want to move '{{ $post->title }}' to trash? You can restore it later from the trash.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Trash
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                @if(request('view') === 'trash')
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Trash is empty</h3>
                    <p class="mt-2 text-gray-500">No posts in trash. Deleted posts will appear here.</p>
                @else
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No posts</h3>
                    <p class="mt-2 text-gray-500">Get started by creating a new post.</p>
                    @can('create posts')
                        <div class="mt-6">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Post
                            </a>
                        </div>
                    @endcan
                @endif
            </div>
        @endif
    </div>
</div>
@endsection