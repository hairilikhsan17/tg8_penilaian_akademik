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
        // Cek apakah kolom password sudah ada
        if (!Schema::hasColumn('data_user', 'password')) {
            Schema::table('data_user', function (Blueprint $table) {
                $table->string('password')->after('username');
            });
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            if (Schema::hasColumn('data_user', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
    
};
