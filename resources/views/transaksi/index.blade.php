@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')

@section('content')
<div class="card">
    <div class="card-header py-3">
        <div class="row align-items-center g-2">
            <div class="col-md-8">
                <form class="row g-2" method="GET">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Kode / Nama / No HP" value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="diterima"  {{ request('status')=='diterima'  ? 'selected':'' }}>Diterima</option>
                            <option value="diproses"  {{ request('status')=='diproses'  ? 'selected':'' }}>Diproses</option>
                            <option value="selesai"   {{ request('status')=='selesai'   ? 'selected':'' }}>Selesai</option>
                            <option value="diambil"   {{ request('status')=='diambil'   ? 'selected':'' }}>Diambil</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
            @if(auth()->user()->isAdminCabang())
            <div class="col-md-4 text-md-end">
                <a href="{{ route('transaksi.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle me-1"></i>Transaksi Baru
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Customer</th>
                        @if(!auth()->user()->isAdminCabang())<th>Cabang</th>@endif
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th>Bayar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td><code style="font-size:.8rem">{{ $t->kode_transaksi }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $t->nama_customer }}</div>
                            <small class="text-muted">{{ $t->no_hp }}</small>
                        </td>
                        @if(!auth()->user()->isAdminCabang())
                        <td><small>{{ $t->cabang->nama ?? '-' }}</small></td>
                        @endif
                        <td>{{ $t->layanan->nama ?? '-' }}</td>
                        <td>{{ $t->berat_kg }} kg</td>
                        <td class="fw-semibold">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
                        <td><small>{{ $t->tgl_masuk->format('d/m/Y H:i') }}</small></td>
                        <td>
                            <span class="badge rounded-pill badge-{{ $t->status }}">{{ $t->status_label }}</span>
                        </td>
                        <td>
                            @if($t->status_bayar === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada data transaksi
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transaksis->hasPages())
    <div class="card-footer">{{ $transaksis->links() }}</div>
    @endif
</div>
@endsection