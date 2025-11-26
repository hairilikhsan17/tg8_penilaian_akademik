<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

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

// Auth Routes
Route::get('/login', [MenuController::class, 'login']);
Route::post('/login', [MenuController::class, 'loginPerform']);
Route::get('/register', [MenuController::class, 'register']);
Route::post('/register', [MenuController::class, 'registerPerform']);
Route::post('/logout', [MenuController::class, 'logout']);

// Dashboard Routes
Route::get('/dosen/dashboard', [MenuController::class, 'dosenDashboard']);
Route::get('/mahasiswa/dashboard', [MenuController::class, 'mahasiswaDashboard']);

// Dosen - Profil
Route::get('/dosen/profil', [MenuController::class, 'dosenProfil']);
Route::put('/dosen/profil', [MenuController::class, 'dosenProfilUpdate']);
Route::delete('/dosen/profil/foto', [MenuController::class, 'dosenProfilUpdate']);

// Dosen - Kelola Mahasiswa
Route::get('/dosen/mahasiswas', [MenuController::class, 'mahasiswaIndex']);
Route::get('/dosen/mahasiswas/create', [MenuController::class, 'mahasiswaCreate']);
Route::post('/dosen/mahasiswas', [MenuController::class, 'mahasiswaStore']);
Route::get('/dosen/mahasiswas/{id}/edit', [MenuController::class, 'mahasiswaEdit']);
Route::put('/dosen/mahasiswas/{id}', [MenuController::class, 'mahasiswaUpdate']);
Route::delete('/dosen/mahasiswas/{id}', [MenuController::class, 'mahasiswaDestroy']);
Route::get('/dosen/mahasiswas/{id}/password', [MenuController::class, 'mahasiswaPassword']);
Route::post('/dosen/mahasiswas/{id}/password', [MenuController::class, 'mahasiswaPasswordUpdate']);

// Dosen - Kelola Mata Kuliah
Route::get('/dosen/matakuliahs', [MenuController::class, 'matakuliahIndex']);
Route::get('/dosen/matakuliahs/create', [MenuController::class, 'matakuliahCreate']);
Route::post('/dosen/matakuliahs', [MenuController::class, 'matakuliahStore']);
Route::get('/dosen/matakuliahs/{id}/edit', [MenuController::class, 'matakuliahEdit']);
Route::put('/dosen/matakuliahs/{id}', [MenuController::class, 'matakuliahUpdate']);
Route::delete('/dosen/matakuliahs/{id}', [MenuController::class, 'matakuliahDestroy']);

// Dosen - Komponen Penilaian
Route::get('/dosen/komponen-penilaian', [MenuController::class, 'komponenIndex']);
Route::get('/dosen/komponen-penilaian/{id}/edit', [MenuController::class, 'komponenEdit']);
Route::get('/dosen/komponen-penilaian/{id}/atur', [MenuController::class, 'komponenAtur']);
Route::get('/dosen/matakuliahs/{id}/komponen', [MenuController::class, 'komponenCreate']);
Route::post('/dosen/komponen-penilaian', [MenuController::class, 'komponenStore']);
Route::put('/dosen/komponen-penilaian/{id}', [MenuController::class, 'komponenUpdate']);

// Dosen - Input Nilai
Route::get('/dosen/nilai-mahasiswa', [MenuController::class, 'nilaiList']);
Route::get('/dosen/matakuliahs/{id}/nilai', [MenuController::class, 'nilaiIndex']);
Route::post('/dosen/matakuliahs/{id}/nilai', [MenuController::class, 'nilaiStore']);
Route::post('/dosen/nilai-mahasiswa', [MenuController::class, 'nilaiStore']);

// Dosen - Laporan
Route::get('/dosen/laporan-nilai', [MenuController::class, 'laporanIndex']);
Route::get('/dosen/laporan-nilai/pdf', [MenuController::class, 'laporanPdf']);

// Mahasiswa - Profil
Route::get('/mahasiswa/profil', [MenuController::class, 'mahasiswaProfil']);
Route::put('/mahasiswa/profil', [MenuController::class, 'mahasiswaProfilUpdate']);
Route::delete('/mahasiswa/profil/foto', [MenuController::class, 'mahasiswaProfilUpdate']);

// Mahasiswa - Nilai & KHS
Route::get('/mahasiswa/nilai', [MenuController::class, 'mahasiswaNilai']);
Route::get('/mahasiswa/khs', [MenuController::class, 'mahasiswaKhs']);
Route::get('/mahasiswa/cetak-khs', [MenuController::class, 'mahasiswaCetakKhs']);
