@extends('layouts.app')
@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan: ' . $layanan->nama)

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-pencil-square me-2"></i>Edit Data Layanan
    </div>
    <div class="card-body">
        <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $layanan->nama) }}"
                       required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="harga_per_kg"
                           class="form-control @error('harga_per_kg') is-invalid @enderror"
                           value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}"
                           min="100" step="500"
                           required>
                    <span class="input-group-text">/kg</span>
                </div>
                <div class="form-text text-warning">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Perubahan harga hanya berlaku untuk transaksi baru. Transaksi lama tidak berubah.
                </div>
                @error('harga_per_kg')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Estimasi Selesai (jam) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="estimasi_jam"
                           class="form-control @error('estimasi_jam') is-invalid @enderror"
                           value="{{ old('estimasi_jam', $layanan->estimasi_jam) }}"
                           min="1" max="720"
                           required>
                    <span class="input-group-text">jam</span>
                </div>
                @error('estimasi_jam')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="2"
                          class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status Layanan</label>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" id="isActive" value="1"
                           {{ old('is_active', $layanan->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">
                        Layanan Aktif
                        <small class="text-muted">(nonaktifkan agar tidak muncul saat input transaksi)</small>
                    </label>
                </div>
            </div>

            {{-- Info tambahan --}}
            <div class="alert alert-light border mb-4" style="font-size:.85rem">
                <div class="row g-2">
                    <div class="col-6">
                        <span class="text-muted">Dibuat:</span><br>
                        <strong>{{ $layanan->created_at->format('d M Y') }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Total Digunakan:</span><br>
                        <strong>{{ number_format($layanan->transaksis()->count()) }} transaksi</strong>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection