<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Page;

class FixImageUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:fix-image-urls {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix relative image URLs in post and page content to use full URLs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $appUrl = config('app.url');
        
        $this->info('🔧 Fixing image URLs in content...');
        $this->info("App URL: {$appUrl}");
        
        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }
        
        // Fix Posts
        $this->info("\n📝 Processing Posts...");
        $posts = Post::all();
        $postsFixed = 0;
        
        foreach ($posts as $post) {
            $oldContent = $post->content;
            $newContent = $this->fixImageUrls($oldContent, $appUrl);
            
            if ($oldContent !== $newContent) {
                if (!$dryRun) {
                    $post->update(['content' => $newContent]);
                }
                $postsFixed++;
                $this->line("  ✅ " . ($dryRun ? 'Would fix' : 'Fixed') . " post: {$post->title}");
                
                if ($this->output->isVerbose()) {
                    $this->line("    Old: " . substr($oldContent, 0, 100) . "...");
                    $this->line("    New: " . substr($newContent, 0, 100) . "...");
                }
            }
        }
        
        // Fix Pages
        $this->info("\n📄 Processing Pages...");
        $pages = Page::all();
        $pagesFixed = 0;
        
        foreach ($pages as $page) {
            $oldContent = $page->content;
            $newContent = $this->fixImageUrls($oldContent, $appUrl);
            
            if ($oldContent !== $newContent) {
                if (!$dryRun) {
                    $page->update(['content' => $newContent]);
                }
                $pagesFixed++;
                $this->line("  ✅ " . ($dryRun ? 'Would fix' : 'Fixed') . " page: {$page->title}");
                
                if ($this->output->isVerbose()) {
                    $this->line("    Old: " . substr($oldContent, 0, 100) . "...");
                    $this->line("    New: " . substr($newContent, 0, 100) . "...");
                }
            }
        }
        
        // Summary
        $this->info("\n📊 Summary:");
        $this->line("- Posts checked: " . $posts->count());
        $this->line("- Posts " . ($dryRun ? 'to fix' : 'fixed') . ": {$postsFixed}");
        $this->line("- Pages checked: " . $pages->count());
        $this->line("- Pages " . ($dryRun ? 'to fix' : 'fixed') . ": {$pagesFixed}");
        
        if ($dryRun && ($postsFixed > 0 || $pagesFixed > 0)) {
            $this->info("\n💡 Run without --dry-run to apply changes:");
            $this->line("   php artisan cms:fix-image-urls");
        }
        
        $this->info("\n🎉 Image URL fixing completed!");
        
        return Command::SUCCESS;
    }

    /**
     * Fix various image URL patterns in content
     */
    private function fixImageUrls($content, $appUrl)
    {
        // Pattern 1: Fix relative paths like /storage/images/
        if (strpos($content, '/storage/images/') !== false && strpos($content, $appUrl . '/storage/images/') === false) {
            $content = str_replace('/storage/images/', $appUrl . '/storage/images/', $content);
        }
        
        // Pattern 2: Fix malformed relative paths like ../../../storage/images/
        $content = preg_replace('/\.\.\/\.\.\/\.\.\/storage\/images\//', $appUrl . '/storage/images/', $content);
        
        // Pattern 3: Fix other relative storage paths
        $content = preg_replace('/\.\.\/storage\/images\//', $appUrl . '/storage/images/', $content);
        
        // Pattern 4: Fix paths that start with storage/ (without leading slash)
        $content = preg_replace('/(?<!\/|:)storage\/images\//', $appUrl . '/storage/images/', $content);
        
        // Pattern 5: Fix any remaining malformed paths
        $content = preg_replace('/src="(?!http|https|\/\/|data:)([^"]*storage\/images\/[^"]*)"/', 'src="' . $appUrl . '/storage/images/$1"', $content);
        
        return $content;
    }
}
