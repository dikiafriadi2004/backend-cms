@extends('layouts.admin')

@section('title', $page->title)

@section('header-actions')
    @can('edit pages')
        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Page
        </a>
    @endcan
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-body">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>
                
                <div class="prose max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Page Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Page Information</h3>
            </div>
            <div class="card-body space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
                        @if($page->status === 'published') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($page->status) }}
                    </span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Template:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ ucfirst($page->template) }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Author:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $page->user->name }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Created:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $page->created_at->format('M d, Y H:i') }}</span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $page->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <!-- SEO Info -->
        @if($page->meta_title || $page->meta_description)
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">SEO Information</h3>
            </div>
            <div class="card-body space-y-3">
                @if($page->meta_title)
                <div>
                    <span class="text-sm font-medium text-gray-500">Meta Title:</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $page->meta_title }}</p>
                </div>
                @endif
                
                @if($page->meta_description)
                <div>
                    <span class="text-sm font-medium text-gray-500">Meta Description:</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $page->meta_description }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection