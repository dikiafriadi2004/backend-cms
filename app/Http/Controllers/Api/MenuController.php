<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index()
    {
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')
                ->with(['children' => function ($childQuery) {
                    $childQuery->orderBy('sort_order');
                }])
                ->orderBy('sort_order');
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    /**
     * Display the specified menu.
     */
    public function show($slug)
    {
        $menu = Menu::where('slug', $slug)
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['children' => function ($childQuery) {
                        $childQuery->orderBy('sort_order');
                    }])
                    ->orderBy('sort_order');
            }])
            ->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    /**
     * Get main navigation menu.
     */
    public function navigation()
    {
        $menu = Menu::where('slug', 'main-navigation')
            ->orWhere('name', 'Main Navigation')
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['children' => function ($childQuery) {
                        $childQuery->orderBy('sort_order');
                    }])
                    ->orderBy('sort_order');
            }])
            ->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Navigation menu not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    /**
     * Get footer menu.
     */
    public function footer()
    {
        $menu = Menu::where('slug', 'footer-menu')
            ->orWhere('name', 'Footer Menu')
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['children' => function ($childQuery) {
                        $childQuery->orderBy('sort_order');
                    }])
                    ->orderBy('sort_order');
            }])
            ->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Footer menu not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }
}