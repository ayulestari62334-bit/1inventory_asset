<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    use HasFactory;

    protected $table = 'stock_opname_details';

    protected $fillable = [
        'stock_opname_id',
        'barang_id',
        'stok_sistem',      // stok menurut sistem
        'stok_fisik',       // stok hasil stock opname
        'status',           // layak / tidak_layak
        'foto_barang',      // path foto terbaru
        'scanned_by',       // user/admin yang scan
        'scanned_at'        // timestamp scan
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    // RELASI KE BARANG
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // RELASI KE STOCK OPNAME
    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class, 'stock_opname_id');
    }

    // RELASI KE USER YANG SCAN
    public function scannedByUser()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    // CEK APAKAH SUDAH DI-SCAN
    public function isScanned()
    {
        return !is_null($this->status);
    }
}