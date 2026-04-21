<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $fillable = [
        'nama_divisi',
    ];

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'divisi_id');
    }
}