<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayaran_kas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengurus_id')
                ->constrained('penguruses')
                ->onDelete('cascade');

            $table->integer('bulan');
            $table->integer('tahun');

            $table->integer('nominal')->default(10000);

            $table->enum('status', ['belum', 'sudah'])
                ->default('belum');

            $table->enum('metode_bayar', ['transfer', 'cash', 'kajian_internal'])
                ->nullable();

            $table->foreignId('user_id_pencatat')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_kas');
    }
};
