<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please run user seeder first.');
            return;
        }

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'excerpt' => 'Learn more about our company, mission, and values.',
                'content' => '<h2>About Our Company</h2><p>We are a leading company in our industry, committed to providing excellent service and innovative solutions to our clients.</p><h3>Our Mission</h3><p>To deliver exceptional value through innovative products and outstanding customer service.</p><h3>Our Values</h3><ul><li>Integrity</li><li>Innovation</li><li>Excellence</li><li>Customer Focus</li></ul>',
                'template' => 'default',
                'status' => 'published',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'excerpt' => 'Get in touch with us for any inquiries or support.',
                'content' => '<h2>Contact Information</h2><p>We would love to hear from you. Please feel free to reach out to us using the information below.</p><h3>Office Address</h3><p>123 Business Street<br>City, State 12345</p><h3>Phone</h3><p>+1 (555) 123-4567</p><h3>Email</h3><p>info@company.com</p>',
                'template' => 'contact',
                'status' => 'published',
            ],
            [
                'title' => 'Our Services',
                'slug' => 'services',
                'excerpt' => 'Discover the comprehensive range of services we offer.',
                'content' => '<h2>Our Services</h2><p>We offer a wide range of professional services to meet your business needs.</p><h3>Web Development</h3><p>Custom web applications and websites built with modern technologies.</p><h3>Mobile Apps</h3><p>Native and cross-platform mobile applications for iOS and Android.</p><h3>Digital Marketing</h3><p>Comprehensive digital marketing strategies to grow your online presence.</p>',
                'template' => 'services',
                'status' => 'published',
            ],
            [
                'title' => 'Blog',
                'slug' => 'blog',
                'excerpt' => 'Read our latest articles and insights.',
                'content' => '<h2>Welcome to Our Blog</h2><p>Stay updated with the latest news, insights, and trends in our industry.</p>',
                'template' => 'blog',
                'status' => 'published',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'excerpt' => 'Our commitment to protecting your privacy.',
                'content' => '<h2>Privacy Policy</h2><p>This privacy policy explains how we collect, use, and protect your personal information.</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you create an account or contact us.</p><h3>How We Use Your Information</h3><p>We use the information we collect to provide, maintain, and improve our services.</p>',
                'template' => 'privacy',
                'status' => 'published',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title' => $pageData['title'],
                    'excerpt' => $pageData['excerpt'],
                    'content' => $pageData['content'],
                    'template' => $pageData['template'],
                    'status' => $pageData['status'],
                    'user_id' => $user->id,
                    'meta_title' => $pageData['title'],
                    'meta_description' => $pageData['excerpt'],
                    'show_in_menu' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            
            $this->command->info("✅ Created page: {$pageData['title']}");
        }
        
        $this->command->info("🎉 Successfully created " . count($pages) . " pages!");
    }
}