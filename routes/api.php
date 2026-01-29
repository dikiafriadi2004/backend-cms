<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Routes v1
Route::prefix('v1')->group(function () {
    
    // Posts API
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/featured', [PostController::class, 'featured']);
        Route::get('/latest', [PostController::class, 'latest']);
        Route::get('/infinite', [PostController::class, 'infinite']);
        Route::get('/search', [PostController::class, 'search']);
        Route::get('/{slug}', [PostController::class, 'show']);
    });
    
    // Pages API
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index']);
        Route::get('/homepage', [PageController::class, 'homepage']);
        Route::get('/menu', [PageController::class, 'menu']);
        Route::get('/{slug}', [PageController::class, 'show']);
    });
    
    // Categories API
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{slug}', [CategoryController::class, 'show']);
        Route::get('/{slug}/posts', [CategoryController::class, 'posts']);
    });
    
    // Tags API
    Route::prefix('tags')->group(function () {
        Route::get('/', [TagController::class, 'index']);
        Route::get('/popular', [TagController::class, 'popular']);
        Route::get('/{slug}', [TagController::class, 'show']);
        Route::get('/{slug}/posts', [TagController::class, 'posts']);
    });
    
    // Menus API
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::get('/navigation', [MenuController::class, 'navigation']);
        Route::get('/footer', [MenuController::class, 'footer']);
        Route::get('/{slug}', [MenuController::class, 'show']);
    });
    
    // Settings API
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::get('/general', [SettingController::class, 'general']);
        Route::get('/seo', [SettingController::class, 'seo']);
        Route::get('/social', [SettingController::class, 'social']);
        Route::get('/company', [SettingController::class, 'company']);
        Route::get('/{key}', [SettingController::class, 'show']);
    });
    
    // Contact API
    Route::prefix('contact')->group(function () {
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/settings', [ContactController::class, 'config']);
    });
    
    // Ads API
    Route::prefix('ads')->group(function () {
        Route::get('/', [AdController::class, 'index']);
        Route::get('/positions', [AdController::class, 'positions']);
        Route::get('/position/{position}', [AdController::class, 'position']);
        Route::post('/{id}/click', [AdController::class, 'click']);
        Route::get('/{id}/analytics', [AdController::class, 'analytics']);
    });
    
    // Company API
    Route::prefix('company')->group(function () {
        Route::get('/profile', [CompanyController::class, 'profile']);
        Route::get('/site-settings', [CompanyController::class, 'siteSettings']);
        Route::get('/whatsapp-link', [CompanyController::class, 'whatsappLink']);
        Route::get('/statistics', [CompanyController::class, 'statistics']);
    });
    
    // Content API (Alternative endpoints with different structure)
    Route::prefix('content')->group(function () {
        Route::get('/posts', [ContentController::class, 'posts']);
        Route::get('/posts/featured', [ContentController::class, 'featuredPosts']);
        Route::get('/posts/latest', [ContentController::class, 'latestPosts']);
        Route::get('/post/{slug}', [ContentController::class, 'post']);
        Route::get('/pages', [ContentController::class, 'pages']);
        Route::get('/page/{slug}', [ContentController::class, 'page']);
        Route::get('/categories', [ContentController::class, 'categories']);
        Route::get('/tags', [ContentController::class, 'tags']);
        Route::get('/menu/{location}', [ContentController::class, 'menu']);
        Route::get('/search', [ContentController::class, 'search']);
    });
    
    // Sitemap API
    Route::get('/sitemap', function () {
        $posts = \App\Models\Post::select(['slug', 'updated_at'])->published()->get();
        $pages = \App\Models\Page::select(['slug', 'updated_at'])->published()->get();
        $categories = \App\Models\Category::select(['slug', 'updated_at'])->get();
        $tags = \App\Models\Tag::select(['slug', 'updated_at'])->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'pages' => $pages,
                'categories' => $categories,
                'tags' => $tags
            ]
        ]);
    });
});