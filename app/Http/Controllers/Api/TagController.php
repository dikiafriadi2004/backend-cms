<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }

    /**
     * Display the specified tag.
     */
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)
            ->withCount('posts')
            ->first();

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Get tag posts.
     */
    public function posts($slug, Request $request)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found'
            ], 404);
        }

        $query = $tag->posts()
            ->with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->published()
            ->latest();

        $perPage = $request->get('per_page', 10);
        $posts = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'tag' => $tag,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
                'has_more' => $posts->hasMorePages(),
                'has_previous' => $posts->currentPage() > 1,
                'next_page_url' => $posts->nextPageUrl(),
                'prev_page_url' => $posts->previousPageUrl(),
                'first_page_url' => $posts->url(1),
                'last_page_url' => $posts->url($posts->lastPage()),
            ]
        ]);
    }

    /**
     * Get popular tags.
     */
    public function popular(Request $request)
    {
        $limit = $request->get('limit', 10);
        
        $tags = Tag::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }
}