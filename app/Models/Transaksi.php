<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'kode_transaksi', 'cabang_id', 'layanan_id', 'user_id',
        'nama_customer', 'no_hp', 'catatan',
        'berat_kg', 'harga_per_kg', 'total_harga',
        'status', 'status_bayar',
        'tgl_masuk', 'estimasi_selesai', 'tgl_selesai', 'tgl_diambil', 'tgl_bayar',
    ];

    protected $casts = [
        'tgl_masuk'        => 'datetime',
        'estimasi_selesai' => 'datetime',
        'tgl_selesai'      => 'datetime',
        'tgl_diambil'      => 'datetime',
        'tgl_bayar'        => 'datetime',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class)->orderBy('created_at', 'desc');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'badge-warning',
            'diproses' => 'badge-info',
            'selesai'  => 'badge-success',
            'diambil'  => 'badge-secondary',
            default    => 'badge-light',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'Diterima',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Selesai',
            'diambil'  => 'Sudah Diambil',
            default    => '-',
        };
    }

    public static function generateKode(string $cabangKode): string
    {
        $prefix = 'LDR-' . $cabangKode . '-' . now()->format('Ymd') . '-';
        $last = self::where('kode_transaksi', 'like', $prefix . '%')
            ->orderByDesc('kode_transaksi')
            ->first();
        $seq = $last ? ((int) substr($last->kode_transaksi, -4)) + 1 : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}