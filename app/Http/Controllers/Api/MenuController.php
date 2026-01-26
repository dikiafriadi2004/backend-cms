<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')
                ->with([
                    'children' => function ($childQuery) {
                        $childQuery->with(['page', 'post'])->orderBy('order');
                    },
                    'page',
                    'post'
                ])
                ->orderBy('order');
        }])->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function show($location)
    {
        $menu = Menu::where('location', $location)
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with([
                        'children' => function ($childQuery) {
                            $childQuery->with(['page', 'post'])->orderBy('order');
                        },
                        'page',
                        'post'
                    ])
                    ->orderBy('order');
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

    public function navigation()
    {
        $menu = Menu::where('location', 'main')
            ->orWhere('location', 'main-navigation')
            ->orWhere('location', 'header')
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with([
                        'children' => function ($childQuery) {
                            $childQuery->with(['page', 'post'])->orderBy('order');
                        },
                        'page',
                        'post'
                    ])
                    ->orderBy('order');
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

    public function footer()
    {
        $menu = Menu::where('location', 'footer')
            ->orWhere('location', 'footer-menu')
            ->with(['items' => function ($query) {
                $query->whereNull('parent_id')
                    ->with([
                        'children' => function ($childQuery) {
                            $childQuery->with(['page', 'post'])->orderBy('order');
                        },
                        'page',
                        'post'
                    ])
                    ->orderBy('order');
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