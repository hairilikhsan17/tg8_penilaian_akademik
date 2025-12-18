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
        Schema::create('nilai_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('data_user')->onDelete('cascade');
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            $table->double('kehadiran')->default(0);
            $table->double('tugas')->default(0);
            $table->double('kuis')->default(0);
            $table->double('project')->default(0);
            $table->double('uts')->default(0);
            $table->double('uas')->default(0);
            $table->double('nilai_akhir')->default(0);
            $table->string('huruf_mutu')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['mahasiswa_id', 'matakuliah_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_mahasiswas');
    }
};
