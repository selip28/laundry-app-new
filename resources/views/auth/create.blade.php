@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('page-title', 'Input Transaksi Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card">
    <div class="card-header py-3"><i class="bi bi-plus-circle me-2"></i>Form Transaksi Baru</div>
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
            @csrf

            <h6 class="text-muted mb-3 border-bottom pb-2">Data Customer</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Customer <span class="text-danger">*</span></label>
                <input type="text" name="nama_customer" class="form-control @error('nama_customer') is-invalid @enderror"
                       value="{{ old('nama_customer') }}" placeholder="Nama lengkap customer" required>
                @error('nama_customer')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">No HP <span class="text-danger">*</span></label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                       value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <h6 class="text-muted mb-3 border-bottom pb-2 mt-4">Detail Laundry</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Layanan <span class="text-danger">*</span></label>
                <select name="layanan_id" id="layananSelect" class="form-select @error('layanan_id') is-invalid @enderror" required>
                    <option value="">— Pilih Layanan —</option>
                    @foreach($layanans as $l)
                    <option value="{{ $l->id }}"
                            data-harga="{{ $l->harga_per_kg }}"
                            data-estimasi="{{ $l->estimasi_jam }}"
                            {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                        {{ $l->nama }} — Rp {{ number_format($l->harga_per_kg,0,',','.') }}/kg
                    </option>
                    @endforeach
                </select>
                @error('layanan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Berat (kg) <span class="text-danger">*</span></label>
                <input type="number" name="berat_kg" id="beratInput"
                       class="form-control @error('berat_kg') is-invalid @enderror"
                       value="{{ old('berat_kg') }}" step="0.1" min="0.1" placeholder="Contoh: 3.5" required>
                @error('berat_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Preview harga --}}
            <div class="alert alert-info d-none" id="previewHarga">
                <div class="row">
                    <div class="col-6"><small class="text-muted">Harga/kg</small><br><strong id="previewHargaKg">—</strong></div>
                    <div class="col-6"><small class="text-muted">Total</small><br><strong id="previewTotal" class="fs-5 text-primary">—</strong></div>
                </div>
                <div class="mt-2"><small class="text-muted"><i class="bi bi-clock me-1"></i>Estimasi selesai: <strong id="previewEstimasi">—</strong></small></div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Warna khusus, bahan sensitif, dll">{{ old('catatan') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Status Pembayaran</label>
                <select name="status_bayar" class="form-select">
                    <option value="belum_bayar" {{ old('status_bayar','belum_bayar') === 'belum_bayar' ? 'selected':'' }}>Belum Bayar</option>
                    <option value="lunas"       {{ old('status_bayar') === 'lunas' ? 'selected':'' }}>Lunas (Bayar di Muka)</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan & Cetak Nota
                </button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
function hitungHarga() {
    const sel   = document.getElementById('layananSelect');
    const berat = parseFloat(document.getElementById('beratInput').value) || 0;
    const opt   = sel.options[sel.selectedIndex];
    const harga = parseFloat(opt?.dataset?.harga) || 0;
    const est   = parseInt(opt?.dataset?.estimasi) || 0;

    if (harga && berat) {
        const total = harga * berat;
        const selesai = new Date(Date.now() + est * 3600000);
        document.getElementById('previewHarga').classList.remove('d-none');
        document.getElementById('previewHargaKg').textContent = 'Rp ' + harga.toLocaleString('id');
        document.getElementById('previewTotal').textContent   = 'Rp ' + total.toLocaleString('id');
        document.getElementById('previewEstimasi').textContent = selesai.toLocaleString('id', {
            day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit'
        });
    } else {
        document.getElementById('previewHarga').classList.add('d-none');
    }
}
document.getElementById('layananSelect').addEventListener('change', hitungHarga);
document.getElementById('beratInput').addEventListener('input', hitungHarga);
</script>
@endpush