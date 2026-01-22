@extends('layouts.admin')

@section('title', 'Menus')

@section('header-actions')
    @can('create menus')
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Menu
        </a>
    @endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">All Menus</h3>
    </div>
    
    <div class="card-body p-0">
        @if($menus->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Items Count</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($menus as $menu)
                            <tr>
                                <td class="text-sm font-medium text-gray-900">
                                    {{ $menu->name }}
                                </td>
                                <td class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $menu->location }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900">
                                    {{ $menu->items_count }}
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $menu->description ? Str::limit($menu->description, 50) : '-' }}
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @can('edit menus')
                                            <a href="{{ route('admin.menus.edit', $menu) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Manage</a>
                                        @endcan
                                        
                                        @can('delete menus')
                                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" 
                                                  class="inline" data-confirm-delete 
                                                  data-confirm-title="Delete Menu"
                                                  data-confirm-message="Are you sure you want to delete '{{ $menu->name }}'? This action cannot be undone and will permanently remove the menu and all its items.">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No menus</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new menu.</p>
                @can('create menus')
                    <div class="mt-6">
                        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Menu
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection