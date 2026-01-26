<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('items')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|max:255|unique:menus',
            'description' => 'nullable'
        ]);

        Menu::create($request->all());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dibuat.');
    }

    public function edit(Menu $menu)
    {
        $menu->load(['parentItems.children', 'parentItems.page', 'parentItems.post']);
        $pages = Page::published()->get();
        $posts = \App\Models\Post::published()->orderBy('title')->get();
        
        return view('admin.menus.edit', compact('menu', 'pages', 'posts'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|max:255|unique:menus,location,' . $menu->id,
            'description' => 'nullable'
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    public function addItem(Request $request, Menu $menu)
    {
        // Custom validation with better error handling
        $rules = [
            'title' => 'required|max:255',
            'type' => 'required|in:page,custom,category,post,blog',
            'target' => 'required|in:_self,_blank',
            'css_class' => 'nullable|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
        ];

        // Add conditional rules based on type
        if ($request->type === 'custom') {
            // Allow "/" for home page, relative paths starting with "/", or valid URLs
            $rules['url'] = [
                'required',
                function ($attribute, $value, $fail) {
                    // Allow "/" for home page
                    if ($value === '/') {
                        return;
                    }
                    
                    // Allow relative paths starting with "/"
                    if (str_starts_with($value, '/') && strlen($value) > 1) {
                        return;
                    }
                    
                    // Allow valid URLs
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        return;
                    }
                    
                    $fail('The ' . $attribute . ' field must be a valid URL, "/" for home page, or a path starting with "/".');
                }
            ];
        } elseif ($request->type === 'page') {
            $rules['page_id'] = 'required|exists:pages,id';
        } elseif ($request->type === 'post') {
            $rules['post_id'] = 'required|exists:posts,id';
        } elseif ($request->type === 'blog') {
            $rules['blog_type'] = 'required|in:blog_home,blog_category,blog_tag';
            if ($request->blog_type === 'blog_category') {
                $rules['blog_category'] = 'required';
            } elseif ($request->blog_type === 'blog_tag') {
                $rules['blog_tag'] = 'required';
            }
        }

        $request->validate($rules);

        $order = MenuItem::where('menu_id', $menu->id)
            ->where('parent_id', $request->parent_id)
            ->max('order') + 1;

        // Generate URL based on type
        $url = $request->url ?? '';
        if ($request->type === 'blog') {
            switch ($request->blog_type) {
                case 'blog_home':
                    $url = '/blog';
                    break;
                case 'blog_category':
                    $url = '/blog/category/' . $request->blog_category;
                    break;
                case 'blog_tag':
                    $url = '/blog/tag/' . $request->blog_tag;
                    break;
            }
        } elseif ($request->type === 'post') {
            $post = \App\Models\Post::find($request->post_id);
            if ($post) {
                $url = '/blog/' . $post->slug;
            }
        } elseif ($request->type === 'page') {
            $page = \App\Models\Page::find($request->page_id);
            if ($page) {
                // Generate frontend-compatible URL for pages
                $url = '/' . $page->slug;
            }
        }

        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => $request->title,
            'type' => $request->type,
            'url' => $url,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'post_id' => $request->type === 'post' ? $request->post_id : null,
            'parent_id' => $request->parent_id,
            'target' => $request->target,
            'css_class' => $request->css_class,
            'order' => $order
        ]);

        return redirect()->route('admin.menus.edit', $menu)
            ->with('success', 'Item menu berhasil ditambahkan.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:menu_items,id',
            'order.*.order' => 'required|integer'
        ]);

        foreach ($request->order as $item) {
            MenuItem::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Menu order updated successfully']);
    }

    public function deleteItem(MenuItem $item)
    {
        $menu = $item->menu;
        $item->delete();

        return redirect()->route('admin.menus.edit', $menu)
            ->with('success', 'Item menu berhasil dihapus.');
    }
}