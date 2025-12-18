<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan nama_user setelah id
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('nama_user')->after('id');
        });
        
        // Pindahkan username ke bawah nama_user menggunakan ALTER TABLE
        // Ini lebih aman karena tidak menghapus data
        if (Schema::hasColumn('data_user', 'username')) {
            DB::statement('ALTER TABLE `data_user` MODIFY COLUMN `username` VARCHAR(255) AFTER `nama_user`');
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            $table->dropColumn(['nama_user', 'username']);
        });
    }
    
};
