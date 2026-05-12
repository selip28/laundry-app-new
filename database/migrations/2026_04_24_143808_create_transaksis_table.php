<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique(); // LDR-JKT-20240101-0001
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('layanan_id')->constrained('layanans');
            $table->foreignId('user_id')->constrained('users'); // admin yang input
            
            // Data Customer
            $table->string('nama_customer');
            $table->string('no_hp');
            $table->text('catatan')->nullable();
            
            // Detail Transaksi
            $table->decimal('berat_kg', 8, 2);
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('total_harga', 10, 2);
            
            // Status & Waktu
            $table->enum('status', ['diterima', 'diproses', 'selesai', 'diambil'])->default('diterima');
            $table->timestamp('tgl_masuk');
            $table->timestamp('estimasi_selesai')->nullable();
            $table->timestamp('tgl_selesai')->nullable();
            $table->timestamp('tgl_diambil')->nullable();
            
            // Pembayaran
            $table->enum('status_bayar', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->timestamp('tgl_bayar')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};