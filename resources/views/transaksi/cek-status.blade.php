
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Laundry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 2rem 1rem;
        }

        /* ── Header ── */
        .page-header {
            text-align: center;
            color: #fff;
            margin-bottom: 2rem;
        }
        .page-header .logo {
            width: 70px; height: 70px;
            background: rgba(255,255,255,.15);
            border-radius: 20px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2.2rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }
        .page-header h2 { font-weight: 700; margin-bottom: .25rem; }
        .page-header p  { opacity: .8; font-size: .95rem; }

        /* ── Search Card ── */
        .search-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            max-width: 560px;
            margin: 0 auto 2rem;
        }
        .search-card .form-control {
            border-radius: 12px;
            padding: .75rem 1rem;
            border: 2px solid #e0e0e0;
            font-size: 1rem;
            transition: border-color .2s;
        }
        .search-card .form-control:focus {
            border-color: #3949ab;
            box-shadow: 0 0 0 .2rem rgba(57,73,171,.15);
        }
        .btn-cek {
            background: linear-gradient(135deg, #1a237e, #3949ab);
            border: none; color: #fff;
            border-radius: 12px;
            padding: .75rem 2rem;
            font-weight: 600; font-size: 1rem;
            width: 100%; margin-top: .5rem;
            transition: opacity .2s, transform .1s;
        }
        .btn-cek:hover  { opacity: .9; color: #fff; }
        .btn-cek:active { transform: scale(.98); }

        /* ── Result Card ── */
        .result-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            max-width: 620px;
            margin: 0 auto;
            overflow: hidden;
        }
        .result-header {
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .result-body { padding: 1.5rem 2rem; }

        /* ── Status Steps ── */
        .status-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 1.5rem 0;
        }
        .status-steps::before {
            content: '';
            position: absolute;
            top: 20px; left: 10%; right: 10%;
            height: 3px;
            background: #e0e0e0;
            z-index: 0;
        }
        .status-steps .progress-line {
            position: absolute;
            top: 20px; left: 10%;
            height: 3px;
            background: linear-gradient(90deg, #4caf50, #2196f3);
            z-index: 1;
            transition: width .6s ease;
        }
        .step {
            display: flex; flex-direction: column; align-items: center;
            position: relative; z-index: 2;
            flex: 1;
        }
        .step-circle {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            margin-bottom: .5rem;
            transition: background .4s, transform .3s;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }
        .step-circle.done    { background: #4caf50; color: #fff; }
        .step-circle.active  { background: #2196f3; color: #fff; transform: scale(1.15); }
        .step-circle.pending { background: #e0e0e0; color: #9e9e9e; }
        .step-label {
            font-size: .72rem; text-align: center;
            color: #666; font-weight: 500; line-height: 1.2;
        }
        .step-label.active-label { color: #1565c0; font-weight: 700; }

        /* ── Detail Grid ── */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem 1.5rem;
            margin-top: 1.25rem;
        }
        .detail-item label {
            font-size: .75rem; color: #9e9e9e;
            text-transform: uppercase; letter-spacing: .05em;
            display: block; margin-bottom: .15rem;
        }
        .detail-item .val { font-weight: 600; color: #212121; font-size: .95rem; }

        /* ── Timeline ── */
        .timeline { margin-top: 1.25rem; }
        .timeline-item {
            display: flex; gap: 1rem;
            padding-bottom: 1rem;
            position: relative;
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 15px; top: 32px;
            width: 2px; bottom: 0;
            background: #e0e0e0;
        }
        .tl-dot {
            width: 32px; height: 32px; min-width: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
        }
        .tl-content { flex: 1; }
        .tl-content .tl-status { font-weight: 600; font-size: .9rem; }
        .tl-content .tl-time   { font-size: .78rem; color: #9e9e9e; }
        .tl-content .tl-note   { font-size: .82rem; color: #666; margin-top: .15rem; }

        /* ── Badges ── */
        .badge-diterima { background:#ff9800; color:#fff; }
        .badge-diproses { background:#2196f3; color:#fff; }
        .badge-selesai  { background:#4caf50; color:#fff; }
        .badge-diambil  { background:#9e9e9e; color:#fff; }

        /* ── Alert ── */
        .alert-not-found {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            color: #fff;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            max-width: 560px;
            margin: 0 auto;
            backdrop-filter: blur(8px);
        }

        /* ── Back link ── */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            color: rgba(255,255,255,.7);
            text-decoration: none;
            font-size: .9rem;
            transition: color .2s;
        }
        .back-link a:hover { color: #fff; }

        @media (max-width: 480px) {
            .detail-grid { grid-template-columns: 1fr; }
            .step-label  { font-size: .65rem; }
            .result-body { padding: 1.25rem; }
        }
    </style>
</head>
<body>
    

<div class="page-header">
    <div class="logo"><i class="bi bi-basket2-fill"></i></div>
    <h2>Cek Status Laundry</h2>
    <p>Masukkan kode transaksi atau nomor HP untuk melacak laundry Anda</p>
</div>

{{-- Form Pencarian --}}
<div class="search-card">
    <form action="{{ route('cek-status.post') }}" method="POST">
        @csrf
        <label class="form-label fw-semibold text-dark">Kode Transaksi / Nomor HP</label>
        <input
            type="text"
            name="kode"
            class="form-control @error('kode') is-invalid @enderror"
            placeholder="Contoh: LDR-JKT-20240301-0001 atau 08xxxxxxxxxx"
            value="{{ request('kode') ?? ($transaksi?->kode_transaksi ?? '') }}"
            autofocus
        >
        @error('kode')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-cek mt-3">
            <i class="bi bi-search me-2"></i>Lacak Laundry Saya
        </button>
    </form>
</div>

{{-- Error not found --}}
@if($error)
<div class="alert-not-found text-center">
    <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
    <strong>Data Tidak Ditemukan</strong>
    <p class="mb-0 mt-1" style="opacity:.85;font-size:.9rem">{{ $error }}</p>
</div>
@endif

{{-- Hasil --}}
@if($transaksi)
@php
    $steps = [
        'diterima' => ['icon' => 'bi-inbox',          'label' => 'Diterima'],
        'diproses' => ['icon' => 'bi-arrow-clockwise','label' => 'Diproses'],
        'selesai'  => ['icon' => 'bi-check-circle',   'label' => 'Selesai'],
        'diambil'  => ['icon' => 'bi-bag-check',      'label' => 'Diambil'],
    ];
    $stepKeys   = array_keys($steps);
    $currentIdx = array_search($transaksi->status, $stepKeys);
    $progressPct = ($currentIdx / (count($stepKeys) - 1)) * 80;
@endphp

<div class="result-card">
    {{-- Header --}}
    <div class="result-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <div style="font-size:.78rem;color:#9e9e9e;letter-spacing:.05em;text-transform:uppercase">Kode Transaksi</div>
                <div class="fw-bold" style="font-size:1.05rem;font-family:monospace">{{ $transaksi->kode_transaksi }}</div>
            </div>
            <span class="badge rounded-pill px-3 py-2 badge-{{ $transaksi->status }}" style="font-size:.85rem">
                {{ $transaksi->status_label }}
            </span>
        </div>

        {{-- Status Steps --}}
        <div class="status-steps">
            <div class="progress-line" style="width: {{ $progressPct }}%"></div>
            @foreach($steps as $key => $step)
            @php
                $idx = array_search($key, $stepKeys);
                $circleClass = $idx < $currentIdx ? 'done' : ($idx === $currentIdx ? 'active' : 'pending');
                $labelClass  = $idx === $currentIdx ? 'active-label' : '';
            @endphp
            <div class="step">
                <div class="step-circle {{ $circleClass }}">
                    @if($idx < $currentIdx)
                        <i class="bi bi-check-lg"></i>
                    @else
                        <i class="{{ $step['icon'] }}"></i>
                    @endif
                </div>
                <div class="step-label {{ $labelClass }}">{{ $step['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="result-body">
        {{-- Info Customer & Laundry --}}
        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Customer</label>
                <div class="val">{{ $transaksi->nama_customer }}</div>
            </div>
            <div class="detail-item">
                <label>No HP</label>
                <div class="val">{{ $transaksi->no_hp }}</div>
            </div>
            <div class="detail-item">
                <label>Cabang</label>
                <div class="val">{{ $transaksi->cabang->nama }}</div>
            </div>
            <div class="detail-item">
                <label>Layanan</label>
                <div class="val">{{ $transaksi->layanan->nama }}</div>
            </div>
            <div class="detail-item">
                <label>Berat</label>
                <div class="val">{{ $transaksi->berat_kg }} kg</div>
            </div>
            <div class="detail-item">
                <label>Total Biaya</label>
                <div class="val text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
            </div>
            <div class="detail-item">
                <label>Tanggal Masuk</label>
                <div class="val">{{ $transaksi->tgl_masuk->format('d M Y, H:i') }}</div>
            </div>
            <div class="detail-item">
                <label>Estimasi Selesai</label>
                <div class="val">
                    @if($transaksi->estimasi_selesai)
                        {{ $transaksi->estimasi_selesai->format('d M Y, H:i') }}
                    @else
                        —
                    @endif
                </div>
            </div>
            @if($transaksi->tgl_selesai)
            <div class="detail-item">
                <label>Tanggal Selesai</label>
                <div class="val text-success">{{ $transaksi->tgl_selesai->format('d M Y, H:i') }}</div>
            </div>
            @endif
            @if($transaksi->tgl_diambil)
            <div class="detail-item">
                <label>Tanggal Diambil</label>
                <div class="val">{{ $transaksi->tgl_diambil->format('d M Y, H:i') }}</div>
            </div>
            @endif
            <div class="detail-item">
                <label>Status Pembayaran</label>
                <div class="val">
                    @if($transaksi->status_bayar === 'lunas')
                        <span class="badge bg-success">✓ Lunas</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>

        @if($transaksi->catatan)
        <div class="mt-3 p-3 rounded-3" style="background:#f8f9fa;font-size:.88rem">
            <i class="bi bi-chat-left-text me-2 text-muted"></i>
            <strong>Catatan:</strong> {{ $transaksi->catatan }}
        </div>
        @endif

        {{-- Pesan status aktif --}}
        <div class="mt-3 p-3 rounded-3
            @if($transaksi->status==='diterima') bg-warning bg-opacity-10 border border-warning
            @elseif($transaksi->status==='diproses') bg-info bg-opacity-10 border border-info
            @elseif($transaksi->status==='selesai') bg-success bg-opacity-10 border border-success
            @else bg-secondary bg-opacity-10 border border-secondary @endif"
            style="font-size:.88rem">
            @if($transaksi->status === 'diterima')
                <i class="bi bi-clock-history me-2 text-warning"></i>
                <strong>Laundry Anda sedang antri untuk diproses.</strong> Estimasi selesai: <strong>{{ $transaksi->estimasi_selesai?->format('d M Y, H:i') }}</strong>
            @elseif($transaksi->status === 'diproses')
                <i class="bi bi-arrow-clockwise me-2 text-info"></i>
                <strong>Laundry Anda sedang dalam proses pencucian.</strong> Harap tunggu hingga selesai.
            @elseif($transaksi->status === 'selesai')
                <i class="bi bi-check-circle me-2 text-success"></i>
                <strong>Laundry Anda sudah selesai!</strong> Silakan ambil di <strong>{{ $transaksi->cabang->nama }}</strong>.
                @if($transaksi->status_bayar === 'belum_bayar')
                    Jangan lupa membawa uang <strong>Rp {{ number_format($transaksi->total_harga,0,',','.') }}</strong> untuk pembayaran.
                @endif
            @else
                <i class="bi bi-bag-check me-2 text-secondary"></i>
                <strong>Laundry sudah diambil.</strong> Terima kasih telah menggunakan layanan kami! 🙏
            @endif
        </div>

        {{-- Riwayat Status --}}
        @if($transaksi->statusLogs->count() > 0)
        <div class="mt-4">
            <div class="fw-semibold mb-3" style="font-size:.88rem;color:#666;text-transform:uppercase;letter-spacing:.05em">
                <i class="bi bi-clock-history me-1"></i> Riwayat Status
            </div>
            <div class="timeline">
                @foreach($transaksi->statusLogs as $log)
                @php
                    $dotColors = ['diterima'=>'#ff9800','diproses'=>'#2196f3','selesai'=>'#4caf50','diambil'=>'#9e9e9e'];
                    $dotIcons  = ['diterima'=>'bi-inbox','diproses'=>'bi-arrow-clockwise','selesai'=>'bi-check-circle','diambil'=>'bi-bag-check'];
                    $dotColor  = $dotColors[$log->status] ?? '#9e9e9e';
                    $dotIcon   = $dotIcons[$log->status]  ?? 'bi-circle';
                @endphp
                <div class="timeline-item">
                    <div class="tl-dot" style="background:{{ $dotColor }}1a;color:{{ $dotColor }}">
                        <i class="bi {{ $dotIcon }}"></i>
                    </div>
                    <div class="tl-content">
                        <div class="tl-status">{{ ucfirst($log->status) }}</div>
                        <div class="tl-time"><i class="bi bi-calendar3 me-1"></i>{{ $log->created_at->format('d M Y, H:i') }}</div>
                        @if($log->catatan)
                        <div class="tl-note">{{ $log->catatan }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Cek lagi --}}
        <div class="text-center mt-4 pt-3 border-top">
            <a href="{{ route('cek-status') }}" class="btn btn-outline-primary btn-sm px-4">
                <i class="bi bi-arrow-left me-1"></i> Cek Transaksi Lain
            </a>
        </div>
    </div>
</div>
@endif

<div class="back-link">
    <a href="{{ route('login') }}"><i class="bi bi-lock me-1"></i>Login Admin</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>