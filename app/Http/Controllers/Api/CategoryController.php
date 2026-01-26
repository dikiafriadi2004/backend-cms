<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->withCount('posts')
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function posts($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $query = $category->posts()
            ->with(['user:id,name', 'category:id,name,slug,color', 'tags:id,name,slug,color'])
            ->published()
            ->latest();

        $perPage = $request->get('per_page', 10);
        $posts = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'category' => $category,
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
}