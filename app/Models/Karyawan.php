<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'id_karyawan',      // tambahkan ini
        'nama_karyawan',
        'divisi_id',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}