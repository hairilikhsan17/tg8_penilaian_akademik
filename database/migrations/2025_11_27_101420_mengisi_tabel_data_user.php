<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengisi data user default jika tabel masih kosong
        if (DB::table('data_user')->count() == 0) {
            // Cek apakah kolom nim, nip, semester, jurusan sudah ada
            $hasNimNip = Schema::hasColumn('data_user', 'nim') && Schema::hasColumn('data_user', 'nip');
            $hasSemesterJurusan = Schema::hasColumn('data_user', 'semester') && Schema::hasColumn('data_user', 'jurusan');
            
            // Data dasar untuk dosen
            $dosenData = [
                'nama_user' => 'Dosen',
                'username' => 'dosen@gmail.com',
                'password' => Hash::make('dosen123'),
                'role' => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Tambahkan kolom tambahan jika ada
            if ($hasNimNip) {
                $dosenData['nip'] = 'NIP001';
                $dosenData['nim'] = null;
            }
            if ($hasSemesterJurusan) {
                $dosenData['semester'] = null;
                $dosenData['jurusan'] = null;
            }
            
            // Data dasar untuk mahasiswa
            $mahasiswaData = [
                'nama_user' => 'Mahasiswa',
                'username' => 'mahasiswa@gmail.com',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Tambahkan kolom tambahan jika ada
            if ($hasNimNip) {
                $mahasiswaData['nim'] = 'NIM001';
                $mahasiswaData['nip'] = null;
            }
            if ($hasSemesterJurusan) {
                $mahasiswaData['semester'] = '1';
                $mahasiswaData['jurusan'] = 'Teknik Informatika';
            }
            
            DB::table('data_user')->insert([$dosenData, $mahasiswaData]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus data default jika diperlukan
        DB::table('data_user')
            ->whereIn('username', ['dosen@gmail.com', 'mahasiswa@gmail.com'])
            ->delete();
    }
};
