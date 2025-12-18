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
        // Update data dosen default dengan NIP jika belum ada
        DB::table('data_user')
            ->where('username', 'dosen@gmail.com')
            ->whereNull('nip')
            ->update([
                'nip' => 'NIP001',
                'updated_at' => now(),
            ]);

        // Update data mahasiswa default dengan NIM jika belum ada
        DB::table('data_user')
            ->where('username', 'mahasiswa@gmail.com')
            ->whereNull('nim')
            ->update([
                'nim' => 'NIM001',
                'semester' => '1',
                'jurusan' => 'Teknik Informatika',
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback karena ini hanya update data
    }
};
