<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota — {{ $transaksi->kode_transaksi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; background: #f5f5f5; }
        .nota {
            width: 300px; margin: 20px auto; background: #fff;
            padding: 16px; border: 1px dashed #999;
        }
        .header { text-align: center; border-bottom: 1px dashed #999; padding-bottom: 8px; margin-bottom: 8px; }
        .header h2 { font-size: 16px; font-weight: bold; }
        .header p  { font-size: 11px; color: #555; }
        .row-data  { display: flex; justify-content: space-between; margin: 3px 0; }
        .row-data .label { color: #555; }
        .divider { border-top: 1px dashed #999; margin: 8px 0; }
        .total { display: flex; justify-content: space-between; font-weight: bold; font-size: 14px; }
        .status-box {
            text-align: center; margin: 10px 0; padding: 6px;
            border: 1px solid #333; font-weight: bold; font-size: 13px;
        }
        .footer { text-align: center; font-size: 10px; color: #777; margin-top: 10px; }
        .kode { text-align: center; font-size: 13px; font-weight: bold; letter-spacing: 1px; margin: 6px 0; }
        @media print {
            body { background: #fff; }
            .nota { border: none; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="nota">
    <div class="header">
        <h2>🧺 LAUNDRY RIAN</h2>
        <p>{{ $transaksi->cabang->nama }}</p>
        <p>{{ $transaksi->cabang->alamat }}</p>
        <p>Telp: {{ $transaksi->cabang->telepon ?? '-' }}</p>
    </div>

    <div class="kode">{{ $transaksi->kode_transaksi }}</div>
    <div class="divider"></div>

    <div class="row-data">
        <span class="label">Tanggal</span>
        <span>{{ $transaksi->tgl_masuk->format('d/m/Y H:i') }}</span>
    </div>
    <div class="row-data">
        <span class="label">Customer</span>
        <span>{{ $transaksi->nama_customer }}</span>
    </div>
    <div class="row-data">
        <span class="label">No HP</span>
        <span>{{ $transaksi->no_hp }}</span>
    </div>

    <div class="divider"></div>

    <div class="row-data">
        <span class="label">Layanan</span>
        <span>{{ $transaksi->layanan->nama }}</span>
    </div>
    <div class="row-data">
        <span class="label">Berat</span>
        <span>{{ $transaksi->berat_kg }} kg</span>
    </div>
    <div class="row-data">
        <span class="label">Harga/kg</span>
        <span>Rp {{ number_format($transaksi->harga_per_kg, 0, ',', '.') }}</span>
    </div>

    <div class="divider"></div>

    <div class="total">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
    </div>

    <div class="divider"></div>

    <div class="row-data">
        <span class="label">Status Bayar</span>
        <span>{{ $transaksi->status_bayar === 'lunas' ? '✅ LUNAS' : '⏳ BELUM BAYAR' }}</span>
    </div>
    <div class="row-data">
        <span class="label">Est. Selesai</span>
        <span>{{ $transaksi->estimasi_selesai?->format('d/m/Y H:i') ?? '-' }}</span>
    </div>

    @if($transaksi->catatan)
    <div class="divider"></div>
    <div><span class="label">Catatan:</span> {{ $transaksi->catatan }}</div>
    @endif

    <div class="divider"></div>

    <div class="status-box">STATUS: {{ strtoupper($transaksi->status_label) }}</div>

    <div class="footer">
        <p>Simpan nota ini untuk pengambilan</p>
        <p>Cek status: domainlaundry.com/cek-status</p>
        <p>Masukkan kode: <strong>{{ $transaksi->kode_transaksi }}</strong></p>
        <p style="margin-top:6px">Terima kasih telah menggunakan layanan kami!</p>
    </div>
</div>

<div class="no-print" style="text-align:center; margin: 16px;">
    
    <button onclick="window.print()"
        style="padding:8px 24px; background:#1a237e; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:14px;">
        🖨️ Cetak Nota
    </button>

    <a href="{{ route('dashboard') }}"
        style="padding:8px 24px; background:#555; color:#fff; border:none; border-radius:6px; cursor:pointer; font-size:14px; margin-left:8px; text-decoration:none; display:inline-block;">
        Tutup
    </a>

</div>

</body>
</html>