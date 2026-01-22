<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('code');
            $table->string('position');
            $table->enum('type', ['adsense', 'manual', 'adsera'])->default('manual');
            $table->boolean('status')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['position', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_spaces');
    }
};