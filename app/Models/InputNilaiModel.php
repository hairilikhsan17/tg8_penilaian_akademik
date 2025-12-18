<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputNilaiModel extends Model
{
    protected $table = 'nilai_mahasiswas';

    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'kehadiran',
        'tugas',
        'kuis',
        'project',
        'uts',
        'uas',
        'nilai_akhir',
        'huruf_mutu',
        'keterangan',
    ];

    /**
     * Cast attributes to native types
     */
    protected $casts = [
        'tugas' => 'array',
        'project' => 'array',
        'kehadiran' => 'float',
        'kuis' => 'float',
        'uts' => 'float',
        'uas' => 'float',
        'nilai_akhir' => 'float',
    ];

    /**
     * Relasi ke DataUserModel (mahasiswa)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(DataUserModel::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke MatakuliahModel
     */
    public function matakuliah()
    {
        return $this->belongsTo(MatakuliahModel::class, 'matakuliah_id');
    }

    /**
     * Konversi nilai ke huruf mutu
     */
    public function getHurufMutuAttribute($value)
    {
        if (!$value && $this->nilai_akhir) {
            return $this->konversiNilai($this->nilai_akhir);
        }
        return $value;
    }

    /**
     * Helper method untuk konversi nilai ke huruf mutu (sistem lengkap: A, A-, B+, B, B-, C+, C, C-, D, E)
     */
    protected function konversiNilai($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 85) return 'A-';
        if ($nilai >= 80) return 'B+';
        if ($nilai >= 75) return 'B';
        if ($nilai >= 70) return 'B-';
        if ($nilai >= 65) return 'C+';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 55) return 'C-';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
    
    /**
     * Konversi huruf mutu ke bobot untuk perhitungan IPK
     */
    public static function hurufMutuToBobot($hurufMutu)
    {
        switch ($hurufMutu) {
            case 'A': return 4.00;
            case 'A-': return 3.75;
            case 'B+': return 3.50;
            case 'B': return 3.00;
            case 'B-': return 2.75;
            case 'C+': return 2.50;
            case 'C': return 2.00;
            case 'C-': return 1.75;
            case 'D': return 1.00;
            case 'E': return 0.00;
            default: return 0.00;
        }
    }
    
    /**
     * Helper method untuk mendapatkan warna CSS dari huruf mutu
     */
    public static function getHurufMutuColors($hurufMutu)
    {
        $colors = [
            'bgColor' => 'bg-gray-100',
            'textColor' => 'text-gray-800',
            'borderColor' => 'border-gray-300'
        ];
        
        if (strpos($hurufMutu, 'A') === 0) {
            $colors = [
                'bgColor' => 'bg-green-100',
                'textColor' => 'text-green-800',
                'borderColor' => 'border-green-600'
            ];
        } elseif (strpos($hurufMutu, 'B') === 0) {
            $colors = [
                'bgColor' => 'bg-blue-100',
                'textColor' => 'text-blue-800',
                'borderColor' => 'border-blue-600'
            ];
        } elseif (strpos($hurufMutu, 'C') === 0) {
            $colors = [
                'bgColor' => 'bg-yellow-100',
                'textColor' => 'text-yellow-800',
                'borderColor' => 'border-yellow-600'
            ];
        } elseif ($hurufMutu == 'D') {
            $colors = [
                'bgColor' => 'bg-orange-100',
                'textColor' => 'text-orange-800',
                'borderColor' => 'border-orange-600'
            ];
        } elseif ($hurufMutu == 'E') {
            $colors = [
                'bgColor' => 'bg-red-100',
                'textColor' => 'text-red-800',
                'borderColor' => 'border-red-600'
            ];
        }
        
        return $colors;
    }

    /**
     * Accessor untuk keterangan
     */
    public function getKeteranganAttribute($value)
    {
        if (!$value && $this->nilai_akhir) {
            return $this->getKeteranganNilai($this->nilai_akhir);
        }
        return $value;
    }

    /**
     * Helper method untuk mendapatkan keterangan nilai
     */
    protected function getKeteranganNilai($nilai)
    {
        if ($nilai >= 85) return 'Sangat Baik';
        if ($nilai >= 75) return 'Baik';
        if ($nilai >= 65) return 'Cukup';
        if ($nilai >= 55) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Accessor untuk mendapatkan rata-rata tugas
     */
    public function getTugasAverageAttribute()
    {
        if (!$this->tugas || !is_array($this->tugas)) {
            return 0;
        }
        $tugasValues = array_filter($this->tugas, function($val) {
            return $val !== null && $val !== '';
        });
        return count($tugasValues) > 0 ? array_sum($tugasValues) / count($tugasValues) : 0;
    }

    /**
     * Accessor untuk mendapatkan rata-rata project
     */
    public function getProjectAverageAttribute()
    {
        if (!$this->project || !is_array($this->project)) {
            return 0;
        }
        $projectValues = array_filter($this->project, function($val) {
            return $val !== null && $val !== '';
        });
        return count($projectValues) > 0 ? array_sum($projectValues) / count($projectValues) : 0;
    }
}

