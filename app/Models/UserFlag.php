<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFlag extends Model
{
    use HasFactory;

    protected $table = 'user_flags';

    protected $fillable = [
        'user_id',
        'is_active',
        'isdeleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
