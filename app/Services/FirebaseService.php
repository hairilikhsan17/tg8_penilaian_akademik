<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected $database;
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

