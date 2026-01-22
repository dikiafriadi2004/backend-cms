<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('user');

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

        $pages = $query->latest()->paginate(15);
        
        // Get trash count for the tab
        $trashCount = Page::onlyTrashed()->count();

        return view('admin.pages.index', compact('pages', 'trashCount'));
    }

    public function create()
    {
        $templates = [
            'default' => 'Default',
            'contact' => 'Contact',
            'privacy' => 'Privacy Policy',
            'about' => 'About Us',
            'blog' => 'Blog'
        ];
        return view('admin.pages.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'template' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable',
            'thumbnail' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $page = new Page($request->all());
        $page->user_id = Auth::id();
        
        // Auto-generate slug if not provided
        if (empty($request->slug)) {
            $page->slug = \Str::slug($request->title);
        }
        
        $page->save();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $page->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        $message = 'Halaman berhasil dibuat.';
        
        // Handle different actions
        if ($request->action === 'save_and_continue') {
            return redirect()->route('admin.pages.edit', $page)
                ->with('success', $message);
        }

        return redirect()->route('admin.pages.index')
            ->with('success', $message);
    }

    public function show(Page $page)
    {
        $page->load('user');
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $templates = [
            'default' => 'Default',
            'contact' => 'Contact',
            'privacy' => 'Privacy Policy',
            'about' => 'About Us',
            'blog' => 'Blog'
        ];
        return view('admin.pages.edit', compact('page', 'templates'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'template' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'meta_keywords' => 'nullable',
            'thumbnail' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'remove_thumbnail' => 'nullable|boolean'
        ]);

        $page->fill($request->all());
        
        // Auto-generate slug if not provided
        if (empty($request->slug)) {
            $page->slug = \Str::slug($request->title);
        }
        
        $page->save();

        // Handle thumbnail removal
        if ($request->remove_thumbnail) {
            $page->clearMediaCollection('thumbnail');
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $page->clearMediaCollection('thumbnail');
            $page->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }

        $message = 'Halaman berhasil diupdate.';
        
        // Handle different actions
        if ($request->action === 'update_and_continue') {
            return redirect()->route('admin.pages.edit', $page)
                ->with('success', $message);
        }

        return redirect()->route('admin.pages.index')
            ->with('success', $message);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dipindahkan ke trash.');
    }

    public function restore($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $page->restore();
        
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dipulihkan dari trash.');
    }

    public function forceDelete($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        
        // This will trigger the forceDeleted event in the model
        // which will clean up all media files
        $page->forceDelete();
        
        return redirect()->route('admin.pages.index', ['view' => 'trash'])
            ->with('success', 'Halaman berhasil dihapus permanen.');
    }

    public function emptyTrash()
    {
        // Check permission
        if (!auth()->user()->can('delete pages')) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $pages = Page::onlyTrashed()->get();
            
            if ($pages->count() === 0) {
                return redirect()->route('admin.pages.index', ['view' => 'trash'])
                    ->with('info', 'Trash sudah kosong.');
            }
            
            $count = $pages->count();
            
            foreach ($pages as $page) {
                $page->forceDelete();
            }
            
            return redirect()->route('admin.pages.index', ['view' => 'trash'])
                ->with('success', "Berhasil menghapus {$count} halaman dari trash secara permanen.");
        } catch (\Exception $e) {
            Log::error('Error emptying pages trash: ' . $e->getMessage());
            return redirect()->route('admin.pages.index', ['view' => 'trash'])
                ->with('error', 'Terjadi kesalahan saat mengosongkan trash.');
        }
    }
}