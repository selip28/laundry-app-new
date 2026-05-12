<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // WAJIB DITAMBAHKAN
    protected $table = 'layanan';

    protected $fillable = [
        'nama',
        'harga_per_kg',
        'estimasi_jam',
        'deskripsi',
        'is_active',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}