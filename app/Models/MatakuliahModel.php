<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatakuliahModel extends Model
{
    protected $table = 'matakuliahs';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'semester',
        'dosen_id',
        'sks',
    ];

    /**
     * Relasi ke DataUserModel (dosen)
     */
    public function dosen()
    {
        return $this->belongsTo(DataUserModel::class, 'dosen_id');
    }

    /**
     * Relasi ke KomponenPenilaianModel
     */
    public function komponenPenilaian()
    {
        return $this->hasOne(KomponenPenilaianModel::class, 'matakuliah_id');
    }

    /**
     * Relasi ke InputNilaiModel
     */
    public function nilaiMahasiswas()
    {
        return $this->hasMany(InputNilaiModel::class, 'matakuliah_id');
    }
}

