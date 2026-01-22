<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->published()
            ->latest();

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $posts = $query->paginate($perPage);

        return response()->json([
            'success' => true,
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
                'links' => $this->generatePaginationLinks($posts)
            ]
        ]);
    }

    /**
     * Display the specified post.
     */
    public function show($slug)
    {
        $post = Post::with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->where('slug', $slug)
            ->published()
            ->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        // Get related posts from the same category
        $relatedPosts = Post::with(['category:id,name,slug,color'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest()
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $post,
            'related_posts' => $relatedPosts
        ]);
    }

    /**
     * Get featured posts.
     */
    public function featured()
    {
        $posts = Post::with(['user:id,name', 'category:id,name,slug,color'])
            ->where('featured', true)
            ->published()
            ->latest()
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Get latest posts.
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 5);
        
        $posts = Post::with(['category:id,name,slug,color'])
            ->published()
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Get posts for infinite scroll
     */
    public function infinite(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        
        $query = Post::with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->published()
            ->latest();

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'has_more' => $posts->hasMorePages(),
            'current_page' => $posts->currentPage(),
            'total' => $posts->total()
        ]);
    }

    /**
     * Search posts.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $posts = Post::with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->published()
            ->latest()
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
            'query' => $query,
            'total' => $posts->count()
        ]);
    }

    /**
     * Generate pagination links for easier navigation
     */
    private function generatePaginationLinks($paginator)
    {
        $links = [];
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        
        // Always show first page
        if ($currentPage > 3) {
            $links[] = [
                'url' => $paginator->url(1),
                'label' => '1',
                'active' => false
            ];
            
            if ($currentPage > 4) {
                $links[] = [
                    'url' => null,
                    'label' => '...',
                    'active' => false
                ];
            }
        }
        
        // Show pages around current page
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
        
        for ($i = $start; $i <= $end; $i++) {
            $links[] = [
                'url' => $paginator->url($i),
                'label' => (string) $i,
                'active' => $i === $currentPage
            ];
        }
        
        // Always show last page
        if ($currentPage < $lastPage - 2) {
            if ($currentPage < $lastPage - 3) {
                $links[] = [
                    'url' => null,
                    'label' => '...',
                    'active' => false
                ];
            }
            
            $links[] = [
                'url' => $paginator->url($lastPage),
                'label' => (string) $lastPage,
                'active' => false
            ];
        }
        
        return $links;
    }
}