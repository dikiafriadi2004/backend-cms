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
            $table->string('title')->nullable(); // Judul iklan
            $table->text('description')->nullable(); // Deskripsi iklan
            $table->string('image_url')->nullable(); // URL gambar banner
            $table->string('link_url')->nullable(); // URL tujuan iklan
            $table->string('position'); // Posisi iklan (header, sidebar, footer, content, etc)
            $table->enum('type', ['banner', 'text_link'])->default('banner'); // Tipe iklan
            $table->integer('width')->nullable(); // Lebar banner (px)
            $table->integer('height')->nullable(); // Tinggi banner (px)
            $table->string('alt_text')->nullable(); // Alt text untuk SEO
            $table->boolean('open_new_tab')->default(true); // Buka di tab baru
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->boolean('status')->default(true); // Status aktif/nonaktif
            $table->timestamp('start_date')->nullable(); // Tanggal mulai
            $table->timestamp('end_date')->nullable(); // Tanggal berakhir
            $table->integer('click_count')->default(0); // Jumlah klik
            $table->integer('view_count')->default(0); // Jumlah tampil
            $table->timestamps();

            $table->index(['position', 'status', 'sort_order']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_spaces');
    }
};