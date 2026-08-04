<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('album_galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            
            // ❌ YANG LAMA: $table->string('cover_url')->nullable();
            // ✅ YANG BENER (Ganti jadi ini):
            $table->string('cover')->nullable(); 
            
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_galeris');
    }
};