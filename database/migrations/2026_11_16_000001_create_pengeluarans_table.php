<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kategori', 100); // operasional, konsumsi, transport, perlengkapan, dll
            $table->string('keterangan');
            $table->unsignedBigInteger('nominal');
            $table->string('bukti_foto')->nullable(); // path di storage
            $table->foreignId('user_id_pencatat')->constrained('users');
            $table->timestamps();

            $table->index(['tanggal', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
