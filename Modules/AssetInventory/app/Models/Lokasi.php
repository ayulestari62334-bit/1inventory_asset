<?php

namespace Modules\AssetInventory\app\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';

  protected $fillable = [
    'kode_lokasi',
    'nama_lokasi',
    'keterangan',
    ];
}
