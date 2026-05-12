@extends('layouts.app')
@section('title', 'Layanan & Harga')
@section('page-title', 'Manajemen Layanan & Harga')

@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-tags me-2"></i>Daftar Layanan</span>
        <a href="{{ route('layanan.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-plus-circle me-1"></i>Tambah Layanan
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Layanan</th>
                    <th>Harga/kg</th>
                    <th>Estimasi Selesai</th>
                    <th>Deskripsi</th>
                    <th>Dipakai</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanans as $l)
                <tr>
                    <td class="fw-semibold">{{ $l->nama }}</td>
                    <td class="text-success fw-bold">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $jam = $l->estimasi_jam;
                            if ($jam < 24) {
                                $estimasiLabel = $jam . ' jam';
                            } elseif ($jam == 24) {
                                $estimasiLabel = '1 hari';
                            } else {
                                $estimasiLabel = round($jam / 24, 1) . ' hari';
                            }
                        @endphp
                        <span class="badge bg-info text-dark">{{ $estimasiLabel }}</span>
                    </td>
                    <td><small class="text-muted">{{ $l->deskripsi ?? '—' }}</small></td>
                    <td>
                        <span class="badge bg-secondary">{{ number_format($l->transaksis_count) }}x</span>
                    </td>
                    <td>
                        @if($l->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('layanan.edit', $l->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('layanan.destroy', $l->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus layanan {{ $l->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-tags fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada layanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($layanans->hasPages())
    <div class="card-footer bg-white">{{ $layanans->links() }}</div>
    @endif
</div>
@endsection