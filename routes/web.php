<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdSpaceController;
use App\Http\Controllers\Admin\ContactController;

// Homepage - Redirect to login for security
Route::get('/', [App\Http\Controllers\FrontendController::class, 'home'])->name('home');

// Frontend routes for pages and posts (API responses for now)
Route::get('/page/{slug}', [App\Http\Controllers\FrontendController::class, 'showPage'])->name('page.show');
Route::get('/blog', [App\Http\Controllers\FrontendController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\FrontendController::class, 'showPost'])->name('post.show');
Route::get('/blog/category/{slug}', [App\Http\Controllers\FrontendController::class, 'blogCategory'])->name('blog.category');
Route::get('/blog/tag/{slug}', [App\Http\Controllers\FrontendController::class, 'blogTag'])->name('blog.tag');

// Contact routes - Frontend contact page
Route::get('/contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\FrontendController::class, 'submitContact'])->name('contact.submit');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts Management
    Route::resource('posts', PostController::class);
    Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');
    Route::post('posts/empty-trash', [PostController::class, 'emptyTrash'])->name('posts.empty-trash');
    
    // Categories Management
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // Tags Management
    Route::resource('tags', TagController::class)->except(['show']);
    Route::post('tags/quick-create', [TagController::class, 'quickCreate'])->name('tags.quick-create');
    
    // Pages Management
    Route::resource('pages', PageController::class);
    Route::post('pages/{id}/restore', [PageController::class, 'restore'])->name('pages.restore');
    Route::delete('pages/{id}/force-delete', [PageController::class, 'forceDelete'])->name('pages.force-delete');
    Route::post('pages/empty-trash', [PageController::class, 'emptyTrash'])->name('pages.empty-trash');
    
    // Menu Management
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::post('menus/{menu}/items', [MenuController::class, 'addItem'])->name('menus.add-item');
    Route::post('menus/update-order', [MenuController::class, 'updateOrder'])->name('menus.update-order');
    Route::delete('menu-items/{item}', [MenuController::class, 'deleteItem'])->name('menu-items.destroy');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Role & Permission Management
    Route::resource('roles', RoleController::class)->except(['show']);
    
    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/general', [SettingController::class, 'general'])->name('general');
        Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general.update');
        Route::get('/seo', [SettingController::class, 'seo'])->name('seo');
        Route::post('/seo', [SettingController::class, 'updateSeo'])->name('seo.update');
        Route::get('/social', [SettingController::class, 'social'])->name('social');
        Route::post('/social', [SettingController::class, 'updateSocial'])->name('social.update');
        Route::get('/analytics', [SettingController::class, 'analytics'])->name('analytics');
        Route::post('/analytics', [SettingController::class, 'updateAnalytics'])->name('analytics.update');
        Route::get('/company', [SettingController::class, 'company'])->name('company');
        Route::post('/company', [SettingController::class, 'updateCompany'])->name('company.update');
        Route::get('/contact', [SettingController::class, 'contact'])->name('contact');
        Route::post('/contact', [SettingController::class, 'updateContact'])->name('contact.update');
        Route::get('/email', [SettingController::class, 'email'])->name('email');
        Route::post('/email', [SettingController::class, 'updateEmail'])->name('email.update');
        Route::post('/email/test', [SettingController::class, 'testEmail'])->name('email.test');
        Route::get('/email-template', [SettingController::class, 'emailTemplate'])->name('email-template');
        Route::post('/email-template', [SettingController::class, 'updateEmailTemplate'])->name('email-template.update');
        Route::post('/email-template/test', [SettingController::class, 'testEmailTemplate'])->name('email-template.test');
    });
    
    // Profile Management
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Ad Spaces Management
    Route::resource('ads', AdSpaceController::class)->except(['show']);
    Route::patch('ads/{ad}/toggle', [AdSpaceController::class, 'toggle'])->name('ads.toggle');
    
    // Contact Management
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::post('contacts/{contact}/reply', [ContactController::class, 'sendReply'])->name('contacts.reply.send');
    Route::post('contacts/bulk-action', [ContactController::class, 'bulkAction'])->name('contacts.bulk-action');
    Route::get('contacts/export', [ContactController::class, 'export'])->name('contacts.export');
    
    // File Manager - Special handling for iframe loading
    Route::prefix('filemanager')->name('filemanager.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FileManagerController::class, 'index'])->name('index');
        Route::post('/upload', [App\Http\Controllers\Admin\FileManagerController::class, 'upload'])->name('upload');
        Route::get('/browse', [App\Http\Controllers\Admin\FileManagerController::class, 'browse'])->name('browse');
        Route::post('/delete', [App\Http\Controllers\Admin\FileManagerController::class, 'delete'])->name('delete');
    });
});

// Authentication Routes
require __DIR__.'/auth.php';

// Fallback route - Redirect any undefined routes to login for security
Route::fallback(function () {
    return redirect()->route('login');
});