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
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('role');
            $table->string('nip')->nullable()->after('nim');
            $table->string('semester')->nullable()->after('nip');
            $table->string('jurusan')->nullable()->after('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nip', 'semester', 'jurusan']);
        });
    }
};

