<?php

namespace App\Http\Controllers;

use App\Models\DataUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller
{
    /**
     * Display a listing of mahasiswa (data_user with role='mahasiswa').
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $query = DataUserModel::where('role', 'mahasiswa');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', '%' . $search . '%')
                  ->orWhere('nama_user', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }
        
        $mahasiswas = $query->orderBy('nama_user', 'asc')->get();
        
        return view('dosen.mahasiswas.index', compact('mahasiswas', 'search'));
    }

    /**
     * Show the form for creating a new mahasiswa.
     */
    public function create()
    {
        return view('dosen.mahasiswas.create');
    }

    /**
     * Store a newly created mahasiswa in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:255|unique:data_user,nim',
            'nama' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'jurusan' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        // Generate username dari email atau NIM
        $username = $validated['email'] ?? $validated['nim'];
        
        // Cek apakah username sudah ada
        if (DataUserModel::usernameExists($username)) {
            return back()
                ->with('error', 'Email/Username sudah digunakan!')
                ->withInput();
        }

        // Generate password default (bisa diubah nanti)
        $defaultPassword = $validated['nim']; // Default password = NIM

        try {
            DataUserModel::createUser([
                'nama_user' => $validated['nama'],
                'username' => $username,
                'password' => $defaultPassword,
                'role' => 'mahasiswa',
                'nim' => $validated['nim'],
                'semester' => $validated['semester'],
                'jurusan' => $validated['jurusan'],
            ]);

            return redirect('/dosen/mahasiswas')
                ->with('success', 'Data mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menambahkan data mahasiswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified mahasiswa.
     */
    public function edit($id)
    {
        $mahasiswa = DataUserModel::where('id', $id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        return view('dosen.mahasiswas.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified mahasiswa in storage.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = DataUserModel::where('id', $id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        $validated = $request->validate([
            'nim' => 'required|string|max:255|unique:data_user,nim,' . $id,
            'nama' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:14',
            'jurusan' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        // Generate username dari email atau NIM
        $username = $validated['email'] ?? $validated['nim'];
        
        // Cek apakah username sudah ada (kecuali untuk user ini)
        if (DataUserModel::usernameExists($username, $id)) {
            return back()
                ->with('error', 'Email/Username sudah digunakan!')
                ->withInput();
        }

        try {
            $mahasiswa->updateUser([
                'nama_user' => $validated['nama'],
                'username' => $username,
                'nim' => $validated['nim'],
                'semester' => $validated['semester'],
                'jurusan' => $validated['jurusan'],
            ]);

            return redirect('/dosen/mahasiswas')
                ->with('success', 'Data mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui data mahasiswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified mahasiswa from storage.
     */
    public function destroy($id)
    {
        $mahasiswa = DataUserModel::where('id', $id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        try {
            $mahasiswa->delete();

            return redirect('/dosen/mahasiswas')
                ->with('success', 'Data mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/dosen/mahasiswas')
                ->with('error', 'Gagal menghapus data mahasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing password of the specified mahasiswa.
     */
    public function password($id)
    {
        $mahasiswa = DataUserModel::where('id', $id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        return view('dosen.mahasiswas.password', compact('mahasiswa'));
    }

    /**
     * Update the password of the specified mahasiswa.
     */
    public function passwordUpdate(Request $request, $id)
    {
        $mahasiswa = DataUserModel::where('id', $id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $mahasiswa->updateUser([
                'password' => $validated['password'],
            ]);

            return redirect('/dosen/mahasiswas')
                ->with('success', 'Password mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui password: ' . $e->getMessage())
                ->withInput();
        }
    }
}

