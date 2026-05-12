<?php
// database/seeders/LayananSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            ['nama' => 'Cuci & Kering', 'harga_per_kg' => 5000, 'estimasi_jam' => 24, 'deskripsi' => 'Cuci dan keringkan pakaian'],
            ['nama' => 'Cuci & Setrika', 'harga_per_kg' => 7000, 'estimasi_jam' => 48, 'deskripsi' => 'Cuci, keringkan, dan setrika pakaian'],
            ['nama' => 'Express (6 Jam)', 'harga_per_kg' => 12000, 'estimasi_jam' => 6, 'deskripsi' => 'Layanan kilat selesai dalam 6 jam'],
            ['nama' => 'Setrika Saja', 'harga_per_kg' => 4000, 'estimasi_jam' => 12, 'deskripsi' => 'Setrika pakaian yang sudah dicuci'],
            ['nama' => 'Cuci Sepatu', 'harga_per_kg' => 25000, 'estimasi_jam' => 48, 'deskripsi' => 'Cuci bersih sepatu (harga per pasang)'],
            ['nama' => 'Dry Cleaning', 'harga_per_kg' => 20000, 'estimasi_jam' => 72, 'deskripsi' => 'Dry cleaning untuk pakaian khusus'],
        ];

        foreach ($layanans as $layanan) {
            DB::table('layanans')->insert(array_merge($layanan, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}