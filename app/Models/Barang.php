<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// IMPORT DARI MODULE
use Modules\AssetInventory\app\Models\KategoriBarang;
use Modules\AssetInventory\app\Models\JenisBarang;
use Modules\AssetInventory\app\Models\Merek;
use Modules\AssetInventory\app\Models\Warna;
use Modules\AssetInventory\app\Models\Lokasi;

use App\Models\Karyawan;
use App\Models\StockOpnameDetail; // 🔥 TAMBAHAN

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'no_asset',
        'barcode', 
        'kategori_id',
        'jenis_id',
        'merek_id',
        'warna_id',
        'lokasi_id',
        'karyawan_id',
        'foto',
        'serial_number',
        'jenis_licence',
        'kode_licence',
        'tanggal_masuk',
        'status_barang'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE MASTER DATA
    |--------------------------------------------------------------------------
    */

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_id', 'id');
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class, 'merek_id', 'id');
    }

    public function warna()
    {
        return $this->belongsTo(Warna::class, 'warna_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KE KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 RELASI KE STOCK OPNAME (PAKAI BARCODE)
    |--------------------------------------------------------------------------
    */

    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'barcode', 'barcode');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 OPSIONAL: RELASI VIA BARANG_ID
    |--------------------------------------------------------------------------
    */

    public function stockOpnameDetailsById()
    {
        return $this->hasMany(StockOpnameDetail::class, 'barang_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 FIX: CEK STATUS STO (GABUNGAN BARCODE + ID)
    |--------------------------------------------------------------------------
    */

    public function isSto()
    {
        return $this->stockOpnameDetails()->exists()
            || $this->stockOpnameDetailsById()->exists();
    }
}