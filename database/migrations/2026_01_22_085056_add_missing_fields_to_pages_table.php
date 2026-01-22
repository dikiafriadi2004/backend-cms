<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('status');
            $table->boolean('show_in_menu')->default(true)->after('sort_order');
            $table->boolean('is_homepage')->default(false)->after('show_in_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'show_in_menu', 'is_homepage']);
        });
    }
};