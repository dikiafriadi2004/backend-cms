@extends('layouts.admin')

@section('title', 'Pages')
@section('subtitle', 'Manage your static pages and content')

@section('header-actions')
    @can('create pages')
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Page
        </a>
    @endcan
@endsection

@section('content')
<div class="card shadow-soft">
    <div class="card-header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <!-- Tabs -->
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <a href="{{ route('admin.pages.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ !request('view') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                    All Pages
                </a>
                <a href="{{ route('admin.pages.index', ['view' => 'trash']) }}" 
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
            
            <!-- Actions -->
            <div class="flex space-x-4">
                @if(request('view') === 'trash' && $pages->count() > 0)
                    <form method="POST" action="{{ route('admin.pages.empty-trash') }}" 
                          class="inline" data-confirm-delete 
                          data-confirm-title="Empty Trash"
                          data-confirm-message="Are you sure you want to permanently delete all pages in trash? This action cannot be undone and will remove all associated media files.">
                        @csrf
                        <button type="submit" class="btn btn-danger text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Empty Trash
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($pages->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Template</th>
                            @if(request('view') !== 'trash')
                                <th>Status</th>
                            @endif
                            <th>Author</th>
                            @if(request('view') === 'trash')
                                <th>Deleted</th>
                            @else
                                <th>Created</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <tr class="{{ request('view') === 'trash' ? 'opacity-75' : '' }}">
                                <td class="text-sm font-medium text-gray-900">
                                    {{ Str::limit($page->title, 50) }}
                                </td>
                                <td class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($page->template) }}
                                    </span>
                                </td>
                                @if(request('view') !== 'trash')
                                    <td>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($page->status === 'published') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($page->status) }}
                                        </span>
                                    </td>
                                @endif
                                <td class="text-sm text-gray-900">{{ $page->user->name }}</td>
                                <td class="text-sm text-gray-500">
                                    @if(request('view') === 'trash')
                                        {{ $page->deleted_at->format('M d, Y H:i') }}
                                    @else
                                        {{ $page->created_at->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if(request('view') === 'trash')
                                            <!-- Trash Actions -->
                                            @can('edit pages')
                                                <form method="POST" action="{{ route('admin.pages.restore', $page->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                        Restore
                                                    </button>
                                                </form>
                                            @endcan
                                            
                                            @can('delete pages')
                                                <form method="POST" action="{{ route('admin.pages.force-delete', $page->id) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Permanently Delete Page"
                                                      data-confirm-message="Are you sure you want to permanently delete '{{ $page->title }}'? This action cannot be undone and will remove all associated media files.">
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
                                            <a href="{{ route('admin.pages.show', $page) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                            
                                            @can('edit pages')
                                                <a href="{{ route('admin.pages.edit', $page) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endcan
                                            
                                            @can('delete pages')
                                                <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Move to Trash"
                                                      data-confirm-message="Are you sure you want to move '{{ $page->title }}' to trash? You can restore it later from the trash.">
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
                {{ $pages->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                @if(request('view') === 'trash')
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Trash is empty</h3>
                    <p class="mt-2 text-gray-500">No pages in trash. Deleted pages will appear here.</p>
                @else
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No pages</h3>
                    <p class="mt-2 text-gray-500">Get started by creating a new page.</p>
                    @can('create pages')
                        <div class="mt-6">
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Page
                            </a>
                        </div>
                    @endcan
                @endif
            </div>
        @endif
    </div>
</div>
@endsection