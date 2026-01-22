@extends('layouts.admin')

@section('title', 'Users')

@section('header-actions')
    @can('create users')
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New User
        </a>
    @endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">All Users</h3>
    </div>
    
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover mr-3" 
                                             src="{{ $user->avatar_url }}" 
                                             alt="{{ $user->name }}">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if($user->bio)
                                                <div class="text-sm text-gray-500">{{ Str::limit($user->bio, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm text-gray-900">{{ $user->email }}</td>
                                <td>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($user->status) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-primary-600 hover:text-primary-900">View</a>
                                        
                                        @can('edit users')
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @endcan
                                        
                                        @can('delete users')
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                      class="inline" data-confirm-delete 
                                                      data-confirm-title="Delete User"
                                                      data-confirm-message="Are you sure you want to delete '{{ $user->name }}'? This action cannot be undone and will permanently remove the user account and all associated data.">
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
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No users</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                @can('create users')
                    <div class="mt-6">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New User
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection