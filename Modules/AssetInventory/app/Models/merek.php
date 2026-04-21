<?php

namespace Modules\AssetInventory\App\Models;

use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    protected $table = 'mereks';

    protected $fillable = [
        'kode_merek',
        'nama_merek',
        'keterangan',
    ];
}
