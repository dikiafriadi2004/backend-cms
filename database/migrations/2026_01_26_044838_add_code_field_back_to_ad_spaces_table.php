<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->longText('code')->nullable()->after('view_count');
        });
        
        // Update type enum to include all types
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->enum('type', ['manual_banner', 'manual_text', 'adsense', 'adsera'])->default('manual_banner')->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('type');
        });
        
        Schema::table('ad_spaces', function (Blueprint $table) {
            $table->enum('type', ['banner', 'text_link'])->default('banner')->after('position');
        });
    }
};