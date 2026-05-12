@extends('layouts.app')
@section('title', 'Edit Cabang')
@section('page-title', 'Edit Cabang: ' . $cabang->nama)

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-pencil-square me-2"></i>Edit Data Cabang
    </div>
    <div class="card-body">
        <form action="{{ route('cabang.update', $cabang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Cabang <span class="text-danger">*</span></label>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $cabang->nama) }}"
                       required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Kode Cabang <span class="text-danger">*</span>
                    <small class="text-muted fw-normal">(huruf kapital & angka)</small>
                </label>
                <input type="text" name="kode"
                       class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode', $cabang->kode) }}"
                       style="text-transform:uppercase"
                       maxlength="10"
                       required>
                <div class="form-text text-warning">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Mengubah kode akan mempengaruhi format kode transaksi baru. Transaksi lama tidak terpengaruh.
                </div>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat" rows="3"
                          class="form-control @error('alamat') is-invalid @enderror"
                          required>{{ old('alamat', $cabang->alamat) }}</textarea>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">No Telepon</label>
                <input type="text" name="telepon"
                       class="form-control @error('telepon') is-invalid @enderror"
                       value="{{ old('telepon', $cabang->telepon) }}">
                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status Cabang</label>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" id="isActive" value="1"
                           {{ old('is_active', $cabang->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">
                        Cabang Aktif
                        <small class="text-muted">(nonaktifkan jika cabang tutup sementara)</small>
                    </label>
                </div>
            </div>

            {{-- Info tambahan --}}
            <div class="alert alert-light border mb-4" style="font-size:.85rem">
                <div class="row g-2">
                    <div class="col-6">
                        <span class="text-muted">Dibuat:</span><br>
                        <strong>{{ $cabang->created_at->format('d M Y') }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Total Transaksi:</span><br>
                        <strong>{{ number_format($cabang->transaksis()->count()) }} transaksi</strong>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('cabang.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('input[name="kode"]').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush