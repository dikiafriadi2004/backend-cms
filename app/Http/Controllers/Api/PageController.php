<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of published pages.
     */
    public function index()
    {
        $pages = Page::with(['user:id,name'])
            ->published()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    /**
     * Display the specified page.
     */
    public function show($slug)
    {
        $page = Page::with(['user:id,name'])
            ->where('slug', $slug)
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
            'data' => $page
        ]);
    }

    /**
     * Get homepage.
     */
    public function homepage()
    {
        $page = Page::with(['user:id,name'])
            ->where('is_homepage', true)
            ->published()
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Homepage not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $page
        ]);
    }

    /**
     * Get pages for menu.
     */
    public function menu()
    {
        $pages = Page::select(['id', 'title', 'slug'])
            ->where('show_in_menu', true)
            ->published()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }
}