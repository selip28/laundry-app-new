@extends('layouts.app')
@section('title', 'Manajemen Cabang')
@section('page-title', 'Manajemen Cabang')

@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-building me-2"></i>Daftar Cabang</span>
        <a href="{{ route('cabang.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-building-add me-1"></i>Tambah Cabang
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Kode</th><th>Nama Cabang</th><th>Alamat</th><th>Telepon</th><th>Transaksi</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($cabangs as $c)
                <tr>
                    <td><span class="badge bg-primary">{{ $c->kode }}</span></td>
                    <td class="fw-semibold">{{ $c->nama }}</td>
                    <td><small>{{ $c->alamat }}</small></td>
                    <td>{{ $c->telepon ?? '—' }}</td>
                    <td>{{ number_format($c->transaksis_count) }}</td>
                    <td>
                        @if($c->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cabang.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('cabang.destroy', $c->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus cabang {{ $c->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada cabang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cabangs->hasPages())
    <div class="card-footer bg-white">{{ $cabangs->links() }}</div>
    @endif
</div>
@endsection