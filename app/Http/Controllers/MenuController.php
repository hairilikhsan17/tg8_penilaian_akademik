<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Auth
    public function login()
    {
        return view('auth.login');
    }

    public function loginPerform(Request $request)
    {
        // Ambil role dari session yang disimpan saat registrasi
        $role = session('selected_role', 'dosen'); // Default dosen jika tidak ada
        
        // Hapus session setelah digunakan
        session()->forget('selected_role');
        
        if ($role === 'mahasiswa') {
            return redirect('/mahasiswa/dashboard');
        } else {
            return redirect('/dosen/dashboard');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPerform(Request $request)
    {
        // Simpan role yang dipilih ke session
        $role = $request->input('role');
        
        if ($role) {
            session(['selected_role' => $role]);
            return redirect('/login');
        }
        
        return redirect('/register');
    }

    public function logout()
    {
        // Hapus semua session termasuk selected_role
        session()->flush();
        return redirect('/login');
    }

    // Dashboard Dosen
    public function dosenDashboard()
    {
        return view('dosen.dashboard');
    }

    public function dosenProfil()
    {
        return view('dosen.profil');
    }

    public function dosenProfilUpdate()
    {
        // Hanya tampilan - redirect kembali
        return redirect('/dosen/profil');
    }

    // Dashboard Mahasiswa
    public function mahasiswaDashboard()
    {
        return view('mahasiswa.dashboard');
    }

    public function mahasiswaProfil()
    {
        return view('mahasiswa.profil');
    }

    public function mahasiswaProfilUpdate()
    {
        // Hanya tampilan - redirect kembali
        return redirect('/mahasiswa/profil');
    }

    // Dosen - Kelola Mahasiswa
    public function mahasiswaIndex()
    {
        return view('dosen.mahasiswas.index');
    }

    public function mahasiswaCreate()
    {
        return view('dosen.mahasiswas.create');
    }

    public function mahasiswaStore()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/mahasiswas');
    }

    public function mahasiswaEdit()
    {
        return view('dosen.mahasiswas.edit');
    }

    public function mahasiswaUpdate()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/mahasiswas');
    }

    public function mahasiswaDestroy()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/mahasiswas');
    }

    public function mahasiswaPassword()
    {
        return view('dosen.mahasiswas.password');
    }

    public function mahasiswaPasswordUpdate()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/mahasiswas');
    }

    // Dosen - Kelola Mata Kuliah
    public function matakuliahIndex()
    {
        return view('dosen.matakuliahs.index');
    }

    public function matakuliahCreate()
    {
        return view('dosen.matakuliahs.create');
    }

    public function matakuliahStore()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/matakuliahs');
    }

    public function matakuliahEdit()
    {
        return view('dosen.matakuliahs.edit');
    }

    public function matakuliahUpdate()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/matakuliahs');
    }

    public function matakuliahDestroy()
    {
        // Hanya tampilan - redirect kembali ke index
        return redirect('/dosen/matakuliahs');
    }

    // Dosen - Komponen Penilaian
    public function komponenIndex()
    {
        return view('dosen.komponen-penilaian.index');
    }

    public function komponenEdit()
    {
        return view('dosen.komponen-penilaian.edit');
    }

    public function komponenAtur()
    {
        return view('dosen.komponen-penilaian.atur');
    }

    public function komponenCreate()
    {
        return view('dosen.matakuliahs.komponen');
    }

    public function komponenStore()
    {
        // Hanya tampilan - redirect kembali ke komponen index
        return redirect('/dosen/komponen-penilaian');
    }

    public function komponenUpdate()
    {
        // Hanya tampilan - redirect kembali ke komponen index
        return redirect('/dosen/komponen-penilaian');
    }

    // Dosen - Input Nilai
    public function nilaiList()
    {
        return view('dosen.nilai-mahasiswa.index');
    }

    public function nilaiIndex()
    {
        return view('dosen.nilai_mahasiswas.index');
    }

    public function nilaiStore()
    {
        // Hanya tampilan - redirect kembali ke list nilai
        return redirect('/dosen/nilai-mahasiswa');
    }

    // Dosen - Laporan
    public function laporanIndex()
    {
        return view('dosen.laporan.index');
    }

    public function laporanPdf()
    {
        return view('dosen.laporan.pdf');
    }

    // Mahasiswa - Nilai Akademik
    public function mahasiswaNilai()
    {
        return view('mahasiswa.nilai-akademik');
    }

    // Mahasiswa - KHS
    public function mahasiswaKhs()
    {
        return view('mahasiswa.khs-transkrip');
    }

    public function mahasiswaCetakKhs()
    {
        return view('mahasiswa.cetak-khs');
    }
}

