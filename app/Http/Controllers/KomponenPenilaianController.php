<?php

namespace App\Http\Controllers;

use App\Models\KomponenPenilaianModel;
use App\Models\MatakuliahModel;
use Illuminate\Http\Request;

class KomponenPenilaianController extends Controller
{
    /**
     * Display a listing of komponen penilaian.
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
        
        // Filter by status komponen penilaian
        $status = $request->get('status');
        if ($status === 'sudah') {
            $query->has('komponenPenilaian');
        } elseif ($status === 'belum') {
            $query->doesntHave('komponenPenilaian');
        }
        
        $matakuliahs = $query->orderBy('semester', 'asc')
                            ->orderBy('kode_mk', 'asc')
                            ->paginate(15)
                            ->withQueryString();
        
        // Statistik
        $totalMatakuliah = MatakuliahModel::where('dosen_id', $dosenId)->count();
        $sudahAdaKomponen = MatakuliahModel::where('dosen_id', $dosenId)
            ->has('komponenPenilaian')
            ->count();
        $belumAdaKomponen = $totalMatakuliah - $sudahAdaKomponen;
        
        return view('dosen.komponen-penilaian.index', compact('matakuliahs', 'totalMatakuliah', 'sudahAdaKomponen', 'belumAdaKomponen', 'search', 'status'));
    }

    /**
     * Show the form for creating/editing komponen penilaian.
     */
    public function create($id, Request $request)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        $komponen = $matakuliah->komponenPenilaian;
        
        // Cek apakah komponen sudah ada (instance dari model)
        $komponenExists = $komponen && $komponen instanceof KomponenPenilaianModel;
        
        // Set default values jika belum ada
        if (!$komponenExists) {
            $komponen = (object)[
                'kehadiran' => null,
                'tugas' => null,
                'kuis' => null,
                'project' => null,
                'uts' => null,
                'uas' => null,
            ];
        }
        
        // Tentukan action berdasarkan query parameter atau status komponen
        $action = $request->get('action', $komponenExists ? 'edit' : 'atur');
        
        // Gunakan view yang berbeda berdasarkan action
        if ($action === 'edit' && $komponenExists) {
            return view('dosen.komponen-penilaian.edit', compact('matakuliah', 'komponen'));
        } else {
            return view('dosen.komponen-penilaian.atur', compact('matakuliah', 'komponen'));
        }
    }

    /**
     * Store a newly created or update existing komponen penilaian in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'kehadiran' => 'required|integer|min:0|max:100',
            'tugas' => 'required|integer|min:0|max:100',
            'jumlah_tugas' => 'nullable|integer|min:1|max:20',
            'kuis' => 'required|integer|min:0|max:100',
            'project' => 'required|integer|min:0|max:100',
            'jumlah_project' => 'nullable|integer|min:1|max:20',
            'uts' => 'required|integer|min:0|max:100',
            'uas' => 'required|integer|min:0|max:100',
        ]);
        
        // Validasi total harus 100%
        $total = $validated['kehadiran'] + 
                 $validated['tugas'] + 
                 $validated['kuis'] + 
                 $validated['project'] + 
                 $validated['uts'] + 
                 $validated['uas'];
        
        if ($total !== 100) {
            return back()
                ->withInput()
                ->withErrors(['total' => 'Total bobot harus tepat 100%. Saat ini: ' . $total . '%']);
        }
        
        // Cek apakah dosen memiliki akses ke matakuliah ini
        $dosenId = session('user_id');
        $matakuliah = MatakuliahModel::where('id', $validated['matakuliah_id'])
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        try {
            // Cek apakah komponen penilaian sudah ada
            $komponen = KomponenPenilaianModel::where('matakuliah_id', $validated['matakuliah_id'])->first();
            
            $payload = array_merge($validated, [
                'total' => $total,
                'jumlah_tugas' => $validated['jumlah_tugas'] ?? 1,
                'jumlah_project' => $validated['jumlah_project'] ?? 1,
            ]);
            
            if ($komponen) {
                // Update jika sudah ada
                $komponen->update($payload);
                $message = 'Komponen penilaian berhasil diperbarui.';
            } else {
                // Create jika belum ada
                KomponenPenilaianModel::create($payload);
                $message = 'Komponen penilaian berhasil disimpan.';
            }
            
            return redirect('/dosen/komponen-penilaian')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menyimpan komponen penilaian: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified komponen penilaian.
     */
    public function edit($id)
    {
        $dosenId = session('user_id');
        
        $komponen = KomponenPenilaianModel::findOrFail($id);
        
        // Cek apakah dosen memiliki akses ke matakuliah ini
        $matakuliah = MatakuliahModel::where('id', $komponen->matakuliah_id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        return view('dosen.komponen-penilaian.edit', compact('matakuliah', 'komponen'));
    }

    /**
     * Update the specified komponen penilaian in storage.
     */
    public function update(Request $request, $id)
    {
        $komponen = KomponenPenilaianModel::findOrFail($id);
        
        $dosenId = session('user_id');
        
        // Cek apakah dosen memiliki akses ke matakuliah ini
        $matakuliah = MatakuliahModel::where('id', $komponen->matakuliah_id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();
        
        $validated = $request->validate([
            'kehadiran' => 'required|integer|min:0|max:100',
            'tugas' => 'required|integer|min:0|max:100',
            'jumlah_tugas' => 'nullable|integer|min:1|max:20',
            'kuis' => 'required|integer|min:0|max:100',
            'project' => 'required|integer|min:0|max:100',
            'jumlah_project' => 'nullable|integer|min:1|max:20',
            'uts' => 'required|integer|min:0|max:100',
            'uas' => 'required|integer|min:0|max:100',
        ]);
        
        // Validasi total harus 100%
        $total = $validated['kehadiran'] + 
                 $validated['tugas'] + 
                 $validated['kuis'] + 
                 $validated['project'] + 
                 $validated['uts'] + 
                 $validated['uas'];
        
        if ($total !== 100) {
            return back()
                ->withInput()
                ->withErrors(['total' => 'Total bobot harus tepat 100%. Saat ini: ' . $total . '%']);
        }
        
        try {
            $komponen->update([
                'kehadiran' => $validated['kehadiran'],
                'tugas' => $validated['tugas'],
                'jumlah_tugas' => $validated['jumlah_tugas'] ?? 1,
                'kuis' => $validated['kuis'],
                'project' => $validated['project'],
                'jumlah_project' => $validated['jumlah_project'] ?? 1,
                'uts' => $validated['uts'],
                'uas' => $validated['uas'],
                'total' => $total,
            ]);
            
            return redirect('/dosen/komponen-penilaian')
                ->with('success', 'Komponen penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui komponen penilaian: ' . $e->getMessage())
                ->withInput();
        }
    }
}
