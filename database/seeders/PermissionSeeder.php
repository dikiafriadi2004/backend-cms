<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions with groups
        $permissions = [
            // Dashboard
            ['name' => 'view dashboard', 'group' => 'dashboard'],
            
            // Posts
            ['name' => 'view posts', 'group' => 'posts'],
            ['name' => 'create posts', 'group' => 'posts'],
            ['name' => 'edit posts', 'group' => 'posts'],
            ['name' => 'delete posts', 'group' => 'posts'],
            ['name' => 'publish posts', 'group' => 'posts'],
            
            // Categories
            ['name' => 'view categories', 'group' => 'categories'],
            ['name' => 'create categories', 'group' => 'categories'],
            ['name' => 'edit categories', 'group' => 'categories'],
            ['name' => 'delete categories', 'group' => 'categories'],
            
            // Tags
            ['name' => 'view tags', 'group' => 'tags'],
            ['name' => 'create tags', 'group' => 'tags'],
            ['name' => 'edit tags', 'group' => 'tags'],
            ['name' => 'delete tags', 'group' => 'tags'],
            
            // Pages
            ['name' => 'view pages', 'group' => 'pages'],
            ['name' => 'create pages', 'group' => 'pages'],
            ['name' => 'edit pages', 'group' => 'pages'],
            ['name' => 'delete pages', 'group' => 'pages'],
            
            // Menus
            ['name' => 'view menus', 'group' => 'menus'],
            ['name' => 'create menus', 'group' => 'menus'],
            ['name' => 'edit menus', 'group' => 'menus'],
            ['name' => 'delete menus', 'group' => 'menus'],
            
            // Users
            ['name' => 'view users', 'group' => 'users'],
            ['name' => 'create users', 'group' => 'users'],
            ['name' => 'edit users', 'group' => 'users'],
            ['name' => 'delete users', 'group' => 'users'],
            
            // Roles & Permissions
            ['name' => 'view roles', 'group' => 'roles'],
            ['name' => 'create roles', 'group' => 'roles'],
            ['name' => 'edit roles', 'group' => 'roles'],
            ['name' => 'delete roles', 'group' => 'roles'],
            
            // Settings
            ['name' => 'view settings', 'group' => 'settings'],
            ['name' => 'edit settings', 'group' => 'settings'],
            
            // Ads
            ['name' => 'view ads', 'group' => 'ads'],
            ['name' => 'create ads', 'group' => 'ads'],
            ['name' => 'edit ads', 'group' => 'ads'],
            ['name' => 'delete ads', 'group' => 'ads'],
            
            // File Manager
            ['name' => 'access filemanager', 'group' => 'filemanager'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $editor = Role::create(['name' => 'Editor']);
        $author = Role::create(['name' => 'Author']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'view dashboard',
            'view posts', 'create posts', 'edit posts', 'delete posts', 'publish posts',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view tags', 'create tags', 'edit tags', 'delete tags',
            'view pages', 'create pages', 'edit pages', 'delete pages',
            'view menus', 'create menus', 'edit menus', 'delete menus',
            'view users', 'create users', 'edit users',
            'view settings', 'edit settings',
            'view ads', 'create ads', 'edit ads', 'delete ads',
            'access filemanager'
        ]);

        $editor->givePermissionTo([
            'view dashboard',
            'view posts', 'create posts', 'edit posts', 'publish posts',
            'view categories', 'create categories', 'edit categories',
            'view tags', 'create tags', 'edit tags',
            'view pages', 'create pages', 'edit pages',
            'access filemanager'
        ]);

        $author->givePermissionTo([
            'view dashboard',
            'view posts', 'create posts', 'edit posts',
            'view categories',
            'view tags',
            'access filemanager'
        ]);
    }
}