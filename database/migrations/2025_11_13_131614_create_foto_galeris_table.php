<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foto_galeris', function (Blueprint $table) {
            $table->id();
            
            // ✅ INI YANG BENAR:
            $table->string('foto'); // <--- Ganti dari 'foto_url' jadi 'foto'
            
            $table->foreignId('album_galeri_id')->constrained('album_galeris')->cascadeOnDelete();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_galeris');
    }
};