<?php

namespace App\Http\Controllers;

use App\Models\MatakuliahModel;
use App\Models\DataUserModel;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of matakuliah.
     */
    public function index(Request $request)
    {
        $dosenId = session('user_id');
        
        $query = MatakuliahModel::where('dosen_id', $dosenId);
        
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
        
        $matakuliahs = $query->with('komponenPenilaian')
                            ->orderBy('semester', 'asc')
                            ->orderBy('kode_mk', 'asc')
                            ->get();
        
        return view('dosen.matakuliahs.index', compact('matakuliahs', 'search', 'semester'));
    }

    /**
     * Show the form for creating a new matakuliah.
     */
    public function create()
    {
        return view('dosen.matakuliahs.create');
    }

    /**
     * Store a newly created matakuliah in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:50|unique:matakuliahs,kode_mk',
            'nama_mk' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        try {
            MatakuliahModel::create([
                'kode_mk' => $validated['kode_mk'],
                'nama_mk' => $validated['nama_mk'],
                'semester' => $validated['semester'],
                'sks' => $validated['sks'],
                'dosen_id' => session('user_id'), // Menggunakan user_id dari session
            ]);

            return redirect('/dosen/matakuliahs')
                ->with('success', 'Mata kuliah berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menambahkan mata kuliah: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified matakuliah.
     */
    public function edit($id)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();

        return view('dosen.matakuliahs.edit', compact('matakuliah'));
    }

    /**
     * Update the specified matakuliah in storage.
     */
    public function update(Request $request, $id)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();

        $validated = $request->validate([
            'kode_mk' => 'required|string|max:50|unique:matakuliahs,kode_mk,' . $id,
            'nama_mk' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        try {
            $matakuliah->update([
                'kode_mk' => $validated['kode_mk'],
                'nama_mk' => $validated['nama_mk'],
                'semester' => $validated['semester'],
                'sks' => $validated['sks'],
            ]);

            return redirect('/dosen/matakuliahs')
                ->with('success', 'Mata kuliah berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui mata kuliah: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified matakuliah from storage.
     */
    public function destroy($id)
    {
        $dosenId = session('user_id');
        
        $matakuliah = MatakuliahModel::where('id', $id)
            ->where('dosen_id', $dosenId)
            ->firstOrFail();

        try {
            $matakuliah->delete();

            return redirect('/dosen/matakuliahs')
                ->with('success', 'Mata kuliah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/dosen/matakuliahs')
                ->with('error', 'Gagal menghapus mata kuliah: ' . $e->getMessage());
        }
    }
}

