<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    public function run(): void
    {
        $cabangs = [
            [
                'nama' => 'Cabang Jakarta Pusat',
                'kode' => 'JKT',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta Pusat',
                'telepon' => '021-12345678',
            ],
            [
                'nama' => 'Cabang Bandung',
                'kode' => 'BDG',
                'alamat' => 'Jl. Asia Afrika No. 5, Bandung',
                'telepon' => '022-87654321',
            ],
            [
                'nama' => 'Cabang Surabaya',
                'kode' => 'SBY',
                'alamat' => 'Jl. Pemuda No. 20, Surabaya',
                'telepon' => '031-11223344',
            ],
            [
                'nama' => 'Cabang Yogyakarta',
                'kode' => 'YGY',
                'alamat' => 'Jl. Malioboro No. 15, Yogyakarta',
                'telepon' => '0274-556677',
            ],
        ];

        foreach ($cabangs as $cabang) {
            DB::table('cabangs')->updateOrInsert(
                ['kode' => $cabang['kode']], // kunci unik
                array_merge($cabang, [
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }
    }
}