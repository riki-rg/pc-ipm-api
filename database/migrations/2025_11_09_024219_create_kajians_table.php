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
        Schema::create('kajians', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Jangan isi_kajian, tapi Judul biar seragam
            $table->string('slug')->unique(); // WAJIB ADA
            $table->string('pemateri')->nullable(); 
            $table->string('lokasi')->nullable();
            $table->dateTime('waktu');
            $table->text('deskripsi'); // Isi konten kajian
            $table->string('gambar')->nullable(); // Gambar cover
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kajians');
    }
};
