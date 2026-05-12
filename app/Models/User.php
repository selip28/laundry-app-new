<?php
// app/Models/User.php

namespace App\Models;
use App\Models\Transaksi;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'password', 'role', 'cabang_id', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminPusat(): bool
    {
        return $this->role === 'admin_pusat';
    }

    public function isAdminCabang(): bool
    {
        return $this->role === 'admin_cabang';
    }
}