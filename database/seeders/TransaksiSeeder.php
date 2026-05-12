<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['diterima', 'diproses', 'selesai', 'diambil'];

        $customers = [
            ['nama' => 'Budi Santoso', 'hp' => '081234567890'],
            ['nama' => 'Siti Rahayu', 'hp' => '082345678901'],
            ['nama' => 'Ahmad Fauzi', 'hp' => '083456789012'],
            ['nama' => 'Dewi Kusuma', 'hp' => '084567890123'],
            ['nama' => 'Rini Wulandari', 'hp' => '085678901234'],
        ];

        for ($month = 1; $month <= 3; $month++) {
            for ($cabang_id = 1; $cabang_id <= 4; $cabang_id++) {

                $cabangKode = ['JKT', 'BDG', 'SBY', 'YGY'][$cabang_id - 1];
                $admin_id = $cabang_id + 2;

                for ($i = 0; $i < 5; $i++) {

                    $customer = $customers[array_rand($customers)];
                    $layanan_id = rand(1, 6);
                    $layanan = DB::table('layanans')->find($layanan_id);

                    $berat = rand(1, 8) + (rand(0, 9) / 10);
                    $harga = $layanan->harga_per_kg;
                    $total = $berat * $harga;

                    $tgl_masuk = Carbon::create(2024, $month, rand(1, 28), rand(8, 17), rand(0, 59));
                    $status = $statuses[min($i + 1, 3)];

                    // 🔥 KODE TRANSAKSI DINAMIS (ANTI DUPLICATE)
                    $kode = 'LDR-' . $cabangKode . '-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

                    // 🔥 INSERT & AMBIL ID
                    $transaksi_id = DB::table('transaksis')->insertGetId([
                        'kode_transaksi'   => $kode,
                        'cabang_id'        => $cabang_id,
                        'layanan_id'       => $layanan_id,
                        'user_id'          => $admin_id,
                        'nama_customer'    => $customer['nama'],
                        'no_hp'            => $customer['hp'],
                        'berat_kg'         => $berat,
                        'harga_per_kg'     => $harga,
                        'total_harga'      => $total,
                        'status'           => $status,
                        'status_bayar'     => $status === 'diambil' ? 'lunas' : 'belum_bayar',
                        'tgl_masuk'        => $tgl_masuk,
                        'estimasi_selesai' => $tgl_masuk->copy()->addHours($layanan->estimasi_jam),
                        'tgl_selesai'      => in_array($status, ['selesai', 'diambil'])
                            ? $tgl_masuk->copy()->addHours($layanan->estimasi_jam)
                            : null,
                        'tgl_diambil'      => $status === 'diambil'
                            ? $tgl_masuk->copy()->addHours($layanan->estimasi_jam + 2)
                            : null,
                        'tgl_bayar'        => $status === 'diambil'
                            ? $tgl_masuk->copy()->addHours($layanan->estimasi_jam + 2)
                            : null,
                        'catatan'          => null,
                        'created_at'       => $tgl_masuk,
                        'updated_at'       => $tgl_masuk,
                    ]);

                    // 🔥 STATUS LOG (PAKAI ID ASLI)
                    DB::table('status_logs')->insert([
                        'transaksi_id' => $transaksi_id,
                        'user_id'      => $admin_id,
                        'status'       => 'diterima',
                        'catatan'      => 'Transaksi diterima',
                        'created_at'   => $tgl_masuk,
                        'updated_at'   => $tgl_masuk,
                    ]);
                }
            }
        }
    }
}