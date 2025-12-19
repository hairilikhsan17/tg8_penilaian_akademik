<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\Auth\InvalidPassword;
use Kreait\Firebase\Exception\Auth\UserNotFound;

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

        try {
            // 1. Authenticate dengan Firebase Authentication
            $firebaseService = new FirebaseService();
            $signInResult = $firebaseService->signInWithEmailAndPassword(
                $request->username,
                $request->password
            );
            
            // Dapatkan Firebase UID dari email (karena sign in berhasil, user pasti ada)
            $firebaseAuth = $firebaseService->getAuth();
            $firebaseUser = $firebaseAuth->getUserByEmail($request->username);
            $firebaseUid = $firebaseUser->uid;

            // 2. Cari user di MySQL berdasarkan email/username untuk mendapatkan role dan data lengkap
            $user = LoginModel::where('username', $request->username)->first();

            // Cek jika user tidak ditemukan di MySQL (harusnya ada karena sudah register)
            if (!$user) {
                return back()->with('error', 'User tidak ditemukan di database. Silakan hubungi administrator.');
            }

            // 3. Hapus session selected_role setelah digunakan (jika ada)
            session()->forget('selected_role');

            // 4. Simpan session (gunakan data dari MySQL untuk role dan info lengkap)
            session([
                'login'         => true,
                'user_id'       => $user->id,
                'firebase_uid'  => $firebaseUid,
                'nama_user'     => $user->nama_user,
                'username'      => $user->username,
                'role'          => $user->role
            ]);

            // 5. Arahkan ke dashboard sesuai role
            if ($user->role == "dosen") {
                return redirect('/dosen/dashboard');
            } elseif ($user->role == "mahasiswa") {
                return redirect('/mahasiswa/dashboard');
            } elseif ($user->role == "admin") {
                return redirect('/dashboard');
            } elseif ($user->role == "user") {
                return redirect('/dashboard_user');
            }

        } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            return back()->with('error', 'Password salah!');
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            return back()->with('error', 'Email/Username tidak ditemukan!');
        } catch (\Kreait\Firebase\Exception\AuthException $e) {
            return back()->with('error', 'Email atau password salah!');
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
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
