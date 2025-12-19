<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected $database;
    protected $auth;
    protected $databaseUrl;

    /**
     * Inisialisasi Firebase Database
     * 
     * @return Database
     * @throws \Exception
     */
    public function getDatabase(): Database
    {
        if ($this->database) {
            return $this->database;
        }

        $databaseUrl = config('services.firebase.database_url');
        $projectId = config('services.firebase.project_id');
        $credentialsPath = config('services.firebase.credentials_path');

        // Validasi database URL
        if (empty($databaseUrl)) {
            throw new \Exception('FIREBASE_DATABASE_URL tidak ditemukan di environment variables');
        }

        $this->databaseUrl = $databaseUrl;

        try {
            $factory = new Factory();

            // Jika ada service account credentials file, gunakan itu (lebih aman untuk production)
            if (file_exists($credentialsPath) && is_readable($credentialsPath)) {
                $factory = $factory->withServiceAccount($credentialsPath);
            } elseif (!empty($projectId)) {
                // Jika tidak ada file, tapi ada project ID, set project ID
                $factory = $factory->withProjectId($projectId);
            }

            // Set database URI
            $factory = $factory->withDatabaseUri($databaseUrl);

            // Create database instance
            $this->database = $factory->createDatabase();

            return $this->database;

        } catch (\Exception $e) {
            throw new \Exception('Gagal menginisialisasi Firebase: ' . $e->getMessage());
        }
    }

    /**
     * Inisialisasi Firebase Auth
     * 
     * @return Auth
     * @throws \Exception
     */
    public function getAuth(): Auth
    {
        if ($this->auth) {
            return $this->auth;
        }

        $databaseUrl = config('services.firebase.database_url');
        $projectId = config('services.firebase.project_id');
        $credentialsPath = config('services.firebase.credentials_path');

        // Validasi database URL
        if (empty($databaseUrl)) {
            throw new \Exception('FIREBASE_DATABASE_URL tidak ditemukan di environment variables');
        }

        try {
            $factory = new Factory();

            // Jika ada service account credentials file, gunakan itu
            if (file_exists($credentialsPath) && is_readable($credentialsPath)) {
                $factory = $factory->withServiceAccount($credentialsPath);
            } elseif (!empty($projectId)) {
                $factory = $factory->withProjectId($projectId);
            }

            // Set database URI
            $factory = $factory->withDatabaseUri($databaseUrl);

            // Create auth instance
            $this->auth = $factory->createAuth();

            return $this->auth;

        } catch (\Exception $e) {
            throw new \Exception('Gagal menginisialisasi Firebase Auth: ' . $e->getMessage());
        }
    }

    /**
     * Get reference ke path tertentu di Firebase
     * 
     * @param string $path
     * @return \Kreait\Firebase\Database\Reference
     */
    public function getReference(string $path)
    {
        $database = $this->getDatabase();
        return $database->getReference($path);
    }

    /**
     * Get users reference
     * 
     * @return \Kreait\Firebase\Database\Reference
     */
    public function getUsersReference()
    {
        return $this->getReference('users');
    }

    /**
     * Buat user baru di Firebase Authentication
     * 
     * @param string $email
     * @param string $password
     * @param string $displayName
     * @return \Kreait\Firebase\Auth\UserRecord
     * @throws \Exception
     */
    public function createAuthUser(string $email, string $password, string $displayName = null)
    {
        try {
            $auth = $this->getAuth();
            
            $userProperties = [
                'email' => $email,
                'password' => $password,
            ];
            
            if ($displayName) {
                $userProperties['displayName'] = $displayName;
            }
            
            $userRecord = $auth->createUser($userProperties);
            
            return $userRecord;
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat user di Firebase Auth: ' . $e->getMessage());
        }
    }

    /**
     * Login user dengan Firebase Authentication
     * 
     * @param string $email
     * @param string $password
     * @return \Kreait\Firebase\Auth\SignInResult
     * @throws \Exception
     */
    public function signInWithEmailAndPassword(string $email, string $password)
    {
        try {
            $auth = $this->getAuth();
            $signInResult = $auth->signInWithEmailAndPassword($email, $password);
            return $signInResult;
        } catch (\Exception $e) {
            throw new \Exception('Gagal login dengan Firebase Auth: ' . $e->getMessage());
        }
    }

    /**
     * Get user dari Firebase Auth berdasarkan UID
     * 
     * @param string $uid
     * @return \Kreait\Firebase\Auth\UserRecord
     */
    public function getUserByUid(string $uid)
    {
        try {
            $auth = $this->getAuth();
            return $auth->getUser($uid);
        } catch (\Exception $e) {
            throw new \Exception('Gagal mendapatkan user dari Firebase Auth: ' . $e->getMessage());
        }
    }

    /**
     * Sync user data ke Firebase Realtime Database
     * 
     * @param object $user User model dari MySQL
     * @param string|null $firebaseUid Firebase UID (optional)
     * @return bool
     */
    public function syncUser($user, ?string $firebaseUid = null): bool
    {
        try {
            $usersRef = $this->getUsersReference();
            
            // Gunakan Firebase UID jika ada, atau MySQL user ID
            $userId = $firebaseUid ?? $user->id;
            
            // Simpan data user ke Firebase (gunakan Firebase UID atau MySQL ID sebagai key)
            $usersRef->getChild($userId)->set([
                'id' => $user->id,
                'firebase_uid' => $firebaseUid,
                'nama_user' => $user->nama_user,
                'username' => $user->username,
                'email' => $user->username, // username adalah email
                'role' => $user->role,
                'nim' => $user->nim ?? null,
                'nip' => $user->nip ?? null,
                'semester' => $user->semester ?? null,
                'jurusan' => $user->jurusan ?? null,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::warning('Gagal sync user ke Firebase: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'username' => $user->username ?? null
            ]);
            return false;
        }
    }

    /**
     * Test koneksi Firebase (untuk debugging)
     * 
     * @return array
     */
    public function testConnection(): array
    {
        try {
            $database = $this->getDatabase();
            $databaseUrl = config('services.firebase.database_url');
            $projectId = config('services.firebase.project_id');
            
            return [
                'success' => true,
                'database_url' => $databaseUrl,
                'project_id' => $projectId,
                'message' => 'Firebase berhasil terhubung'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'database_url' => config('services.firebase.database_url'),
                'project_id' => config('services.firebase.project_id'),
            ];
        }
    }
}

