<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    // WAJIB
    protected $table = 'cabang';

    protected $fillable = [
        'nama',
        'kode',
        'alamat',
        'telepon',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}