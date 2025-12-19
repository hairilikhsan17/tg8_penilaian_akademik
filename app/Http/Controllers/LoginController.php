<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Inisialisasi Firebase menggunakan FirebaseService (jika diperlukan)
        // $firebaseService = new FirebaseService();
        // $usersRef = $firebaseService->getUsersReference();

        // Cari user berdasarkan username untuk mendapatkan role
        $user = LoginModel::where('username', $request->username)->first();

        // Cek jika user tidak ditemukan
        if (!$user) {
            return back()->with('error', 'Username atau password salah!');
        }

        // Gunakan method authenticate dari model dengan role dari database
        $result = LoginModel::authenticate(
            $request->username,
            $request->password,
            $user->role
        );

        // Cek jika autentikasi gagal
        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        // Hapus session selected_role setelah digunakan (jika ada)
        session()->forget('selected_role');

        // Simpan session
        session([
            'login'     => true,
            'user_id'   => $result['user']['id'],
            'nama_user' => $result['user']['nama_user'],
            'username'  => $result['user']['username'],
            'role'      => $result['user']['role']
        ]);

        // Arahkan ke dashboard sesuai role
        if ($result['user']['role'] == "dosen") {
            return redirect('/dosen/dashboard');
        } elseif ($result['user']['role'] == "mahasiswa") {
            return redirect('/mahasiswa/dashboard');
        } elseif ($result['user']['role'] == "admin") {
            return redirect('/dashboard');
        } elseif ($result['user']['role'] == "user") {
            return redirect('/dashboard_user');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
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
            
            // Test ENV - sesuai dengan instruksi user
            $envVars = [
                'FIREBASE_DATABASE_URL' => env('FIREBASE_DATABASE_URL'),
            ];
            
            // Untuk test di localhost, gunakan dd() seperti yang diminta
            if (config('app.debug')) {
                dd([
                    'env_firebase_database_url' => env('FIREBASE_DATABASE_URL'),
                    'firebase_test' => $testResult,
                    'config_services' => config('services.firebase'),
                ]);
            }
            
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
                ],
            ], 500);
        }
    }
}
