<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user or create one
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create 15 dummy posts
        $posts = [
            [
                'title' => 'The Future of Web Development: Trends to Watch in 2024',
                'excerpt' => 'Explore the latest trends shaping the future of web development, from AI integration to progressive web apps.',
                'content' => '<p>Web development is constantly evolving, and 2024 promises to bring exciting new trends that will reshape how we build and interact with websites. From artificial intelligence integration to the rise of progressive web apps, developers need to stay ahead of the curve.</p>

<h2>1. AI-Powered Development Tools</h2>
<p>Artificial intelligence is revolutionizing the development process. Tools like GitHub Copilot and ChatGPT are helping developers write code faster and more efficiently. These AI assistants can generate boilerplate code, suggest optimizations, and even help debug complex issues.</p>

<h2>2. Progressive Web Apps (PWAs)</h2>
<p>PWAs continue to gain traction as they offer native app-like experiences through web browsers. They provide offline functionality, push notifications, and fast loading times, making them an attractive alternative to traditional mobile apps.</p>

<h2>3. Serverless Architecture</h2>
<p>Serverless computing is becoming more mainstream, allowing developers to focus on code rather than infrastructure management. Platforms like Vercel, Netlify, and AWS Lambda are making it easier to deploy and scale applications.</p>

<h2>4. WebAssembly (WASM)</h2>
<p>WebAssembly is enabling high-performance applications in the browser by allowing languages like C++, Rust, and Go to run at near-native speeds on the web.</p>

<p>As we move forward, staying updated with these trends will be crucial for any web developer looking to remain competitive in the industry.</p>',
                'category' => 'Technology',
                'tags' => ['Web Development', 'Programming', 'Innovation'],
                'featured' => true,
            ],
            [
                'title' => 'Building Scalable Mobile Applications: Best Practices',
                'excerpt' => 'Learn the essential practices for developing mobile applications that can scale with your growing user base.',
                'content' => '<p>Creating mobile applications that can handle growth is one of the biggest challenges developers face today. With millions of apps in app stores, building something that stands out and scales effectively requires careful planning and execution.</p>

<h2>Architecture Considerations</h2>
<p>The foundation of any scalable mobile app lies in its architecture. Consider implementing clean architecture patterns like MVVM or MVP to ensure your codebase remains maintainable as it grows.</p>

<h2>Performance Optimization</h2>
<p>Performance is crucial for user retention. Implement lazy loading, optimize images, and use efficient data structures to ensure your app runs smoothly even with large datasets.</p>

<h2>Backend Integration</h2>
<p>Design your API endpoints with scalability in mind. Use pagination, implement caching strategies, and consider using GraphQL for more efficient data fetching.</p>

<h2>Testing Strategy</h2>
<p>Implement comprehensive testing including unit tests, integration tests, and UI tests. Automated testing becomes even more critical as your app scales.</p>

<p>Remember, scalability is not just about handling more users—it\'s about maintaining code quality, performance, and user experience as your application grows.</p>',
                'category' => 'Technology',
                'tags' => ['Mobile Apps', 'Programming', 'Design'],
                'featured' => false,
            ],
            [
                'title' => 'Digital Marketing Strategies for Small Businesses',
                'excerpt' => 'Discover effective digital marketing strategies that small businesses can implement on a budget.',
                'content' => '<p>Small businesses often struggle with digital marketing due to limited budgets and resources. However, with the right strategies, even small companies can compete effectively in the digital landscape.</p>

<h2>Content Marketing</h2>
<p>Creating valuable content is one of the most cost-effective marketing strategies. Start a blog, create helpful videos, or share industry insights on social media to attract and engage your target audience.</p>

<h2>Social Media Marketing</h2>
<p>Choose the right platforms where your audience spends time. Focus on 2-3 platforms rather than trying to be everywhere. Consistency is key to building a loyal following.</p>

<h2>Email Marketing</h2>
<p>Email marketing still offers one of the highest ROIs. Build an email list by offering valuable content or incentives, and nurture your subscribers with regular, valuable communications.</p>

<h2>Local SEO</h2>
<p>For local businesses, optimizing for local search is crucial. Claim your Google My Business listing, encourage customer reviews, and ensure your NAP (Name, Address, Phone) information is consistent across all platforms.</p>

<h2>Analytics and Measurement</h2>
<p>Use free tools like Google Analytics to track your marketing efforts. Understanding what works and what doesn\'t will help you optimize your strategies over time.</p>

<p>Success in digital marketing doesn\'t require a huge budget—it requires consistency, creativity, and a deep understanding of your target audience.</p>',
                'category' => 'Business',
                'tags' => ['Digital Marketing', 'Startup', 'Innovation'],
                'featured' => true,
            ],
            [
                'title' => 'The Rise of Artificial Intelligence in Everyday Life',
                'excerpt' => 'How AI is transforming our daily routines and what it means for the future.',
                'content' => '<p>Artificial Intelligence is no longer a concept confined to science fiction. It has seamlessly integrated into our daily lives, often in ways we don\'t even notice. From the moment we wake up to when we go to sleep, AI is working behind the scenes to make our lives easier and more efficient.</p>

<h2>Smart Homes and IoT</h2>
<p>Smart home devices powered by AI are becoming increasingly sophisticated. Voice assistants like Alexa and Google Home can control our lights, thermostats, and security systems, learning our preferences and adapting to our routines.</p>

<h2>Transportation Revolution</h2>
<p>AI is revolutionizing how we travel. From GPS navigation systems that predict traffic patterns to the development of autonomous vehicles, transportation is becoming smarter and more efficient.</p>

<h2>Healthcare Applications</h2>
<p>AI is making significant strides in healthcare, from diagnostic tools that can detect diseases earlier to personalized treatment plans based on individual patient data.</p>

<h2>Entertainment and Media</h2>
<p>Streaming services use AI algorithms to recommend content based on our viewing habits, while AI-generated music and art are pushing the boundaries of creativity.</p>

<h2>The Future Outlook</h2>
<p>As AI continues to evolve, we can expect even more integration into our daily lives. The key is ensuring this technology is developed and deployed responsibly, with consideration for privacy, ethics, and societal impact.</p>',
                'category' => 'Technology',
                'tags' => ['AI & Machine Learning', 'Innovation', 'Programming'],
                'featured' => false,
            ],
            [
                'title' => 'Healthy Work-Life Balance in the Digital Age',
                'excerpt' => 'Tips and strategies for maintaining a healthy work-life balance while working in the digital era.',
                'content' => '<p>The digital age has blurred the lines between work and personal life like never before. With smartphones, laptops, and constant connectivity, it\'s become increasingly challenging to disconnect from work and maintain a healthy balance.</p>

<h2>Setting Digital Boundaries</h2>
<p>Establish clear boundaries between work and personal time. This might mean turning off work notifications after certain hours or having a dedicated workspace that you can physically leave at the end of the day.</p>

<h2>The Importance of Unplugging</h2>
<p>Regular digital detoxes are essential for mental health. Schedule time each day to disconnect from all devices and engage in offline activities like reading, exercising, or spending time in nature.</p>

<h2>Mindful Technology Use</h2>
<p>Be intentional about how you use technology. Instead of mindlessly scrolling through social media, use apps and tools that add value to your life and support your goals.</p>

<h2>Physical Health Considerations</h2>
<p>Extended screen time can lead to eye strain, poor posture, and sedentary behavior. Take regular breaks, practice the 20-20-20 rule, and incorporate physical activity into your daily routine.</p>

<h2>Building Real Connections</h2>
<p>While digital communication is convenient, don\'t neglect face-to-face interactions. Make time for in-person meetings with friends and family to maintain meaningful relationships.</p>

<p>Remember, technology should enhance your life, not control it. Finding the right balance is key to long-term happiness and success.</p>',
                'category' => 'Lifestyle',
                'tags' => ['Innovation', 'Design'],
                'featured' => false,
            ],
        ];

        // Add more posts to reach 15
        $additionalPosts = [
            [
                'title' => 'Cybersecurity Best Practices for Remote Workers',
                'excerpt' => 'Essential security measures every remote worker should implement to protect sensitive data.',
                'category' => 'Technology',
                'tags' => ['Web Development', 'Programming'],
            ],
            [
                'title' => 'The Psychology of User Experience Design',
                'excerpt' => 'Understanding human psychology to create more intuitive and engaging user interfaces.',
                'category' => 'Technology',
                'tags' => ['Design', 'Innovation'],
            ],
            [
                'title' => 'Sustainable Business Practices in 2024',
                'excerpt' => 'How businesses are adapting to environmental challenges and consumer demands for sustainability.',
                'category' => 'Business',
                'tags' => ['Innovation', 'Startup'],
            ],
            [
                'title' => 'Mental Health in the Workplace: A Modern Approach',
                'excerpt' => 'Strategies for promoting mental wellness in professional environments.',
                'category' => 'Health',
                'tags' => ['Innovation'],
            ],
            [
                'title' => 'The Evolution of E-commerce: From Clicks to Conversions',
                'excerpt' => 'How online shopping experiences are evolving to meet changing consumer expectations.',
                'category' => 'Business',
                'tags' => ['Digital Marketing', 'Innovation'],
            ],
            [
                'title' => 'Cloud Computing: Transforming Business Operations',
                'excerpt' => 'The impact of cloud technology on modern business efficiency and scalability.',
                'category' => 'Technology',
                'tags' => ['Programming', 'Innovation'],
            ],
            [
                'title' => 'Data Privacy in the Age of Big Data',
                'excerpt' => 'Balancing data utilization with privacy protection in modern applications.',
                'category' => 'Technology',
                'tags' => ['Programming', 'Innovation'],
            ],
            [
                'title' => 'The Future of Education: Online Learning Trends',
                'excerpt' => 'How digital platforms are reshaping education and skill development.',
                'category' => 'Education',
                'tags' => ['Innovation', 'Digital Marketing'],
            ],
            [
                'title' => 'Blockchain Technology Beyond Cryptocurrency',
                'excerpt' => 'Exploring practical applications of blockchain in various industries.',
                'category' => 'Technology',
                'tags' => ['Programming', 'Innovation'],
            ],
            [
                'title' => 'Building Brand Loyalty Through Customer Experience',
                'excerpt' => 'Strategies for creating memorable customer experiences that drive loyalty.',
                'category' => 'Business',
                'tags' => ['Digital Marketing', 'Design'],
            ],
        ];

        // Generate content for additional posts
        foreach ($additionalPosts as &$post) {
            $post['content'] = $this->generateContent($post['title'], $post['excerpt']);
            $post['featured'] = rand(0, 1) == 1;
        }

        // Merge all posts
        $allPosts = array_merge($posts, $additionalPosts);

        // Create posts in database
        foreach ($allPosts as $index => $postData) {
            // Find category by name
            $categoryName = is_array($postData['category']) ? $postData['category']['name'] : $postData['category'];
            $category = Category::where('name', $categoryName)->first();
            
            if (!$category) {
                $this->command->error("Category '{$categoryName}' not found for post: {$postData['title']}");
                continue;
            }
            
            $post = Post::create([
                'title' => $postData['title'],
                'slug' => \Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'status' => 'published',
                'featured' => $postData['featured'],
                'user_id' => $user->id,
                'category_id' => $category->id,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 5)),
            ]);

            // Attach random tags
            $tagNames = $postData['tags'];
            $tagIds = Tag::whereIn('name', $tagNames)->pluck('id')->toArray();
            if (!empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
            
            $this->command->info("Created post: {$postData['title']}");
        }
    }

    private function generateContent($title, $excerpt)
    {
        return "<p>{$excerpt}</p>

<h2>Introduction</h2>
<p>In today's rapidly evolving digital landscape, understanding the nuances of {$title} has become more important than ever. This comprehensive guide will walk you through the key concepts, best practices, and future implications.</p>

<h2>Key Concepts</h2>
<p>To fully grasp this topic, it's essential to understand the fundamental principles that drive success in this area. These concepts form the foundation upon which all advanced strategies are built.</p>

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