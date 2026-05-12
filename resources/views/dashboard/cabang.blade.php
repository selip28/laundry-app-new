@extends('layouts.app')
@section('title', 'Dashboard Cabang')
@section('page-title', 'Dashboard — ' . auth()->user()->cabang->nama)

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#1565c0,#1976d2)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Transaksi Hari Ini</div>
                    <div class="value">{{ $stats['total_hari_ini'] }}</div>
                </div>
                <i class="bi bi-receipt icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#e65100,#f57c00)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Menunggu Proses</div>
                    <div class="value">{{ $stats['diterima'] }}</div>
                </div>
                <i class="bi bi-hourglass-split icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#2e7d32,#388e3c)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Pendapatan Hari Ini</div>
                    <div class="value" style="font-size:1.2rem">Rp {{ number_format($stats['pendapatan_hari'],0,',','.') }}</div>
                </div>
                <i class="bi bi-cash-coin icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card h-100" style="background:linear-gradient(135deg,#6a1b9a,#8e24aa)">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Pendapatan Bulan Ini</div>
                    <div class="value" style="font-size:1.2rem">Rp {{ number_format($stats['pendapatan_bulan'],0,',','.') }}</div>
                </div>
                <i class="bi bi-graph-up icon"></i>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-lg px-4">
            <i class="bi bi-plus-circle me-2"></i>Transaksi Baru
        </a>
        <a href="{{ route('transaksi.index') }}?status=selesai" class="btn btn-success ms-2">
            <i class="bi bi-check-circle me-2"></i>Selesai ({{ $stats['selesai'] }})
        </a>
        <a href="{{ route('transaksi.index') }}?status=diproses" class="btn btn-info ms-2 text-white">
            <i class="bi bi-arrow-clockwise me-2"></i>Diproses ({{ $stats['diproses'] }})
        </a>
    </div>
</div>

{{-- Transaksi Terbaru --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <span><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</span>
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td><code style="font-size:.8rem">{{ $t->kode_transaksi }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $t->nama_customer }}</div>
                            <small class="text-muted">{{ $t->no_hp }}</small>
                        </td>
                        <td>{{ $t->layanan->nama }}</td>
                        <td>{{ $t->berat_kg }} kg</td>
                        <td class="fw-semibold">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                        <td>
                            <span class="badge rounded-pill badge-{{ $t->status }}">{{ $t->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection