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
        Schema::table('nilai_mahasiswas', function (Blueprint $table) {
            // Ubah tugas dan project menjadi JSON untuk menyimpan array nilai
            $table->json('tugas')->nullable()->change();
            $table->json('project')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_mahasiswas', function (Blueprint $table) {
            // Kembalikan ke double jika perlu rollback
            $table->double('tugas')->default(0)->change();
            $table->double('project')->default(0)->change();
        });
    }
};
