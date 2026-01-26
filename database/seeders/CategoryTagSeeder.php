<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;

class CategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'color' => '#3B82F6', 'description' => 'Latest technology trends and innovations'],
            ['name' => 'Business', 'slug' => 'business', 'color' => '#10B981', 'description' => 'Business strategies and entrepreneurship'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'color' => '#F59E0B', 'description' => 'Lifestyle tips and personal development'],
            ['name' => 'Health', 'slug' => 'health', 'color' => '#EF4444', 'description' => 'Health and wellness information'],
            ['name' => 'Education', 'slug' => 'education', 'color' => '#8B5CF6', 'description' => 'Educational content and learning resources'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Create tags
        $tags = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'color' => '#3B82F6'],
            ['name' => 'Mobile Apps', 'slug' => 'mobile-apps', 'color' => '#10B981'],
            ['name' => 'AI & Machine Learning', 'slug' => 'ai-machine-learning', 'color' => '#F59E0B'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing', 'color' => '#EF4444'],
            ['name' => 'Startup', 'slug' => 'startup', 'color' => '#8B5CF6'],
            ['name' => 'Innovation', 'slug' => 'innovation', 'color' => '#06B6D4'],
            ['name' => 'Programming', 'slug' => 'programming', 'color' => '#84CC16'],
            ['name' => 'Design', 'slug' => 'design', 'color' => '#F97316'],
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate(
                ['slug' => $tagData['slug']],
                $tagData
            );
        }
    }
}