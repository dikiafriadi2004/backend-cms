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
        $menu->load(['parentItems.children', 'parentItems.page']);
        $pages = Page::published()->get();
        return view('admin.menus.edit', compact('menu', 'pages'));
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
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:page,custom,category,post',
            'url' => 'required_if:type,custom',
            'page_id' => 'required_if:type,page|exists:pages,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target' => 'required|in:_self,_blank',
            'css_class' => 'nullable|max:255'
        ]);

        $order = MenuItem::where('menu_id', $menu->id)
            ->where('parent_id', $request->parent_id)
            ->max('order') + 1;

        MenuItem::create([
            'menu_id' => $menu->id,
            'title' => $request->title,
            'type' => $request->type,
            'url' => $request->url,
            'page_id' => $request->page_id,
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