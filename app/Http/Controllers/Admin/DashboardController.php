<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'pages' => Page::count(),
            'users' => User::count(),
            'categories' => Category::count(),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        $recent_pages = Page::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_pages'));
    }
}