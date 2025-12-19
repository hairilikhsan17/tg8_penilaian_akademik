<?php

namespace App\Http\Controllers;

use App\Models\DataUserModel;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session('login')) {
            $role = session('role');
            if ($role === 'dosen') {
                return redirect('/dosen/dashboard');
            } elseif ($role === 'mahasiswa') {
                return redirect('/mahasiswa/dashboard');
            }
        }
        
        return view('auth.register');
    }

    /**
     * Proses registrasi
     */
    public function store(Request $request)
    {
        // Validasi dasar
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:dosen,mahasiswa',
            'password' => 'required|string|min:6|confirmed',
        ];

        // Tambahkan validasi sesuai role
        if ($request->role === 'dosen') {
            $rules['nip'] = 'required|string|max:255';
        } elseif ($request->role === 'mahasiswa') {
            $rules['nim'] = 'required|string|max:255';
            $rules['semester'] = 'required|integer|min:1|max:14';
            $rules['jurusan'] = 'required|string|max:255';
        }

        // Validasi input - akan otomatis redirect back dengan error jika gagal
        $request->validate($rules);

        // Cek apakah username/email sudah digunakan
        if (DataUserModel::usernameExists($request->email)) {
            return back()
                ->with('error', 'Email/Username sudah digunakan! Silakan gunakan email lain.')
                ->withInput();
        }

        try {
            // Buat user baru di MySQL database
            $user = DataUserModel::createUser([
                'nama_user' => $request->name,
                'username' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
                'nim' => $request->nim ?? null,
                'nip' => $request->nip ?? null,
                'semester' => $request->semester ?? null,
                'jurusan' => $request->jurusan ?? null,
            ]);

            // Simpan juga ke Firebase Realtime Database (sync data)
            $firebaseService = new FirebaseService();
            $firebaseService->syncUser($user);

            // Redirect langsung ke halaman login dengan pesan sukses
            return redirect('/login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan email dan password Anda.');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Test Firebase connection dan ENV variables (untuk debugging)
     * Hapus method ini setelah testing selesai untuk keamanan
     */
    public function testFirebase()
    {
        try {
            $firebaseService = new FirebaseService();
            $testResult = $firebaseService->testConnection();
            
            // Test ENV
            $envVars = [
                'FIREBASE_DATABASE_URL' => env('FIREBASE_DATABASE_URL'),
                'FIREBASE_PROJECT_ID' => env('FIREBASE_PROJECT_ID'),
            ];
            
            return response()->json([
                'firebase_test' => $testResult,
                'env_variables' => $envVars,
                'config_services' => config('services.firebase'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'env_variables' => [
                    'FIREBASE_DATABASE_URL' => env('FIREBASE_DATABASE_URL'),
                    'FIREBASE_PROJECT_ID' => env('FIREBASE_PROJECT_ID'),
                ],
            ], 500);
        }
    }
}


