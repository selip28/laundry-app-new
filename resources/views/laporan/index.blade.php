@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Transaksi')

@section('content')
{{-- Filter --}}
<div class="card mb-4">
    <div class="card-header py-3"><i class="bi bi-funnel me-2"></i>Filter Laporan</div>
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label fw-semibold">Bulan</label>
                <select name="bulan" class="form-select">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected':'' }}>
                        {{ \Carbon\Carbon::create(null,$m)->translatedFormat('F') }}
                    </option>
                    @endfor
                </select> 
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select">
                    @for($y = date('Y'); $y >= 2023; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected':'' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            @if(!auth()->user()->isAdminCabang())
            <div class="col-md-3">
                <label class="form-label fw-semibold">Cabang</label>
                <select name="cabang_id" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach($cabangs as $c)
                    <option value="{{ $c->id }}" {{ $cabangId == $c->id ? 'selected':'' }}>{{ $c->nama }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-auto">
                <button class="btn btn-primary"><i class="bi bi-search me-1"></i>Tampilkan</button>
                <a href="{{ route('laporan.pdf', request()->all()) }}" class="btn btn-danger ms-2" target="_blank">
                    <i class="bi bi-file-pdf me-1"></i>Export PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#1565c0,#1976d2)">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ number_format($summary['total_transaksi']) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#2e7d32,#388e3c)">
            <div class="label">Total Pendapatan</div>
            <div class="value" style="font-size:1.2rem">Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#6a1b9a,#8e24aa)">
            <div class="label">Total Berat</div>
            <div class="value">{{ number_format($summary['total_berat'],1) }} kg</div>
        </div>
    </div>
</div>

{{-- Per Cabang (pusat/superadmin) --}}
@if(!auth()->user()->isAdminCabang() && $perCabang->count())
<div class="card mb-4">
    <div class="card-header py-3"><i class="bi bi-building me-2"></i>Ringkasan Per Cabang</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Cabang</th><th>Total Transaksi</th><th>Total Pendapatan</th></tr>
            </thead>
            <tbody>
                @foreach($perCabang as $pc)
                <tr>
                    <td class="fw-semibold">{{ $pc->cabang->nama ?? '-' }}</td>
                    <td>{{ number_format($pc->total_trx) }}</td>
                    <td class="fw-semibold text-success">Rp {{ number_format($pc->total_pendapatan,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Tabel Detail --}}
<div class="card">
    <div class="card-header py-3"><i class="bi bi-table me-2"></i>Detail Transaksi</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        @if(!auth()->user()->isAdminCabang())<th>Cabang</th>@endif
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td><code style="font-size:.8rem">{{ $t->kode_transaksi }}</code></td>
                        <td>
                            <div>{{ $t->nama_customer }}</div>
                            <small class="text-muted">{{ $t->no_hp }}</small>
                        </td>
                        @if(!auth()->user()->isAdminCabang())
                        <td><small>{{ $t->cabang->nama ?? '-' }}</small></td>
                        @endif
                        <td>{{ $t->layanan->nama ?? '-' }}</td>
                        <td>{{ $t->berat_kg }} kg</td>
                        <td class="fw-semibold">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                        <td><small>{{ $t->tgl_masuk->format('d/m/Y') }}</small></td>
                        <td><span class="badge rounded-pill badge-{{ $t->status }}">{{ $t->status_label }}</span></td>
                        <td>
                            @if($t->status_bayar === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">Tidak ada data untuk periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transaksis->hasPages())
    <div class="card-footer bg-white">{{ $transaksis->links() }}</div>
    @endif
</div>
@endsection