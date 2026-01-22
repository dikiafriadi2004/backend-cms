<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Create main navigation menu
        $mainMenu = Menu::firstOrCreate(
            ['location' => 'main'],
            [
                'name' => 'Main Navigation',
                'location' => 'main',
                'description' => 'Menu navigasi utama untuk header website'
            ]
        );

        // Create footer menu
        $footerMenu = Menu::firstOrCreate(
            ['location' => 'footer'],
            [
                'name' => 'Footer Menu',
                'location' => 'footer',
                'description' => 'Menu untuk footer website'
            ]
        );

        // Add default menu items for main navigation (only if not exists)
        if ($mainMenu->items()->count() == 0) {
            MenuItem::create([
                'menu_id' => $mainMenu->id,
                'title' => 'Home',
                'url' => '/',
                'type' => 'custom',
                'order' => 1,
                'target' => '_self'
            ]);

            MenuItem::create([
                'menu_id' => $mainMenu->id,
                'title' => 'Blog',
                'url' => '/blog',
                'type' => 'custom',
                'order' => 2,
                'target' => '_self'
            ]);

            MenuItem::create([
                'menu_id' => $mainMenu->id,
                'title' => 'About',
                'url' => '/about',
                'type' => 'custom',
                'order' => 3,
                'target' => '_self'
            ]);

            MenuItem::create([
                'menu_id' => $mainMenu->id,
                'title' => 'Contact',
                'url' => '/contact',
                'type' => 'custom',
                'order' => 4,
                'target' => '_self'
            ]);
        }
    }
}