<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('pengurus_id')->nullable()->unique()->after('id')->constrained('penguruses')->nullOnDelete();
            $table->boolean('must_change_password')->default(false)->after('password');
        });

        foreach (['kajians', 'kegiatans', 'album_galeris'] as $contentTable) {
            Schema::table($contentTable, function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (['kajians', 'kegiatans', 'album_galeris'] as $contentTable) {
            Schema::table($contentTable, function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['pengurus_id']);
            $table->dropConstrainedForeignId('pengurus_id');
            $table->dropColumn('must_change_password');
        });
    }
};
