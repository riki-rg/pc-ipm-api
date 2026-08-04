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
        Schema::table('kajians', function (Blueprint $table) {
            // Defaultnya 'artikel' biar data lama gak error
            $table->enum('jenis', ['artikel', 'poster'])->default('artikel')->after('slug');

            // Kolom deskripsi kita bikin NULLABLE (boleh kosong) kalo dia pilih Poster
            $table->text('deskripsi')->nullable()->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->dropColumn('jenis');
            $table->text('deskripsi')->nullable(false)->change();
        });
    }
};
