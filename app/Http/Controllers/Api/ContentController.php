<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Menu;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function posts(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $category = $request->get('category');
        $tag = $request->get('tag');
        $search = $request->get('search');
        $featured = $request->get('featured');

        $query = Post::with(['user', 'category', 'tags'])
            ->published()
            ->latest('published_at');

        // Filter by category
        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Filter by tag
        if ($tag) {
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('slug', $tag);
            });
        }

        // Search in title and content
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter featured posts
        if ($featured) {
            $query->where('featured', true);
        }

        $posts = $query->paginate($perPage);

        // Transform the data
        $posts->getCollection()->transform(function ($post) {
            return $this->transformPost($post);
        });

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'has_more' => $posts->hasMorePages(),
            ]
        ]);
    }

    public function post($slug)
    {
        $post = Post::with(['user', 'category', 'tags'])
            ->where('slug', $slug)
            ->published()
            ->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformPost($post, true)
        ]);
    }

    public function featuredPosts(Request $request)
    {
        $limit = $request->get('limit', 5);

        $posts = Post::with(['user', 'category', 'tags'])
            ->published()
            ->where('featured', true)
            ->latest('published_at')
            ->limit($limit)
            ->get();

        $posts = $posts->map(function ($post) {
            return $this->transformPost($post);
        });

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function latestPosts(Request $request)
    {
        $limit = $request->get('limit', 5);

        $posts = Post::with(['user', 'category', 'tags'])
            ->published()
            ->latest('published_at')
            ->limit($limit)
            ->get();

        $posts = $posts->map(function ($post) {
            return $this->transformPost($post);
        });

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function pages()
    {
        $pages = Page::published()
            ->orderBy('sort_order')
            ->get();

        $pages = $pages->map(function ($page) {
            return $this->transformPage($page);
        });

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->published()
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformPage($page, true)
        ]);
    }

    public function categories()
    {
        $categories = Category::withCount(['posts' => function($query) {
            $query->published();
        }])
        ->orderBy('name')
        ->get();

        $categories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'color' => $category->color,
                'posts_count' => $category->posts_count,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function tags()
    {
        $tags = Tag::withCount(['posts' => function($query) {
            $query->published();
        }])
        ->orderBy('name')
        ->get();

        $tags = $tags->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'color' => $tag->color,
                'posts_count' => $tag->posts_count,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }

    public function menu($location)
    {
        $menu = Menu::with('items')
            ->where('location', $location)
            ->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found'
            ], 404);
        }

        $menuItems = $menu->items()
            ->orderBy('order')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => $item->url,
                    'type' => $item->type,
                    'target' => $item->target,
                    'order' => $item->order,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'location' => $menu->location,
                'items' => $menuItems
            ]
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $limit = $request->get('limit', 10);

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        // Search posts
        $posts = Post::with(['user', 'category', 'tags'])
            ->published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get()
            ->map(function ($post) {
                return array_merge($this->transformPost($post), ['type' => 'post']);
            });

        // Search pages
        $pages = Page::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get()
            ->map(function ($page) {
                return array_merge($this->transformPage($page), ['type' => 'page']);
            });

        $results = $posts->concat($pages)->take($limit);

        return response()->json([
            'success' => true,
            'data' => $results,
            'query' => $query,
            'total_found' => $results->count()
        ]);
    }

    private function transformPost($post, $includeContent = false)
    {
        $data = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'featured' => $post->featured,
            'published_at' => $post->published_at?->toISOString(),
            'created_at' => $post->created_at->toISOString(),
            'updated_at' => $post->updated_at->toISOString(),
            'thumbnail_url' => $post->thumbnail_url,
            'author' => [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'avatar_url' => $post->user->avatar_url,
            ],
            'category' => $post->category ? [
                'id' => $post->category->id,
                'name' => $post->category->name,
                'slug' => $post->category->slug,
                'color' => $post->category->color,
            ] : null,
            'tags' => $post->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'color' => $tag->color,
                ];
            }),
            'meta' => [
                'title' => $post->meta_title,
                'description' => $post->meta_description,
                'keywords' => $post->meta_keywords,
            ]
        ];

        if ($includeContent) {
            $data['content'] = $post->content;
        }

        return $data;
    }

    private function transformPage($page, $includeContent = false)
    {
        $data = [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'excerpt' => $page->excerpt,
            'template' => $page->template,
            'sort_order' => $page->sort_order,
            'show_in_menu' => $page->show_in_menu,
            'is_homepage' => $page->is_homepage,
            'created_at' => $page->created_at->toISOString(),
            'updated_at' => $page->updated_at->toISOString(),
            'meta' => [
                'title' => $page->meta_title,
                'description' => $page->meta_description,
                'keywords' => $page->meta_keywords,
            ]
        ];

        if ($includeContent) {
            $data['content'] = $page->content;
        }

        return $data;
    }
}
