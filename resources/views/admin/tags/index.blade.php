@extends('layouts.admin')

@section('title', 'Tags')

@section('header-actions')
    @can('create tags')
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Tag
        </a>
    @endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">All Tags</h3>
    </div>
    
    <div class="card-body p-0">
        @if($tags->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tags as $tag)
                            <tr>
                                <td class="text-sm font-medium text-gray-900">
                                    {{ $tag->name }}
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $tag->slug }}
                                </td>
                                <td class="text-sm text-gray-900">
                                    {{ $tag->posts_count }}
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $tag->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @can('edit tags')
                                            <a href="{{ route('admin.tags.edit', $tag) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @endcan
                                        
                                        @can('delete tags')
                                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" 
                                                  class="inline" data-confirm-delete 
                                                  data-confirm-title="Delete Tag"
                                                  data-confirm-message="Are you sure you want to delete '{{ $tag->name }}'? This action cannot be undone and will permanently remove the tag from all associated posts.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tags</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new tag.</p>
                @can('create tags')
                    <div class="mt-6">
                        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Tag
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection