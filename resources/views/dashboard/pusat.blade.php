@extends('layouts.app')
@section('title', 'Dashboard Pusat')
@section('page-title', 'Monitoring Pusat')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1565c0,#1976d2)">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ number_format($stats['total_transaksi']) }}</div>
            <div class="label mt-1"><i class="bi bi-receipt"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#2e7d32,#388e3c)">
            <div class="label">Total Pendapatan</div>
            <div class="value" style="font-size:1.2rem">Rp {{ number_format($stats['total_pendapatan'],0,',','.') }}</div>
            <div class="label mt-1"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#6a1b9a,#8e24aa)">
            <div class="label">Jumlah Cabang Aktif</div>
            <div class="value">{{ $stats['total_cabang'] }}</div>
            <div class="label mt-1"><i class="bi bi-building"></i></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#e65100,#f57c00)">
            <div class="label">Transaksi Bulan Ini</div>
            <div class="value">{{ number_format($stats['transaksi_bulan']) }}</div>
            <div class="label mt-1"><i class="bi bi-calendar-check"></i></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Grafik Pendapatan --}}
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header py-3"><i class="bi bi-bar-chart me-2"></i>Pendapatan 6 Bulan Terakhir</div>
            <div class="card-body">
                <canvas id="chartPendapatan" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Layanan Terlaris --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header py-3"><i class="bi bi-trophy me-2"></i>Layanan Terlaris</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($layananTerlaris as $i => $l)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-3">
                        <span>
                            <span class="badge bg-primary rounded-pill me-2">{{ $i+1 }}</span>
                            {{ $l->layanan->nama ?? '-' }}
                        </span>
                        <span class="fw-semibold text-muted">{{ $l->total }}x</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Performa Per Cabang --}}
<div class="card mb-4">
    <div class="card-header py-3"><i class="bi bi-building me-2"></i>Performa Per Cabang</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Cabang</th>
                        <th>Total Transaksi</th>
                        <th>Pendapatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cabangTerlaris as $c)
                    <tr>
                        <td class="fw-semibold">{{ $c->cabang->nama ?? '-' }}</td>
                        <td>{{ number_format($c->total) }}</td>
                        <td>Rp {{ number_format($c->pendapatan,0,',','.') }}</td>
                        <td>
                            <a href="{{ route('laporan.index') }}?cabang_id={{ $c->cabang_id }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i>Laporan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('chartPendapatan');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($grafikData['labels']),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($grafikData['data']),
            backgroundColor: 'rgba(57,73,171,.7)',
            borderColor: 'rgba(57,73,171,1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                ticks: {
                    callback: v => 'Rp ' + new Intl.NumberFormat('id').format(v)
                }
            }
        }
    }
});
</script>
@endpush