<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission;
use App\Models\UserFlag;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
       
    'name',
    'email',
    'password',
    'role',
    'isactive',
    'isdeleted'
];
   

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =====================
    // RELASI PERMISSION
    // =====================
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    // =====================
    // RELASI FLAG USER
    // =====================
    public function flags()
    {
        return $this->hasOne(UserFlag::class);
    }

    // =====================
    // CEK PERMISSION
    // =====================
    public function hasPermission(string $permission): bool
    {
        // admin otomatis full akses
        if ($this->role === 'admin') {
            return true;
        }

        return $this->permissions()
                    ->where('name', $permission)
                    ->exists();
    }

    // =====================
    // CEK USER AKTIF
    // =====================
    public function isActive(): bool
    {
        if (!$this->relationLoaded('flags')) {
            $this->load('flags');
        }

        return $this->flags && $this->flags->is_active === 'Y';
    }
}
