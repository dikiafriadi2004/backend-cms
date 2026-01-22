@extends('layouts.admin')

@section('title', 'Ad Spaces')

@section('header-actions')
    @can('create ads')
        <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Ad Space
        </a>
    @endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-medium text-gray-900">All Ad Spaces</h3>
    </div>
    
    <div class="card-body p-0">
        @if($adSpaces->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($adSpaces as $ad)
                            <tr>
                                <td class="text-sm font-medium text-gray-900">
                                    {{ $ad->name }}
                                    @if($ad->description)
                                        <div class="text-xs text-gray-500">{{ Str::limit($ad->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst(str_replace('_', ' ', $ad->position)) }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($ad->type === 'adsense') bg-blue-100 text-blue-800
                                        @elseif($ad->type === 'adsera') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($ad->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($ad->status) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $ad->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-500">
                                    {{ $ad->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @can('edit ads')
                                            <a href="{{ route('admin.ads.edit', $ad) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form method="POST" action="{{ route('admin.ads.toggle', $ad) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                    {{ $ad->status ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                        @endcan
                                        
                                        @can('delete ads')
                                            <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" 
                                                  class="inline" data-confirm-delete 
                                                  data-confirm-title="Delete Ad Space"
                                                  data-confirm-message="Are you sure you want to delete '{{ $ad->name }}'? This action cannot be undone and will permanently remove the ad space configuration.">
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
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $adSpaces->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No ad spaces</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new ad space.</p>
                @can('create ads')
                    <div class="mt-6">
                        <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Ad Space
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection