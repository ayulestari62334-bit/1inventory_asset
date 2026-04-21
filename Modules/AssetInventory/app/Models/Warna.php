<?php

namespace Modules\AssetInventory\app\Models;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    protected $table = 'warnas';

    protected $fillable = [
        'kode_warna',
        'nama_warna',
        'hex_warna',
        'keterangan',
    ];
}
