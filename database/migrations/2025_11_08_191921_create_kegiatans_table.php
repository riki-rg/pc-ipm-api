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
        // 1. Tabel Utama
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Gua ganti 'nama_kegiatan' jadi 'judul' CUMA BIAR FRONTEND GAK ERROR.
            $table->string('slug')->unique();
            $table->string('lokasi')->nullable();
            $table->dateTime('waktu');
            $table->dateTime('waktu_selesai')->nullable(); // Gua balikin ini
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Pivot (Relasi ke Pengurus) - INI YANG KEMAREN GUA HAPUS, SKRG GUA BALIKIN
        Schema::create('kegiatan_pengurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pengurus_id')->constrained('penguruses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_pengurus');
        Schema::dropIfExists('kegiatans');
    }
};
