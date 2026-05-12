<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        DB::table('users')->updateOrInsert(
            ['username' => 'superadmin'],
            [
                'nama'       => 'Super Administrator',
                'password'   => Hash::make('password'),
                'role'       => 'superadmin',
                'cabang_id'  => null,
                'is_active'  => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Admin Pusat
        DB::table('users')->updateOrInsert(
            ['username' => 'adminpusat'],
            [
                'nama'       => 'Admin Pusat',
                'password'   => Hash::make('password'),
                'role'       => 'admin_pusat',
                'cabang_id'  => null,
                'is_active'  => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Admin Cabang
        $cabangAdmins = [
            ['nama' => 'Admin Jakarta',   'username' => 'cabang_jkt', 'cabang_id' => 1],
            ['nama' => 'Admin Bandung',   'username' => 'cabang_bdg', 'cabang_id' => 2],
            ['nama' => 'Admin Surabaya',  'username' => 'cabang_sby', 'cabang_id' => 3],
            ['nama' => 'Admin Yogyakarta','username' => 'cabang_ygy', 'cabang_id' => 4],
        ];

        foreach ($cabangAdmins as $admin) {
            DB::table('users')->updateOrInsert(
                ['username' => $admin['username']], // kunci unik
                [
                    'nama'       => $admin['nama'],
                    'password'   => Hash::make('password'),
                    'role'       => 'admin_cabang',
                    'cabang_id'  => $admin['cabang_id'],
                    'is_active'  => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}