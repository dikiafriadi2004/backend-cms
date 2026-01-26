<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        // For now, redirect to admin dashboard
        // In a real frontend, this would show the homepage
        return redirect()->route('admin.dashboard');
    }

    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // For now, return JSON response since this is API-only
        // In a real frontend, this would return a view
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'excerpt' => $page->excerpt,
                'featured_image' => $page->featured_image,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'status' => $page->status,
                'published_at' => $page->published_at,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at,
            ]
        ]);
    }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'tags', 'user'])
            ->firstOrFail();

        // For now, return JSON response since this is API-only
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'excerpt' => $post->excerpt,
                'featured_image' => $post->featured_image,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'status' => $post->status,
                'published_at' => $post->published_at,
                'category' => $post->category,
                'tags' => $post->tags,
                'author' => $post->user,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        ]);
    }

    public function blog()
    {
        $posts = Post::where('status', 'published')
            ->with(['category', 'tags', 'user'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function blogCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $posts = Post::where('status', 'published')
            ->where('category_id', $category->id)
            ->with(['category', 'tags', 'user'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'posts' => $posts
            ]
        ]);
    }

    public function blogTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        $posts = Post::where('status', 'published')
            ->whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with(['category', 'tags', 'user'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => [
                'tag' => $tag,
                'posts' => $posts
            ]
        ]);
    }

    public function contact()
    {
        // For now, return JSON response with contact info
        // In a real frontend, this would return a contact form view
        $settings = [
            'contact_email' => setting('contact_email', config('mail.from.address')),
            'contact_phone' => setting('contact_phone', ''),
            'contact_address' => setting('contact_address', ''),
            'business_hours' => setting('business_hours', ''),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Contact page - Use POST /api/v1/contact/ for form submission',
            'data' => $settings,
            'api_endpoint' => url('/api/v1/contact/')
        ]);
    }

    public function submitContact(Request $request)
    {
        // Redirect to API endpoint for actual form submission
        return response()->json([
            'success' => false,
            'message' => 'Please use the API endpoint for contact form submission',
            'correct_endpoint' => url('/api/v1/contact/'),
            'method' => 'POST',
            'note' => 'This frontend route is for display only. Use the API endpoint for form submission.'
        ], 400);
    }
}