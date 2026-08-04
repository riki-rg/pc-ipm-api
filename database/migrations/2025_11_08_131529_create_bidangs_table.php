<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index();
            $table->string('icon', 10)->nullable();
            $table->string('deskripsi_singkat', 255)->nullable();
            $table->text('deskripsi_lengkap')->nullable();
            $table->string('gambar_bidang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
