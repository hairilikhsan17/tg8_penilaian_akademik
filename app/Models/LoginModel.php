<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class LoginModel extends Model
{
    // Tentukan nama tabel yang benar
    protected $table = 'data_user';

    // Field yang bisa diisi
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role'
    ];

    public static function authenticate($username, $password, $role)
    {
        // Cek username berdasarkan database
        $user = self::where('username', $username)->first();

        // Cek jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Username atau password salah!'
            ];
        }

        // Cek role (admin / user)
        if ($role != $user->role) {
            return [
                'success' => false,
                'message' => 'Role tidak sesuai!'
            ];
        }

        // Return data user untuk session
        return [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'nama_user' => $user->nama_user,
                'username' => $user->username,
                'role' => $user->role
            ]
        ];
    }
}
