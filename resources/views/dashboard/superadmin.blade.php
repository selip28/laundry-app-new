@extends('layouts.app')
@section('title', 'Dashboard Super Admin')
@section('page-title', 'Super Admin Panel')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1565c0,#1976d2)">
            <div class="label">Total User</div>
            <div class="value">{{ $stats['total_users'] }}</div>
            <div class="label mt-1"><i class="bi bi-people"></i></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#6a1b9a,#8e24aa)">
            <div class="label">Total Cabang</div>
            <div class="value">{{ $stats['total_cabang'] }}</div>
            <div class="label mt-1"><i class="bi bi-building"></i></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#e65100,#f57c00)">
            <div class="label">Total Layanan</div>
            <div class="value">{{ $stats['total_layanan'] }}</div>
            <div class="label mt-1"><i class="bi bi-tags"></i></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#2e7d32,#388e3c)">
            <div class="label">Total Pendapatan</div>
            <div class="value" style="font-size:1.1rem">Rp {{ number_format($stats['total_pendapatan'],0,',','.') }}</div>
            <div class="label mt-1"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header py-3"><i class="bi bi-bar-chart me-2"></i>Pendapatan 6 Bulan Terakhir</div>
            <div class="card-body"><canvas id="chartPendapatan" height="100"></canvas></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header py-3"><i class="bi bi-building me-2"></i>Performa Cabang</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($cabangTerlaris as $i => $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-3">
                        <span>
                            <span class="badge bg-primary rounded-pill me-2">{{ $i+1 }}</span>
                            {{ $c->nama }}
                        </span>
                        <span class="text-muted fw-semibold">{{ $c->transaksis_count }} trx</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Quick links --}}
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('cabang.create') }}" class="card text-decoration-none text-dark h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#e3f2fd">
                    <i class="bi bi-building-add text-primary fs-4"></i>
                </div>
                <div>
                    <div class="fw-semibold">Tambah Cabang</div>
                    <small class="text-muted">Daftarkan outlet baru</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('user.create') }}" class="card text-decoration-none text-dark h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#f3e5f5">
                    <i class="bi bi-person-plus text-purple fs-4" style="color:#8e24aa"></i>
                </div>
                <div>
                    <div class="fw-semibold">Tambah User</div>
                    <small class="text-muted">Buat akun admin baru</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('layanan.index') }}" class="card text-decoration-none text-dark h-100">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#fff3e0">
                    <i class="bi bi-tags text-warning fs-4"></i>
                </div>
                <div>
                    <div class="fw-semibold">Kelola Layanan</div>
                    <small class="text-muted">Ubah harga & layanan</small>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels: @json($grafikData['labels']),
        datasets: [{
            label: 'Pendapatan',
            data: @json($grafikData['data']),
            borderColor: '#3949ab',
            backgroundColor: 'rgba(57,73,171,.1)',
            fill: true, tension: .4, pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id').format(v) } } }
    }
    
});
</script>
@endpush
