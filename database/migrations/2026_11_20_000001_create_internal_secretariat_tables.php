<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_kepengurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('mulai');
            $table->date('selesai');
            $table->timestamps();
        });

        Schema::create('arsip_rapat', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->default('Rapat Koordinasi');
            $table->dateTime('waktu');
            $table->string('lokasi')->nullable();
            $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->nullOnDelete();
            $table->text('peserta')->nullable();
            $table->longText('ringkasan_keputusan')->nullable();
            $table->string('gdrive_url', 2048)->nullable();
            $table->string('lokasi_fisik')->nullable();
            $table->timestamps();
        });

        Schema::create('program_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_kepengurusan')->restrictOnDelete();
            $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->nullOnDelete();
            $table->string('nama');
            $table->date('mulai');
            $table->date('selesai')->nullable();
            $table->string('status')->default('Rencana');
            $table->text('catatan')->nullable();
            $table->string('gdrive_url', 2048)->nullable();
            $table->string('lokasi_fisik')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerja');
        Schema::dropIfExists('arsip_rapat');
        Schema::dropIfExists('periode_kepengurusan');
    }
};
