@extends('layouts.app')
@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-plus-circle me-2"></i>Form Tambah Layanan
    </div>
    <div class="card-body">
        <form action="{{ route('layanan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Cuci & Setrika, Express, Dry Cleaning"
                       required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number"
                            name="harga_per_kg"
                            class="form-control"
                            min="0"
                            step="1"
                            required>
                    <span class="input-group-text">/kg</span>
                </div>
                @error('harga_per_kg')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Estimasi Selesai (jam) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="estimasi_jam"
                           class="form-control @error('estimasi_jam') is-invalid @enderror"
                           value="{{ old('estimasi_jam', 24) }}"
                           placeholder="Contoh: 24"
                           min="1" max="720"
                           required>
                    <span class="input-group-text">jam</span>
                </div>
                <div class="form-text">
                    6 jam = Express &nbsp;|&nbsp; 24 jam = 1 hari &nbsp;|&nbsp; 48 jam = 2 hari &nbsp;|&nbsp; 72 jam = 3 hari
                </div>
                @error('estimasi_jam')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="2"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Penjelasan singkat tentang layanan ini (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan Layanan
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