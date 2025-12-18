<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DataUserModel extends Model
{
    // Tentukan nama tabel
    protected $table = 'data_user';

    // Field yang bisa diisi (mass assignment)
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
        'nim',
        'nip',
        'semester',
        'jurusan'
    ];

    // Field yang disembunyikan saat serialisasi
    protected $hidden = [
        'password'
    ];

    // Cast password ke hash saat disimpan
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Cari user berdasarkan username
     */
    public static function findByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    /**
     * Cek apakah username sudah ada
     */
    public static function usernameExists($username, $excludeId = null)
    {
        $query = self::where('username', $username);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Buat user baru
     */
    public static function createUser($data)
    {
        $user = new self();
        $user->nama_user = $data['nama_user'];
        $user->username = $data['username'];
        $user->password = $data['password']; // Akan di-hash otomatis oleh setPasswordAttribute
        $user->role = $data['role'];
        $user->nim = $data['nim'] ?? null;
        $user->nip = $data['nip'] ?? null;
        $user->semester = $data['semester'] ?? null;
        $user->jurusan = $data['jurusan'] ?? null;
        $user->save();
        return $user;
    }

    /**
     * Update user
     */
    public function updateUser($data)
    {
        $updateData = [
            'nama_user' => $data['nama_user'] ?? $this->nama_user,
            'username' => $data['username'] ?? $this->username,
            'role' => $data['role'] ?? $this->role,
            'nim' => $data['nim'] ?? $this->nim,
            'nip' => $data['nip'] ?? $this->nip,
            'semester' => $data['semester'] ?? $this->semester,
            'jurusan' => $data['jurusan'] ?? $this->jurusan,
        ];

        // Update password hanya jika diberikan
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        return $this->update($updateData);
    }
}

