<?php

namespace Modules\AssetInventory\app\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $table = 'kategori_barang';

    protected $fillable = [
        'kode_barang',
        'nama_kategori',
        'keterangan'
    ];
}
