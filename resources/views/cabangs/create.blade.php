@extends('layouts.app')
@section('title', 'Tambah Cabang')
@section('page-title', 'Tambah Cabang Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-building-add me-2"></i>Form Tambah Cabang
    </div>
    <div class="card-body">
        <form action="{{ route('cabang.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Cabang <span class="text-danger">*</span></label>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Cabang Jakarta Selatan"
                       required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Kode Cabang <span class="text-danger">*</span>
                    <small class="text-muted fw-normal">(huruf kapital & angka, maks 10 karakter)</small>
                </label>
                <input type="text" name="kode"
                       class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode') }}"
                       placeholder="Contoh: JKT2, BDG, SBY"
                       style="text-transform:uppercase"
                       maxlength="10"
                       required>
                <div class="form-text">Kode ini akan digunakan sebagai bagian dari kode transaksi. Contoh: LDR-<strong>JKT</strong>-20240101-0001</div>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat" rows="3"
                          class="form-control @error('alamat') is-invalid @enderror"
                          placeholder="Jl. Nama Jalan No. XX, Kota"
                          required>{{ old('alamat') }}</textarea>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">No Telepon</label>
                <input type="text" name="telepon"
                       class="form-control @error('telepon') is-invalid @enderror"
                       value="{{ old('telepon') }}"
                       placeholder="Contoh: 021-12345678">
                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Simpan Cabang
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
    // Auto uppercase kode cabang
    document.querySelector('input[name="kode"]').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush