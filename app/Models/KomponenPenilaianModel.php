<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenPenilaianModel extends Model
{
    protected $table = 'komponen_penilaians';

    protected $fillable = [
        'matakuliah_id',
        'kehadiran',
        'tugas',
        'jumlah_tugas',
        'kuis',
        'project',
        'jumlah_project',
        'uts',
        'uas',
        'total',
    ];

    /**
     * Relasi ke MatakuliahModel
     */
    public function matakuliah()
    {
        return $this->belongsTo(MatakuliahModel::class, 'matakuliah_id');
    }
}

