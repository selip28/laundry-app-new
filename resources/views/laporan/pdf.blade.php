<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laundry — {{ $namaBulan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2   { font-size: 16px; margin: 0; }
        h4   { font-size: 13px; margin: 0; }
        .header { text-align: center; border-bottom: 2px solid #1a237e; padding-bottom: 10px; margin-bottom: 14px; }
        .summary { display: flex; gap: 10px; margin-bottom: 14px; }
        .sum-box { flex: 1; background: #e8eaf6; border-radius: 6px; padding: 8px 12px; }
        .sum-box .val { font-size: 14px; font-weight: bold; color: #1a237e; }
        .sum-box .lbl { font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a237e; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) td { background: #f5f5f5; }
        .badge {
            display: inline-block; padding: 2px 7px; border-radius: 10px;
            font-size: 9px; font-weight: bold;
        }
        .badge-diterima { background:#fff3e0; color:#e65100; }
        .badge-diproses { background:#e3f2fd; color:#1565c0; }
        .badge-selesai  { background:#e8f5e9; color:#2e7d32; }
        .badge-diambil  { background:#f5f5f5; color:#616161; }
        .footer { margin-top: 20px; font-size: 10px; color: #777; text-align: right; }
    </style>
</head>
<body>

<div class="header">
    <h2> LAPORAN TRANSAKSI LAUNDRY</h2>
    <h4>{{ $cabang ? $cabang->nama : 'Semua Cabang' }} — {{ $namaBulan }}</h4>
    <p style="font-size:10px; color:#777; margin-top:4px">
        Dicetak: {{ now()->format('d M Y, H:i') }}
    </p>
</div>

<div class="summary">
    <div class="sum-box">
        <div class="lbl">Total Transaksi</div>
        <div class="val">{{ number_format($summary['total_transaksi']) }}</div>
    </div>
    <div class="sum-box">
        <div class="lbl">Total Pendapatan (Lunas)</div>
        <div class="val">Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}</div>
    </div>
    <div class="sum-box">
        <div class="lbl">Total Berat</div>
        <div class="val">{{ number_format($summary['total_berat'],1) }} kg</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Transaksi</th>
            <th>Customer</th>
            @if(!$cabang)<th>Cabang</th>@endif
            <th>Layanan</th>
            <th>Berat</th>
            <th>Total</th>
            <th>Tgl Masuk</th>
            <th>Status</th>
            <th>Bayar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksis as $i => $t)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $t->kode_transaksi }}</td>
            <td>{{ $t->nama_customer }}<br><span style="color:#888">{{ $t->no_hp }}</span></td>
            @if(!$cabang)<td>{{ $t->cabang->nama ?? '-' }}</td>@endif
            <td>{{ $t->layanan->nama ?? '-' }}</td>
            <td>{{ $t->berat_kg }} kg</td>
            <td>Rp {{ number_format($t->total_harga,0,',','.') }}</td>
            <td>{{ $t->tgl_masuk->format('d/m/Y') }}</td>
            <td><span class="badge badge-{{ $t->status }}">{{ $t->status_label }}</span></td>
            <td>{{ $t->status_bayar === 'lunas' ? 'Lunas' : 'Belum' }}</td>
        </tr>
        @empty
        <tr><td colspan="10" style="text-align:center; padding:20px; color:#999">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    LaundryApp © {{ date('Y') }} — Laporan ini dibuat secara otomatis oleh sistem
</div>

</body>
</html>