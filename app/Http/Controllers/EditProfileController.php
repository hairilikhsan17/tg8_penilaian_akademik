<?php

namespace App\Http\Controllers;

use App\Models\DataUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EditProfileController extends Controller
{
    /**
     * Tampilkan profil dosen
     */
    public function dosenProfil()
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah dosen
        if (session('role') !== 'dosen') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Akses ditolak!');
        }

        // Ambil data user dari database
        $userId = session('user_id');
        $user = DataUserModel::find($userId);

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan!');
        }

        // Data untuk view (menggunakan data dari user)
        // TODO: Hitung total mata kuliah dari relasi jika ada
        $totalMatakuliah = 0; // Default, bisa dihitung dari relasi jika ada
        
        $data = [
            'user' => $user,
            'nama' => $user->nama_user,
            'nip' => $user->nip ?? '',
            'email' => $user->username,
            'user_email' => $user->username,
            'totalMatakuliah' => $totalMatakuliah,
        ];

        return view('dosen.profil', $data);
    }

    /**
     * Update profil dosen
     */
    public function dosenProfilUpdate(Request $request)
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah dosen
        if (session('role') !== 'dosen') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Akses ditolak!');
        }

        $userId = session('user_id');
        $user = DataUserModel::find($userId);

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan!');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'user_email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'user_email.required' => 'Email login harus diisi',
            'user_email.email' => 'Format email login tidak valid',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'foto_profil.image' => 'File harus berupa gambar',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek apakah email login sudah digunakan oleh user lain
        if ($request->user_email !== $user->username) {
            if (DataUserModel::usernameExists($request->user_email, $userId)) {
                return back()
                    ->with('error', 'Email login sudah digunakan!')
                    ->withInput();
            }
        }

        try {
            // Update data user
            $updateData = [
                'nama_user' => $request->nama,
                'username' => $request->user_email,
                'nip' => $request->nip ?? null,
            ];

            // Update password jika diberikan
            if ($request->filled('password')) {
                $updateData['password'] = $request->password;
            }

            $user->updateUser($updateData);

            // Update session
            session([
                'nama_user' => $request->nama,
                'username' => $request->user_email,
            ]);

            // Handle upload foto profil jika ada
            if ($request->hasFile('foto_profil')) {
                // Simpan foto profil (implementasi sesuai kebutuhan)
                // $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
                // Simpan path ke database jika diperlukan
            }

            return redirect('/dosen/profil')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus foto profil dosen
     */
    public function dosenProfilFotoDelete(Request $request)
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah dosen
        if (session('role') !== 'dosen') {
            return redirect('/mahasiswa/dashboard')->with('error', 'Akses ditolak!');
        }

        // Implementasi hapus foto profil
        // Hapus file foto dari storage jika ada

        return redirect('/dosen/profil')
            ->with('success', 'Foto profil berhasil dihapus!');
    }

    /**
     * Tampilkan profil mahasiswa
     */
    public function mahasiswaProfil()
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah mahasiswa
        if (session('role') !== 'mahasiswa') {
            return redirect('/dosen/dashboard')->with('error', 'Akses ditolak!');
        }

        // Ambil data user dari database
        $userId = session('user_id');
        $user = DataUserModel::find($userId);

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan!');
        }

        // Data untuk view (menggunakan data dari user)
        // TODO: Hitung IPK dari nilai-nilai mahasiswa jika ada
        $ipk = 0.00; // Default IPK, bisa dihitung dari nilai-nilai jika ada
        
        $data = [
            'user' => $user,
            'nama' => $user->nama_user,
            'nim' => $user->nim ?? '',
            'email' => $user->username,
            'user_email' => $user->username,
            'semester' => $user->semester ?? '',
            'jurusan' => $user->jurusan ?? '',
            'ipk' => $ipk,
        ];

        return view('mahasiswa.profil', $data);
    }

    /**
     * Update profil mahasiswa
     */
    public function mahasiswaProfilUpdate(Request $request)
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah mahasiswa
        if (session('role') !== 'mahasiswa') {
            return redirect('/dosen/dashboard')->with('error', 'Akses ditolak!');
        }

        $userId = session('user_id');
        $user = DataUserModel::find($userId);

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan!');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'user_email' => 'required|email|max:255',
            'semester' => 'nullable|integer|min:1|max:14',
            'jurusan' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'user_email.required' => 'Email login harus diisi',
            'user_email.email' => 'Format email login tidak valid',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 14',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'foto_profil.image' => 'File harus berupa gambar',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek apakah email login sudah digunakan oleh user lain
        if ($request->user_email !== $user->username) {
            if (DataUserModel::usernameExists($request->user_email, $userId)) {
                return back()
                    ->with('error', 'Email login sudah digunakan!')
                    ->withInput();
            }
        }

        try {
            // Update data user
            $updateData = [
                'nama_user' => $request->nama,
                'username' => $request->user_email,
                'nim' => $request->nim ?? null,
                'semester' => $request->semester ?? null,
                'jurusan' => $request->jurusan ?? null,
            ];

            // Update password jika diberikan
            if ($request->filled('password')) {
                $updateData['password'] = $request->password;
            }

            $user->updateUser($updateData);

            // Update session
            session([
                'nama_user' => $request->nama,
                'username' => $request->user_email,
            ]);

            // Handle upload foto profil jika ada
            if ($request->hasFile('foto_profil')) {
                // Simpan foto profil (implementasi sesuai kebutuhan)
                // $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
                // Simpan path ke database jika diperlukan
            }

            return redirect('/mahasiswa/profil')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus foto profil mahasiswa
     */
    public function mahasiswaProfilFotoDelete(Request $request)
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Cek apakah role adalah mahasiswa
        if (session('role') !== 'mahasiswa') {
            return redirect('/dosen/dashboard')->with('error', 'Akses ditolak!');
        }

        // Implementasi hapus foto profil
        // Hapus file foto dari storage jika ada

        return redirect('/mahasiswa/profil')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}



