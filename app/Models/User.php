<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'nim',
        'role',
        'departemen',
        'status',
        'email',
        'password',
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

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    /**
     * Relasi untuk sesi QR yang dibuat oleh user (jika dia admin).
     */
    public function sesiKehadiransDibuat()
    {
        return $this->hasMany(SesiKehadiran::class, 'admin_id');
    }
}
