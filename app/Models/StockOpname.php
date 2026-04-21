<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'stock_opnames';

    protected $fillable = [
        'kode_sto',
        'tanggal',
        'status',      // 'proses' atau 'selesai'
        'created_by'   // admin/user yang buat stock opname
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // RELASI KE DETAIL
    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class, 'stock_opname_id');
    }

    // RELASI KE USER (creator)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // CEK STATUS SELESAI
    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    // GENERATE KODE STO OTOMATIS
    public static function generateKode()
    {
        $last = self::latest('id')->first();
        $number = $last ? $last->id + 1 : 1;
        return 'STO-' . date('Ymd') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}