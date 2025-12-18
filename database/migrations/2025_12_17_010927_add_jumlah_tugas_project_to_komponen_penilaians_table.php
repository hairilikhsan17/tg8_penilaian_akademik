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
        Schema::table('komponen_penilaians', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_tugas')->default(1)->after('tugas');
            $table->unsignedInteger('jumlah_project')->default(1)->after('project');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponen_penilaians', function (Blueprint $table) {
            $table->dropColumn(['jumlah_tugas', 'jumlah_project']);
        });
    }
};
