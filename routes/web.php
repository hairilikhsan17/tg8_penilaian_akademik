<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\KomponenPenilaianController;
use App\Http\Controllers\InputNilaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes - LoginController
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/logout', [LoginController::class, 'logout']);

// Register Routes - RegisterController
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

// Routes dengan Middleware Group untuk Dosen
Route::middleware(['dosen'])->group(function () {
// Dashboard Routes - Role based (mengarahkan ke view yang sudah dibuat)
Route::get('/dashboard/dosen', [MenuController::class, 'dosenDashboard']);

// Dashboard Routes - MenuController (untuk kompatibilitas)
Route::get('/dosen/dashboard', [MenuController::class, 'dosenDashboard']);

// Dosen - Profil
    Route::get('/dosen/profil', [EditProfileController::class, 'dosenProfil']);
    Route::put('/dosen/profil', [EditProfileController::class, 'dosenProfilUpdate']);
    Route::delete('/dosen/profil/foto', [EditProfileController::class, 'dosenProfilFotoDelete']);

// Dosen - Kelola Mahasiswa (DataController)
Route::get('/dosen/mahasiswas', [DataController::class, 'index']);
Route::get('/dosen/mahasiswas/create', [DataController::class, 'create']);
Route::post('/dosen/mahasiswas', [DataController::class, 'store']);
Route::get('/dosen/mahasiswas/{id}/edit', [DataController::class, 'edit']);
Route::put('/dosen/mahasiswas/{id}', [DataController::class, 'update']);
Route::delete('/dosen/mahasiswas/{id}', [DataController::class, 'destroy']);
Route::get('/dosen/mahasiswas/{id}/password', [DataController::class, 'password']);
Route::post('/dosen/mahasiswas/{id}/password', [DataController::class, 'passwordUpdate']);

// Dosen - Kelola Mata Kuliah (MatakuliahController)
Route::get('/dosen/matakuliahs', [MatakuliahController::class, 'index']);
Route::get('/dosen/matakuliahs/create', [MatakuliahController::class, 'create']);
Route::post('/dosen/matakuliahs', [MatakuliahController::class, 'store']);
Route::get('/dosen/matakuliahs/{id}/edit', [MatakuliahController::class, 'edit']);
Route::put('/dosen/matakuliahs/{id}', [MatakuliahController::class, 'update']);
Route::delete('/dosen/matakuliahs/{id}', [MatakuliahController::class, 'destroy']);

// Dosen - Komponen Penilaian (KomponenPenilaianController)
Route::get('/dosen/komponen-penilaian', [KomponenPenilaianController::class, 'index']);
Route::get('/dosen/matakuliahs/{id}/komponen', [KomponenPenilaianController::class, 'create']);
Route::post('/dosen/komponen-penilaian', [KomponenPenilaianController::class, 'store']);
Route::get('/dosen/komponen-penilaian/{id}/edit', [KomponenPenilaianController::class, 'edit']);
Route::put('/dosen/komponen-penilaian/{id}', [KomponenPenilaianController::class, 'update']);

// Dosen - Input Nilai (InputNilaiController)
Route::get('/dosen/nilai-mahasiswa', [InputNilaiController::class, 'index']);
Route::get('/dosen/matakuliahs/{id}/nilai', [InputNilaiController::class, 'create']);
Route::post('/dosen/matakuliahs/{id}/nilai', [InputNilaiController::class, 'store']);

// Dosen - Laporan
Route::get('/dosen/laporan-nilai', [MenuController::class, 'laporanIndex']);
Route::get('/dosen/laporan-nilai/pdf', [MenuController::class, 'laporanPdf']);
});

// Routes dengan Middleware Group untuk Mahasiswa
Route::middleware(['mahasiswa'])->group(function () {
    // Dashboard Routes - Role based (mengarahkan ke view yang sudah dibuat)
    Route::get('/dashboard/mahasiswa', [MenuController::class, 'mahasiswaDashboard']);
    
    // Dashboard Routes - MenuController (untuk kompatibilitas)
    Route::get('/mahasiswa/dashboard', [MenuController::class, 'mahasiswaDashboard']);

// Mahasiswa - Profil
    Route::get('/mahasiswa/profil', [EditProfileController::class, 'mahasiswaProfil']);
    Route::put('/mahasiswa/profil', [EditProfileController::class, 'mahasiswaProfilUpdate']);
    Route::delete('/mahasiswa/profil/foto', [EditProfileController::class, 'mahasiswaProfilFotoDelete']);

// Mahasiswa - Nilai & KHS
Route::get('/mahasiswa/nilai', [MenuController::class, 'mahasiswaNilai']);
Route::get('/mahasiswa/khs', [MenuController::class, 'mahasiswaKhs']);
Route::get('/mahasiswa/cetak-khs', [MenuController::class, 'mahasiswaCetakKhs']);
});
