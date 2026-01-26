<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class SimplePostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();
        $tags = Tag::all();

        if (!$user || $categories->isEmpty() || $tags->isEmpty()) {
            $this->command->error('Please run CategoryTagSeeder first and ensure users exist');
            return;
        }

        $posts = [
            [
                'title' => 'The Future of Web Development: Trends to Watch in 2024',
                'excerpt' => 'Explore the latest trends shaping the future of web development, from AI integration to progressive web apps.',
                'category' => 'Technology',
                'tags' => ['Web Development', 'Programming', 'Innovation'],
                'featured' => true,
            ],
            [
                'title' => 'Building Scalable Mobile Applications: Best Practices',
                'excerpt' => 'Learn the essential practices for developing mobile applications that can scale with your growing user base.',
                'category' => 'Technology',
                'tags' => ['Mobile Apps', 'Programming', 'Design'],
                'featured' => false,
            ],
            [
                'title' => 'Digital Marketing Strategies for Small Businesses',
                'excerpt' => 'Discover effective digital marketing strategies that small businesses can implement on a budget.',
                'category' => 'Business',
                'tags' => ['Digital Marketing', 'Startup', 'Innovation'],
                'featured' => true,
            ],
            [
                'title' => 'The Rise of Artificial Intelligence in Everyday Life',
                'excerpt' => 'How AI is transforming our daily routines and what it means for the future.',
                'category' => 'Technology',
                'tags' => ['AI & Machine Learning', 'Innovation', 'Programming'],
                'featured' => false,
            ],
            [
                'title' => 'Healthy Work-Life Balance in the Digital Age',
                'excerpt' => 'Tips and strategies for maintaining a healthy work-life balance while working in the digital era.',
                'category' => 'Lifestyle',
                'tags' => ['Innovation', 'Design'],
                'featured' => false,
            ],
        ];

        // Add 10 more posts to reach 15
        for ($i = 6; $i <= 15; $i++) {
            $posts[] = [
                'title' => "Sample Blog Post #{$i}: Technology and Innovation",
                'excerpt' => "This is a sample excerpt for blog post number {$i}. It provides a brief overview of the content.",
                'category' => $categories->random()->name,
                'tags' => $tags->random(rand(2, 4))->pluck('name')->toArray(),
                'featured' => rand(0, 1) == 1,
            ];
        }

        foreach ($posts as $postData) {
            $category = $categories->where('name', $postData['category'])->first();
            
            $content = $this->generateContent($postData['title'], $postData['excerpt']);
            
            $post = Post::create([
                'title' => $postData['title'],
                'slug' => \Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $content,
                'status' => 'published',
                'featured' => $postData['featured'],
                'user_id' => $user->id,
                'category_id' => $category->id,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 5)),
            ]);

            // Attach tags
            $postTags = $tags->whereIn('name', $postData['tags']);
            $post->tags()->attach($postTags->pluck('id'));
            
            $this->command->info("✅ Created: {$postData['title']}");
        }
        
        $this->command->info("🎉 Successfully created 15 dummy posts!");
    }

    private function generateContent($title, $excerpt)
    {
        return "<p>{$excerpt}</p>

<h2>Introduction</h2>
<p>In today's rapidly evolving digital landscape, understanding the nuances of this topic has become more important than ever. This comprehensive guide will walk you through the key concepts, best practices, and future implications.</p>

<h2>Key Concepts</h2>
<p>To fully grasp this subject, it's essential to understand the fundamental principles that drive success in this area. These concepts form the foundation upon which all advanced strategies are built.</p>

<h2>Best Practices</h2>
<p>Implementation is where theory meets reality. Here are the proven strategies that industry leaders use to achieve outstanding results:</p>
<ul>
<li>Focus on user-centered design principles</li>
<li>Implement data-driven decision making</li>
<li>Maintain consistent quality standards</li>
<li>Stay updated with industry trends</li>
<li>Foster continuous learning and improvement</li>
</ul>

<h2>Common Challenges</h2>
<p>Every field has its obstacles. Understanding these challenges and how to overcome them is crucial for long-term success. The most successful professionals are those who can navigate these difficulties effectively.</p>

<h2>Future Outlook</h2>
<p>As we look toward the future, several trends are emerging that will shape how we approach this field. Staying ahead of these trends will be key to maintaining competitive advantage.</p>

<h2>Conclusion</h2>
<p>Success in this area requires a combination of technical knowledge, practical experience, and strategic thinking. By following the guidelines outlined in this article, you'll be well-positioned to achieve your goals and make a meaningful impact.</p>";
    }
}