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
        // Cek apakah kolom role sudah ada
        if (!Schema::hasColumn('data_user', 'role')) {
            Schema::table('data_user', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            if (Schema::hasColumn('data_user', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
