<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Auth
    public function login()
    {
        // Alur: Jika sudah login, jangan tampilkan form login lagi, redirect ke dashboard
        if (session('login')) {
            $role = session('role');
            if ($role === 'dosen') {
                return redirect('/dosen/dashboard');
            } elseif ($role === 'mahasiswa') {
                return redirect('/mahasiswa/dashboard');
            }
        }
        // Jika belum login, tampilkan form login
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
        // Alur: Jika sudah login, jangan tampilkan form register lagi, redirect ke dashboard
        if (session('login')) {
            $role = session('role');
            if ($role === 'dosen') {
                return redirect('/dosen/dashboard');
            } elseif ($role === 'mahasiswa') {
                return redirect('/mahasiswa/dashboard');
            }
        }
        // Jika belum login, tampilkan form register
        return view('auth.register');
    }

    public function registerPerform(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required',
        ]);

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
        // Alur: Jika belum login, tidak bisa akses dashboard, redirect ke login
        // Jika sudah login, tampilkan dashboard
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
    public function laporanIndex(Request $request)
    {
        $dosenId = session('user_id');
        
        // Get all mata kuliah owned by this dosen for filter dropdown
        $matakuliahs = \App\Models\MatakuliahModel::where('dosen_id', $dosenId)
            ->orderBy('semester', 'asc')
            ->orderBy('kode_mk', 'asc')
            ->get();
        
        // Get unique semesters from mata kuliah
        $semesters = \App\Models\MatakuliahModel::where('dosen_id', $dosenId)
            ->distinct()
            ->orderBy('semester', 'asc')
            ->pluck('semester')
            ->toArray();
        
        // Query nilai - only from mata kuliah owned by this dosen
        $query = \App\Models\InputNilaiModel::with(['mahasiswa', 'matakuliah.komponenPenilaian'])
            ->whereHas('matakuliah', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            });
        
        // Filter by semester
        if ($request->filled('semester')) {
            $query->whereHas('matakuliah', function ($q) use ($request) {
                $q->where('semester', (int)$request->semester);
            });
        }
        
        // Filter by matakuliah
        if ($request->filled('matakuliah_id')) {
            $query->where('matakuliah_id', $request->matakuliah_id);
        }
        
        $nilai = $query->orderBy('matakuliah_id', 'asc')
            ->orderBy('mahasiswa_id', 'asc')
            ->paginate(50)
            ->withQueryString();
        
        // Hitung jumlah maksimum tugas dan project dari semua nilai
        $maxTugas = 1;
        $maxProject = 1;
        foreach ($nilai as $item) {
            if ($item->tugas) {
                $tugasArray = [];
                if (is_string($item->tugas)) {
                    $decoded = json_decode($item->tugas, true);
                    $tugasArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->tugas)) {
                    $tugasArray = $item->tugas;
                } else {
                    $tugasArray = [(float)$item->tugas];
                }
                $maxTugas = max($maxTugas, count($tugasArray));
            }
            if ($item->project) {
                $projectArray = [];
                if (is_string($item->project)) {
                    $decoded = json_decode($item->project, true);
                    $projectArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->project)) {
                    $projectArray = $item->project;
                } else {
                    $projectArray = [(float)$item->project];
                }
                $maxProject = max($maxProject, count($projectArray));
            }
        }
        
        return view('dosen.laporan.index', compact('nilai', 'matakuliahs', 'semesters', 'maxTugas', 'maxProject'));
    }

    public function laporanPdf(Request $request)
    {
        $dosenId = session('user_id');
        
        // Query nilai - only from mata kuliah owned by this dosen
        $query = \App\Models\InputNilaiModel::with(['mahasiswa', 'matakuliah.komponenPenilaian'])
            ->whereHas('matakuliah', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            });
        
        // Filter by semester (from query parameter)
        if ($request->filled('semester')) {
            $query->whereHas('matakuliah', function ($q) use ($request) {
                $q->where('semester', (int)$request->semester);
            });
        }
        
        // Filter by matakuliah (from query parameter)
        if ($request->filled('matakuliah_id')) {
            $query->where('matakuliah_id', $request->matakuliah_id);
        }
        
        $nilai = $query->orderBy('matakuliah_id', 'asc')
            ->orderBy('mahasiswa_id', 'asc')
            ->get();
        
        // Hitung jumlah maksimum tugas dan project dari semua nilai
        $maxTugas = 1;
        $maxProject = 1;
        foreach ($nilai as $item) {
            if ($item->tugas) {
                $tugasArray = [];
                if (is_string($item->tugas)) {
                    $decoded = json_decode($item->tugas, true);
                    $tugasArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->tugas)) {
                    $tugasArray = $item->tugas;
                } else {
                    $tugasArray = [(float)$item->tugas];
                }
                $maxTugas = max($maxTugas, count($tugasArray));
            }
            if ($item->project) {
                $projectArray = [];
                if (is_string($item->project)) {
                    $decoded = json_decode($item->project, true);
                    $projectArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->project)) {
                    $projectArray = $item->project;
                } else {
                    $projectArray = [(float)$item->project];
                }
                $maxProject = max($maxProject, count($projectArray));
            }
        }
        
        // Get filter info for display
        $filterInfo = [];
        if ($request->filled('semester')) {
            $filterInfo[] = 'Semester ' . $request->semester;
        }
        if ($request->filled('matakuliah_id')) {
            $matakuliah = \App\Models\MatakuliahModel::find($request->matakuliah_id);
            if ($matakuliah) {
                $filterInfo[] = $matakuliah->nama_mk;
            }
        }
        
        return view('dosen.laporan.pdf', compact('nilai', 'filterInfo', 'maxTugas', 'maxProject'));
    }

    // Mahasiswa - Nilai Akademik
    public function mahasiswaNilai(Request $request)
    {
        $mahasiswaId = session('user_id');
        
        // Get mahasiswa data
        $mahasiswa = \App\Models\DataUserModel::find($mahasiswaId);
        
        if (!$mahasiswa || $mahasiswa->role !== 'mahasiswa') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Query nilai dengan relasi
        $query = \App\Models\InputNilaiModel::with(['matakuliah.komponenPenilaian'])
            ->where('mahasiswa_id', $mahasiswaId);
        
        // Filter berdasarkan semester jika dipilih
        if ($request->filled('semester')) {
            $query->whereHas('matakuliah', function($q) use ($request) {
                $q->where('semester', (int)$request->semester);
            });
        }
        
        $nilai = $query->orderBy('matakuliah_id', 'asc')->get();
        
        // Get daftar semester yang tersedia
        $semesters = \App\Models\InputNilaiModel::where('mahasiswa_id', $mahasiswaId)
            ->with('matakuliah')
            ->get()
            ->pluck('matakuliah.semester')
            ->filter()
            ->unique()
            ->sort()
            ->values();
        
        // Hitung jumlah maksimum tugas dan project dari semua nilai
        $maxTugas = 1;
        $maxProject = 1;
        foreach ($nilai as $item) {
            if ($item->tugas) {
                $tugasArray = [];
                if (is_string($item->tugas)) {
                    $decoded = json_decode($item->tugas, true);
                    $tugasArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->tugas)) {
                    $tugasArray = $item->tugas;
                } else {
                    $tugasArray = [(float)$item->tugas];
                }
                $maxTugas = max($maxTugas, count($tugasArray));
            }
            if ($item->project) {
                $projectArray = [];
                if (is_string($item->project)) {
                    $decoded = json_decode($item->project, true);
                    $projectArray = is_array($decoded) ? $decoded : [];
                } elseif (is_array($item->project)) {
                    $projectArray = $item->project;
                } else {
                    $projectArray = [(float)$item->project];
                }
                $maxProject = max($maxProject, count($projectArray));
            }
        }
        
        return view('mahasiswa.nilai-akademik', compact('mahasiswa', 'nilai', 'semesters', 'maxTugas', 'maxProject'));
    }

    // Mahasiswa - KHS
    public function mahasiswaKhs()
    {
        $mahasiswaId = session('user_id');
        
        // Get mahasiswa data
        $mahasiswa = \App\Models\DataUserModel::find($mahasiswaId);
        
        if (!$mahasiswa || $mahasiswa->role !== 'mahasiswa') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Get all nilai
        $nilai = \App\Models\InputNilaiModel::with('matakuliah')
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('matakuliah_id', 'asc')
            ->get();
        
        // Hitung IPK dan Total SKS
        $totalSKS = 0;
        $totalBobot = 0;
        
        foreach ($nilai as $item) {
            $sks = $item->matakuliah->sks ?? 0;
            $totalSKS += $sks;
            
            // Konversi huruf mutu ke bobot
            $hurufMutu = $item->huruf_mutu ?? '';
            $bobot = 0;
            if ($hurufMutu == 'A') $bobot = 4;
            elseif ($hurufMutu == 'B') $bobot = 3;
            elseif ($hurufMutu == 'C') $bobot = 2;
            elseif ($hurufMutu == 'D') $bobot = 1;
            elseif ($hurufMutu == 'E') $bobot = 0;
            else {
                // Jika belum ada huruf mutu, hitung dari nilai akhir
                $nilaiAkhir = $item->nilai_akhir ?? 0;
                if ($nilaiAkhir >= 85) $bobot = 4;
                elseif ($nilaiAkhir >= 75) $bobot = 3;
                elseif ($nilaiAkhir >= 65) $bobot = 2;
                elseif ($nilaiAkhir >= 55) $bobot = 1;
                else $bobot = 0;
            }
            
            $totalBobot += $sks * $bobot;
        }
        
        $ipk = $totalSKS > 0 ? $totalBobot / $totalSKS : 0;
        
        return view('mahasiswa.khs-transkrip', compact('mahasiswa', 'nilai', 'ipk', 'totalSKS'));
    }

    public function mahasiswaCetakKhs()
    {
        $mahasiswaId = session('user_id');
        
        // Get mahasiswa data
        $mahasiswa = \App\Models\DataUserModel::find($mahasiswaId);
        
        if (!$mahasiswa || $mahasiswa->role !== 'mahasiswa') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Get all nilai
        $nilai = \App\Models\InputNilaiModel::with('matakuliah')
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('matakuliah_id', 'asc')
            ->get();
        
        // Hitung IPK dan Total SKS
        $totalSKS = 0;
        $totalBobot = 0;
        
        foreach ($nilai as $item) {
            $sks = $item->matakuliah->sks ?? 0;
            $totalSKS += $sks;
            
            // Konversi huruf mutu ke bobot
            $hurufMutu = $item->huruf_mutu ?? '';
            $bobot = 0;
            if ($hurufMutu == 'A') $bobot = 4;
            elseif ($hurufMutu == 'B') $bobot = 3;
            elseif ($hurufMutu == 'C') $bobot = 2;
            elseif ($hurufMutu == 'D') $bobot = 1;
            elseif ($hurufMutu == 'E') $bobot = 0;
            else {
                // Jika belum ada huruf mutu, hitung dari nilai akhir
                $nilaiAkhir = $item->nilai_akhir ?? 0;
                if ($nilaiAkhir >= 85) $bobot = 4;
                elseif ($nilaiAkhir >= 75) $bobot = 3;
                elseif ($nilaiAkhir >= 65) $bobot = 2;
                elseif ($nilaiAkhir >= 55) $bobot = 1;
                else $bobot = 0;
            }
            
            $totalBobot += $sks * $bobot;
        }
        
        $ipk = $totalSKS > 0 ? $totalBobot / $totalSKS : 0;
        
        return view('mahasiswa.cetak-khs', compact('mahasiswa', 'nilai', 'ipk', 'totalSKS'));
    }
}

