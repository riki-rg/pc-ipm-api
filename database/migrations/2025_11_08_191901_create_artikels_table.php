<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique(); // Wajib unik buat link
            $table->text('isi_konten'); // Pake text buat artikel panjang
            $table->string('gambar_header')->nullable();
            $table->string('status')->default('draft');
            $table->dateTime('tanggal_publish')->nullable();
            
            // Relasi ke User (Penulis)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};