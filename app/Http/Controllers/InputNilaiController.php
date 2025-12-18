<?php

namespace App\Http\Controllers;

use App\Models\InputNilaiModel;
use App\Models\MatakuliahModel;
use App\Models\KomponenPenilaianModel;
use App\Models\DataUserModel;
use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    /**
     * Display a listing of matakuliah for input nilai.
     */
    public function index(Request $request)
    {
        $dosenId = session('user_id');
        
        $query = MatakuliahModel::with('komponenPenilaian')
            ->where('dosen_id', $dosenId);
        
        // Search functionality
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_mk', 'like', '%' . $search . '%')
                  ->orWhere('nama_mk', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by semester
        $semester = $request->get('semester');
        if ($semester) {
            $query->where('semester', $semester);
        }
        
        // Filter by status komponen penilaian
        $status = $request->get('status');
        if ($status === 'siap') {
            $query->has('komponenPenilaian')
                ->whereHas('komponenPenilaian', function($q) {
                    $q->where('total', 100);
                });
        } elseif ($status === 'belum') {
            $query->doesntHave('komponenPenilaian');
        } elseif ($status === 'belum_lengkap') {
            $query->has('komponenPenilaian')
                ->whereHas('komponenPenilaian', function($q) {
                    $q->where('total', '!=', 100);
                });
        }
        
        $matakuliahs = $query->orderBy('semester', 'asc')
                            ->orderBy('kode_mk', 'asc')
                            ->paginate(15)
                            ->withQueryString();
        
        // Statistik
        $totalMatakuliah = MatakuliahModel::where('dosen_id', $dosenId)->count();
        $siapInputNilai = MatakuliahModel::where('dosen_id', $dosenId)
            ->has('komponenPenilaian')
            ->whereHas('komponenPenilaian', function($q) {
                $q->where('total', 100);
            })
            ->count();
        $belumSiap = $totalMatakuliah - $siapInputNilai;
        
        // Ambil daftar semester yang ada
        $semesters = MatakuliahModel::where('dosen_id', $dosenId)
            ->distinct()
            ->orderBy('semester', 'asc')
            ->pluck('semester');
        
        return view('dosen.nilai-mahasiswa.index', compact('matakuliahs', 'totalMatakuliah', 'siapInputNilai', 'belumSiap', 'semesters', 'search', 'semester', 'status'));
    }

    /**
     * Show the form for creating input nilai.
     */
    public function create($id)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::with('komponenPenilaian')
            ->where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        // Cek apakah komponen penilaian sudah lengkap
        $komponen = $matakuliah->komponenPenilaian;
        if (!$komponen || $komponen->total != 100) {
            return redirect('/dosen/nilai-mahasiswa')
                ->with('error', 'Komponen penilaian belum lengkap atau total ≠ 100%. Silakan atur komponen penilaian terlebih dahulu.');
        }
        
        // Ambil mahasiswa berdasarkan semester matakuliah
        $mahasiswas = DataUserModel::where('role', 'mahasiswa')
            ->where('semester', $matakuliah->semester)
            ->orderBy('nim', 'asc')
            ->get();
        
        // Ambil nilai yang sudah ada
        $nilaiMap = InputNilaiModel::where('matakuliah_id', $matakuliah->id)
            ->get()
            ->keyBy('mahasiswa_id');
        
        // Hitung jumlah tugas dan project maksimum dari data yang sudah disimpan
        $maxTugas = $komponen->jumlah_tugas ?? 1;
        $maxProject = $komponen->jumlah_project ?? 1;
        
        foreach ($nilaiMap as $nilai) {
            if ($nilai->tugas) {
                $tugasArray = is_array($nilai->tugas) ? $nilai->tugas : (is_string($nilai->tugas) ? json_decode($nilai->tugas, true) : [$nilai->tugas]);
                if (is_array($tugasArray)) {
                    $maxTugas = max($maxTugas, count($tugasArray));
                }
            }
            if ($nilai->project) {
                $projectArray = is_array($nilai->project) ? $nilai->project : (is_string($nilai->project) ? json_decode($nilai->project, true) : [$nilai->project]);
                if (is_array($projectArray)) {
                    $maxProject = max($maxProject, count($projectArray));
                }
            }
        }
        
        // Update komponen dengan jumlah maksimum
        $komponen->jumlah_tugas = $maxTugas;
        $komponen->jumlah_project = $maxProject;
        
        return view('dosen.nilai_mahasiswas.index', compact('matakuliah', 'mahasiswas', 'nilaiMap', 'komponen'));
    }

    /**
     * Store a newly created or update existing nilai.
     */
    public function store(Request $request, $id)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::with('komponenPenilaian')
            ->where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        $komponen = $matakuliah->komponenPenilaian;
        if (!$komponen || $komponen->total != 100) {
            return back()
                ->with('error', 'Komponen penilaian belum lengkap atau total ≠ 100%.')
                ->withInput();
        }
        
        // Hitung jumlah tugas dan project maksimum dari data yang akan disimpan
        $maxTugas = $komponen->jumlah_tugas ?? 1;
        $maxProject = $komponen->jumlah_project ?? 1;
        
        $entries = $request->input('entries', []);
        foreach ($entries as $mahasiswaId => $row) {
            // Hitung jumlah tugas maksimum
            if (isset($row['tugas']) && is_array($row['tugas'])) {
                $tugasKeys = array_keys($row['tugas']);
                if (count($tugasKeys) > 0) {
                    $maxTugas = max($maxTugas, max($tugasKeys) + 1);
                }
            }
            // Hitung jumlah project maksimum
            if (isset($row['project']) && is_array($row['project'])) {
                $projectKeys = array_keys($row['project']);
                if (count($projectKeys) > 0) {
                    $maxProject = max($maxProject, max($projectKeys) + 1);
                }
            }
        }
        
        // Update jumlah tugas dan project di komponen penilaian
        $jumlahTugas = $request->input('jumlah_tugas', $maxTugas);
        $jumlahProject = $request->input('jumlah_project', $maxProject);
        
        // Gunakan nilai maksimum antara yang dikirim form dan yang dihitung
        $finalJumlahTugas = max($jumlahTugas, $maxTugas);
        $finalJumlahProject = max($jumlahProject, $maxProject);
        
        if ($finalJumlahTugas != $komponen->jumlah_tugas) {
            $komponen->update(['jumlah_tugas' => $finalJumlahTugas]);
        }
        if ($finalJumlahProject != $komponen->jumlah_project) {
            $komponen->update(['jumlah_project' => $finalJumlahProject]);
        }
        
        $entries = $request->input('entries', []);
        
        foreach ($entries as $mahasiswaId => $row) {
            // Ambil data nilai yang sudah ada (jika ada)
            $existingNilai = InputNilaiModel::where('mahasiswa_id', $mahasiswaId)
                ->where('matakuliah_id', $matakuliah->id)
                ->first();
            
            // Validasi untuk komponen yang bukan array
            $validated = validator($row, [
                'kehadiran' => 'nullable|numeric|min:0|max:100',
                'tugas' => 'nullable|array',
                'tugas.*' => 'nullable|numeric|min:0|max:100',
                'kuis' => 'nullable|numeric|min:0|max:100',
                'project' => 'nullable|array',
                'project.*' => 'nullable|numeric|min:0|max:100',
                'uts' => 'nullable|numeric|min:0|max:100',
                'uas' => 'nullable|numeric|min:0|max:100',
            ])->validate();
            
            $kehadiran = (float)($validated['kehadiran'] ?? 0);
            $kuis = (float)($validated['kuis'] ?? 0);
            $uts = (float)($validated['uts'] ?? 0);
            $uas = (float)($validated['uas'] ?? 0);
            
            // Handle tugas sebagai array
            $tugasArray = $validated['tugas'] ?? [];
            
            // Ambil data tugas yang sudah ada untuk referensi
            $existingTugas = [];
            if ($existingNilai && $existingNilai->tugas) {
                if (is_string($existingNilai->tugas)) {
                    $decoded = json_decode($existingNilai->tugas, true);
                    $existingTugas = is_array($decoded) ? $decoded : [];
                } else {
                    $existingTugas = is_array($existingNilai->tugas) ? $existingNilai->tugas : [];
                }
            }
            
            // Simpan hanya nilai tugas yang ada di form (tidak menggabungkan dengan data lama)
            // Ini memastikan kolom yang dihapus di frontend juga terhapus di database
            $tugasValues = [];
            
            // Hanya ambil nilai dari form yang dikirim
            foreach ($tugasArray as $idx => $val) {
                if ($val !== null && $val !== '') {
                    $tugasValues[] = (float)$val;
                } else {
                    // Jika form kosong, set null (akan dihapus saat array_values)
                    $tugasValues[] = null;
                }
            }
            
            // Hapus null values dari akhir array
            while (count($tugasValues) > 0 && end($tugasValues) === null) {
                array_pop($tugasValues);
            }
            
            // Untuk perhitungan rata-rata, hanya gunakan nilai yang tidak kosong
            $tugasForAverage = array_filter($tugasValues, function($val) {
                return $val !== null && $val !== '';
            });
            $tugasAverage = count($tugasForAverage) > 0 ? array_sum($tugasForAverage) / count($tugasForAverage) : 0;
            
            // Simpan sebagai array dengan index yang benar
            $tugasValues = array_values($tugasValues);
            
            // Handle project sebagai array
            $projectArray = $validated['project'] ?? [];
            
            // Ambil data project yang sudah ada untuk referensi
            $existingProject = [];
            if ($existingNilai && $existingNilai->project) {
                if (is_string($existingNilai->project)) {
                    $decoded = json_decode($existingNilai->project, true);
                    $existingProject = is_array($decoded) ? $decoded : [];
                } else {
                    $existingProject = is_array($existingNilai->project) ? $existingNilai->project : [];
                }
            }
            
            // Simpan hanya nilai project yang ada di form (tidak menggabungkan dengan data lama)
            // Ini memastikan kolom yang dihapus di frontend juga terhapus di database
            $projectValues = [];
            
            // Hanya ambil nilai dari form yang dikirim
            foreach ($projectArray as $idx => $val) {
                if ($val !== null && $val !== '') {
                    $projectValues[] = (float)$val;
                } else {
                    // Jika form kosong, set null (akan dihapus saat array_values)
                    $projectValues[] = null;
                }
            }
            
            // Hapus null values dari akhir array
            while (count($projectValues) > 0 && end($projectValues) === null) {
                array_pop($projectValues);
            }
            
            // Untuk perhitungan rata-rata, hanya gunakan nilai yang tidak kosong
            $projectForAverage = array_filter($projectValues, function($val) {
                return $val !== null && $val !== '';
            });
            $projectAverage = count($projectForAverage) > 0 ? array_sum($projectForAverage) / count($projectForAverage) : 0;
            
            // Simpan sebagai array dengan index yang benar
            $projectValues = array_values($projectValues);
            
            // Hitung nilai akhir berdasarkan rumus rekap (sama dengan perhitungan di view)
            // Rumus: (nilai_input / skala) * bobot, kemudian dijumlahkan
            $nilaiHadirRekap = 0;
            $nilaiTugasRekap = 0;
            $nilaiProjectRekap = 0;
            $nilaiFinalRekap = 0;
            $nilaiQuizRekap = 0;
            $nilaiUtsRekap = 0;
            
            // Nilai Hadir: (kehadiran_input / 25) * bobot_kehadiran
            if ($kehadiran > 0 && $komponen->kehadiran > 0) {
                $nilaiHadirRekap = ($kehadiran / 25) * $komponen->kehadiran;
            }
            
            // Nilai Tugas: (rata-rata_tugas / 100) * bobot_tugas
            if ($tugasAverage > 0 && $komponen->tugas > 0) {
                $nilaiTugasRekap = ($tugasAverage / 100) * $komponen->tugas;
            }
            
            // Nilai Quiz: (kuis_input / 100) * bobot_kuis
            if ($kuis > 0 && $komponen->kuis > 0) {
                $nilaiQuizRekap = ($kuis / 100) * $komponen->kuis;
            }
            
            // Nilai Project: (rata-rata_project / 100) * bobot_project
            if ($projectAverage > 0 && $komponen->project > 0) {
                $nilaiProjectRekap = ($projectAverage / 100) * $komponen->project;
            }
            
            // Nilai UTS: (uts_input / 100) * bobot_uts
            if ($uts > 0 && $komponen->uts > 0) {
                $nilaiUtsRekap = ($uts / 100) * $komponen->uts;
            }
            
            // Nilai Final (UAS): (uas_input / 100) * bobot_uas
            if ($uas > 0 && $komponen->uas > 0) {
                $nilaiFinalRekap = ($uas / 100) * $komponen->uas;
            }
            
            // Nilai Akhir = jumlah semua nilai rekap
            $nilaiAkhir = $nilaiHadirRekap + $nilaiTugasRekap + $nilaiProjectRekap + $nilaiFinalRekap + $nilaiQuizRekap + $nilaiUtsRekap;
            
            // Konversi nilai ke huruf mutu
            $hurufMutu = $this->konversiNilai($nilaiAkhir);
            $keterangan = $this->getKeteranganNilai($nilaiAkhir);
            
            InputNilaiModel::updateOrCreate(
                [
                    'mahasiswa_id' => $mahasiswaId,
                    'matakuliah_id' => $matakuliah->id,
                ],
                [
                    'kehadiran' => $kehadiran,
                    'tugas' => json_encode($tugasValues), // Simpan sebagai JSON array
                    'kuis' => $kuis,
                    'project' => json_encode($projectValues), // Simpan sebagai JSON array
                    'uts' => $uts,
                    'uas' => $uas,
                    'nilai_akhir' => $nilaiAkhir,
                    'huruf_mutu' => $hurufMutu,
                    'keterangan' => $keterangan,
                ]
            );
        }
        
        return redirect('/dosen/matakuliahs/' . $matakuliah->id . '/nilai')
            ->with('success', 'Nilai berhasil disimpan!');
    }
    
    /**
     * Konversi nilai ke huruf mutu (sistem lengkap: A, A-, B+, B, B-, C+, C, C-, D, E)
     */
    protected function konversiNilai($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 85) return 'A-';
        if ($nilai >= 80) return 'B+';
        if ($nilai >= 75) return 'B';
        if ($nilai >= 70) return 'B-';
        if ($nilai >= 65) return 'C+';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 55) return 'C-';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
    
    /**
     * Get keterangan nilai
     */
    protected function getKeteranganNilai($nilai)
    {
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 85) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 75) return 'Baik';
        if ($nilai >= 70) return 'Baik';
        if ($nilai >= 65) return 'Cukup';
        if ($nilai >= 60) return 'Cukup';
        if ($nilai >= 55) return 'Cukup';
        if ($nilai >= 50) return 'Kurang';
        return 'Sangat Kurang';
    }
    
    /**
     * Konversi huruf mutu ke bobot untuk perhitungan IPK
     */
    public static function hurufMutuToBobot($hurufMutu)
    {
        switch ($hurufMutu) {
            case 'A': return 4.00;
            case 'A-': return 3.75;
            case 'B+': return 3.50;
            case 'B': return 3.00;
            case 'B-': return 2.75;
            case 'C+': return 2.50;
            case 'C': return 2.00;
            case 'C-': return 1.75;
            case 'D': return 1.00;
            case 'E': return 0.00;
            default: return 0.00;
        }
    }
}
