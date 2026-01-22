@extends('layouts.admin')

@section('title', $post->title)

@section('header-actions')
    @can('edit posts')
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Post
        </a>
    @endcan
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-body">
                @if($post->getFirstMediaUrl('thumbnail'))
                    <img src="{{ $post->getFirstMediaUrl('thumbnail', 'medium') }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-64 object-cover rounded-lg mb-6">
                @endif
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                @if($post->excerpt)
                    <div class="text-lg text-gray-600 mb-6 italic">
                        {{ $post->excerpt }}
                    </div>
                @endif
                
                <div class="prose max-w-none">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Post Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Post Information</h3>
            </div>
            <div class="card-body space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
                        @if($post->status === 'published') bg-green-100 text-green-800
                        @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($post->status) }}
                    </span>
                </div>
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Author:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $post->user->name }}</span>
                </div>
                
                @if($post->category)
                <div>
                    <span class="text-sm font-medium text-gray-500">Category:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $post->category->name }}</span>
                </div>
                @endif
                
                <div>
                    <span class="text-sm font-medium text-gray-500">Created:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $post->created_at->format('M d, Y H:i') }}</span>
                </div>
                
                @if($post->published_at)
                <div>
                    <span class="text-sm font-medium text-gray-500">Published:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $post->published_at->format('M d, Y H:i') }}</span>
                </div>
                @endif
                
                @if($post->featured)
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Featured Post
                    </span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Tags -->
        @if($post->tags->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Tags</h3>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- SEO Info -->
        @if($post->meta_title || $post->meta_description)
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">SEO Information</h3>
            </div>
            <div class="card-body space-y-3">
                @if($post->meta_title)
                <div>
                    <span class="text-sm font-medium text-gray-500">Meta Title:</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $post->meta_title }}</p>
                </div>
                @endif
                
                @if($post->meta_description)
                <div>
                    <span class="text-sm font-medium text-gray-500">Meta Description:</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $post->meta_description }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection