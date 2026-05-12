@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row g-4">
    {{-- Info Utama --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>{{ $transaksi->kode_transaksi }}</span>
                <div class="d-flex gap-2">
                    <a href="{{ route('transaksi.nota', $transaksi->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="bi bi-printer me-1"></i>Cetak Nota
                    </a>
                    <span class="badge rounded-pill badge-{{ $transaksi->status }} px-3 py-2">{{ $transaksi->status_label }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Nama Customer</label>
                        <div class="fw-semibold">{{ $transaksi->nama_customer }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">No HP</label>
                        <div class="fw-semibold">{{ $transaksi->no_hp }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Cabang</label>
                        <div class="fw-semibold">{{ $transaksi->cabang->nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Layanan</label>
                        <div class="fw-semibold">{{ $transaksi->layanan->nama }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted" style="font-size:.8rem">Berat</label>
                        <div class="fw-semibold">{{ $transaksi->berat_kg }} kg</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted" style="font-size:.8rem">Harga/kg</label>
                        <div class="fw-semibold">Rp {{ number_format($transaksi->harga_per_kg,0,',','.') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted" style="font-size:.8rem">Total</label>
                        <div class="fw-bold text-primary fs-5">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Tanggal Masuk</label>
                        <div>{{ $transaksi->tgl_masuk->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Estimasi Selesai</label>
                        <div>{{ $transaksi->estimasi_selesai?->format('d M Y, H:i') ?? '-' }}</div>
                    </div>
                    @if($transaksi->catatan)
                    <div class="col-12">
                        <label class="text-muted" style="font-size:.8rem">Catatan</label>
                        <div>{{ $transaksi->catatan }}</div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <label class="text-muted" style="font-size:.8rem">Status Bayar</label>
                        <div>
                            @if($transaksi->status_bayar === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                                <small class="text-muted ms-1">{{ $transaksi->tgl_bayar?->format('d/m/Y H:i') }}</small>
                            @else
                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Status (Admin Cabang) --}}
        @if(auth()->user()->isAdminCabang() && $transaksi->status !== 'diambil')
        <div class="card">
            <div class="card-header py-3"><i class="bi bi-arrow-up-circle me-2"></i>Update Status</div>
            <div class="card-body">
                <form action="{{ route('transaksi.updateStatus', $transaksi->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-5">
                            <select name="status" class="form-select" required>
                                @php
                                    $statusNext = [
                                        'diterima' => ['diproses' => 'Sedang Diproses'],
                                        'diproses' => ['selesai'  => 'Selesai'],
                                        'selesai'  => ['diambil'  => 'Sudah Diambil'],
                                    ][$transaksi->status] ?? [];
                                @endphp
                                <option value="">— Pilih Status Baru —</option>
                                @foreach($statusNext as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="catatan" class="form-control" placeholder="Catatan (opsional)">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100"><i class="bi bi-check2"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Riwayat Status --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-3"><i class="bi bi-clock-history me-2"></i>Riwayat Status</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($transaksi->statusLogs as $log)
                    <li class="list-group-item px-3 py-3">
                        <div class="d-flex justify-content-between">
                            <span class="badge rounded-pill badge-{{ $log->status }}">
                                {{ ucfirst($log->status) }}
                            </span>
                            <small class="text-muted">{{ $log->created_at->format('d/m H:i') }}</small>
                        </div>
                        @if($log->catatan)
                        <small class="text-muted d-block mt-1">{{ $log->catatan }}</small>
                        @endif
                        <small class="text-muted">oleh: {{ $log->user->nama }}</small>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection