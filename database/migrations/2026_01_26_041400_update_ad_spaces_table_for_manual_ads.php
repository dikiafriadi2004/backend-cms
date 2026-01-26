<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ad_spaces', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['code']);
            
            // Add new columns for manual ads
            $table->string('title')->nullable()->after('name');
            $table->string('image_url')->nullable()->after('description');
            $table->string('link_url')->nullable()->after('image_url');
            $table->integer('width')->nullable()->after('position');
            $table->integer('height')->nullable()->after('width');
            $table->string('alt_text')->nullable()->after('height');
            $table->boolean('open_new_tab')->default(true)->after('alt_text');
            $table->integer('sort_order')->default(0)->after('open_new_tab');
            $table->timestamp('start_date')->nullable()->after('status');
            $table->timestamp('end_date')->nullable()->after('start_date');
            $table->integer('click_count')->default(0)->after('end_date');
            $table->integer('view_count')->default(0)->after('click_count');
            
            // Update type enum
            $table->dropColumn('type');
        });
        
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->enum('type', ['banner', 'text_link'])->default('banner')->after('position');
            
            // Update indexes
            $table->dropIndex(['position', 'status']);
            $table->index(['position', 'status', 'sort_order']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::table('ad_spaces', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'title', 'image_url', 'link_url', 'width', 'height', 
                'alt_text', 'open_new_tab', 'sort_order', 'start_date', 
                'end_date', 'click_count', 'view_count'
            ]);
            
            // Drop new indexes
            $table->dropIndex(['position', 'status', 'sort_order']);
            $table->dropIndex(['start_date', 'end_date']);
            
            // Restore old columns
            $table->longText('code')->after('name');
            
            // Restore old type enum
            $table->dropColumn('type');
        });
        
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->enum('type', ['adsense', 'manual', 'adsera'])->default('manual')->after('position');
            
            // Restore old index
            $table->index(['position', 'status']);
        });
    }
};