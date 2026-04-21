<?php

namespace Modules\AssetInventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AssetInventory\app\Models\KategoriBarang;

class JenisBarang extends Model
{
    protected $table = 'jenis_barang';

    protected $fillable = [
        'kategori_barang_id', // ✅ WAJIB
        'kode_jenis',
        'nama_jenis',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriBarang::class,
            'kategori_barang_id'
        );
    }
}
