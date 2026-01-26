<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags']);

        // Handle trash view
        if ($request->get('view') === 'trash') {
            $query->onlyTrashed();
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->get('view') !== 'trash') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest()->paginate(10);
        $categories = Category::all();
        
        // Get trash count for the tab
        $trashCount = Post::onlyTrashed()->count();

        return view('admin.posts.index', compact('posts', 'categories', 'trashCount'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:300',
            'content' => 'required',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $post = new Post($request->all());
        $post->user_id = Auth::id();
        
        // Auto-generate slug if not provided
        if (empty($request->slug)) {
            $post->slug = \Str::slug($request->title);
        }
        
        if ($request->status === 'published' && !$request->filled('published_at')) {
            $post->published_at = now();
        }

        $post->save();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        // Sync tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        $message = 'Post berhasil dibuat.';
        
        // Handle different actions
        if ($request->action === 'save_and_continue') {
            return redirect()->route('admin.posts.edit', $post)
                ->with('success', $message);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', $message);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load('tags');
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:300',
            'content' => 'required',
            'status' => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:categories,id',
            'published_at' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'remove_thumbnail' => 'nullable|boolean'
        ]);

        $post->fill($request->all());

        // Auto-generate slug if not provided
        if (empty($request->slug)) {
            $post->slug = \Str::slug($request->title);
        }

        if ($request->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }

        $post->save();

        // Handle thumbnail removal
        if ($request->remove_thumbnail) {
            $post->clearMediaCollection('thumbnail');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $post->clearMediaCollection('thumbnail');
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        // Sync tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        $message = 'Post berhasil diupdate.';
        
        // Handle different actions
        if ($request->action === 'update_and_continue') {
            return redirect()->route('admin.posts.edit', $post)
                ->with('success', $message);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', $message);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dipindahkan ke trash.');
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dipulihkan dari trash.');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        
        // This will trigger the forceDeleted event in the model
        // which will clean up all media files
        $post->forceDelete();
        
        return redirect()->route('admin.posts.index', ['view' => 'trash'])
            ->with('success', 'Post berhasil dihapus permanen.');
    }

    public function emptyTrash()
    {
        // Check permission
        if (!auth()->user()->can('delete posts')) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $posts = Post::onlyTrashed()->get();
            
            if ($posts->count() === 0) {
                return redirect()->route('admin.posts.index', ['view' => 'trash'])
                    ->with('info', 'Trash sudah kosong.');
            }
            
            $count = $posts->count();
            
            foreach ($posts as $post) {
                $post->forceDelete();
            }
            
            return redirect()->route('admin.posts.index', ['view' => 'trash'])
                ->with('success', "Berhasil menghapus {$count} post dari trash secara permanen.");
        } catch (\Exception $e) {
            Log::error('Error emptying posts trash: ' . $e->getMessage());
            return redirect()->route('admin.posts.index', ['view' => 'trash'])
                ->with('error', 'Terjadi kesalahan saat mengosongkan trash.');
        }
    }
}