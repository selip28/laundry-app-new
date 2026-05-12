<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laundry App') — {{ config('app.name') }}</title>
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --sidebar-width: 260px; }
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
            position: fixed; top: 0; left: 0; z-index: 100;
            transition: transform .3s ease;
            display: flex; flex-direction: column;
        }
        #sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            color: #fff;
        }
        #sidebar .brand h5 { margin: 0; font-weight: 700; font-size: 1.1rem; }
        #sidebar .brand small { opacity: .65; font-size: .75rem; }
        #sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: .6rem 1.5rem;
            border-radius: 0;
            display: flex; align-items: center; gap: .65rem;
            font-size: .9rem;
            transition: background .2s, color .2s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255,255,255,.12);
            color: #fff;
        }
        #sidebar .nav-section {
            padding: .5rem 1.5rem .25rem;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255,255,255,.4);
            margin-top: .5rem;
        }
        #sidebar .user-box {
            margin-top: auto;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.8);
            font-size: .85rem;
        }

        /* ── Main ── */
        #main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        #topbar {
            background: #fff;
            padding: .75rem 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        #content { padding: 1.5rem; flex: 1; }

        /* ── Cards ── */
        .stat-card {
            border: none; border-radius: 12px;
            padding: 1.25rem 1.5rem;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,.1);
        }
        .stat-card .icon { font-size: 2rem; opacity: .8; }
        .stat-card .value { font-size: 1.6rem; font-weight: 700; }
        .stat-card .label { font-size: .82rem; opacity: .85; }

        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
        .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; font-weight: 600; border-radius: 12px 12px 0 0 !important; }

        /* ── Status Badge ── */
        .badge-diterima  { background: #ff9800; color:#fff; }
        .badge-diproses  { background: #2196f3; color:#fff; }
        .badge-selesai   { background: #4caf50; color:#fff; }
        .badge-diambil   { background: #9e9e9e; color:#fff; }

        /* ── Table ── */
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; color: #666; border-top: none; }
        .table td { vertical-align: middle; font-size: .9rem; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<nav id="sidebar">
    <div class="brand">
        <h5><i class="bi bi-basket2-fill me-2"></i>LaundryApp</h5>
        <small>Sistem Manajemen Laundry</small>
    </div>

    <ul class="nav flex-column pt-2">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        @if(auth()->user()->isAdminCabang())
        <div class="nav-section">Transaksi</div>
        <li class="nav-item">
            <a href="{{ route('transaksi.create') }}" class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Transaksi Baru
            </a>
        </li>
        @endif

        @if(!auth()->user()->isSuperAdmin() || auth()->user()->isSuperAdmin())
        <li class="nav-item">
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.index','transaksi.show') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> Daftar Transaksi
            </a>
        </li>
        @endif

        <div class="nav-section">Laporan</div>
        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
        </li>

        @if(auth()->user()->isSuperAdmin())
        <div class="nav-section">Master Data</div>
        <li class="nav-item">
            <a href="{{ route('cabang.index') }}" class="nav-link {{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Cabang
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('layanan.index') }}" class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Layanan & Harga
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        </li>
        @endif
    </ul>

    <div class="user-box">
        <div class="fw-semibold text-white">{{ auth()->user()->nama }}</div>
        <div class="text-white-50" style="font-size:.75rem">
            @php
                $roleLabel = match(auth()->user()->role) {
                    'superadmin'   => 'Super Admin',
                    'admin_pusat'  => 'Admin Pusat',
                    'admin_cabang' => 'Admin Cabang',
                    default => '-',
                };
            @endphp
            {{ $roleLabel }}
            @if(auth()->user()->cabang)
                — {{ auth()->user()->cabang->nama }}
            @endif
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-left me-1"></i>Logout</button>
        </form>
    </div>
</nav>

{{-- Main --}}
<div id="main">
    <div id="topbar">
        <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list fs-5"></i>
        </button>
        <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        <a href="{{ route('cek-status') }}" class="btn btn-sm btn-outline-primary" target="_blank">
            <i class="bi bi-search me-1"></i>Cek Status
        </a>
    </div>

    <div id="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>