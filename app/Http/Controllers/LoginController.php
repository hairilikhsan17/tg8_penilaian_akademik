<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
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
}
