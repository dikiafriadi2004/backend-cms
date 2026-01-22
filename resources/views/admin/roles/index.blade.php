@extends('layouts.admin')

@section('title', 'Roles & Permissions')

@section('header-actions')
    @can('create roles')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Role
        </a>
    @endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">All Roles</h3>
    </div>
    
    <div class="card-body p-0">
        @if($roles->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Users Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-sm font-medium text-gray-900">
                                    {{ $role->name }}
                                </td>
                                <td>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions->take(3) as $permission)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 3)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-600">
                                                +{{ $role->permissions->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-sm text-gray-900">
                                    {{ $role->users_count }}
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $role->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @can('edit roles')
                                            <a href="{{ route('admin.roles.edit', $role) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @endcan
                                        
                                        @can('delete roles')
                                            @if($role->name !== 'Super Admin')
                                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Delete Role"
                                                      data-confirm-message="Are you sure you want to delete the '{{ $role->name }}' role? This action cannot be undone and will remove the role from all assigned users.">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No roles</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
                @can('create roles')
                    <div class="mt-6">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Role
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection