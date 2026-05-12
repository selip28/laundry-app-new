@extends('layouts.app')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')
@section('page-title', isset($user) ? 'Edit User' : 'Tambah User Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header py-3">
        <i class="bi bi-person{{ isset($user) ? '-gear' : '-plus' }} me-2"></i>
        {{ isset($user) ? 'Edit User: ' . $user->nama : 'Form Tambah User' }}
    </div>
    <div class="card-body">
        <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $user->nama ?? '') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username', $user->username ?? '') }}"
                       placeholder="huruf kecil, angka, underscore" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
                    @if(!isset($user))<span class="text-danger">*</span>@endif
                </label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       {{ !isset($user) ? 'required' : '' }}>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            @if(isset($user))
            <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            @else
            <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">— Pilih Role —</option>
                    <option value="superadmin"   {{ old('role', $user->role ?? '') === 'superadmin'   ? 'selected':'' }}>Super Admin</option>
                    <option value="admin_pusat"  {{ old('role', $user->role ?? '') === 'admin_pusat'  ? 'selected':'' }}>Admin Pusat</option>
                    <option value="admin_cabang" {{ old('role', $user->role ?? '') === 'admin_cabang' ? 'selected':'' }}>Admin Cabang</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3" id="cabangField" style="display:none">
                <label class="form-label fw-semibold">Cabang <span class="text-danger">*</span></label>
                <select name="cabang_id" class="form-select @error('cabang_id') is-invalid @enderror">
                    <option value="">— Pilih Cabang —</option>
                    @foreach($cabangs as $c)
                    <option value="{{ $c->id }}" {{ old('cabang_id', $user->cabang_id ?? '') == $c->id ? 'selected':'' }}>
                        {{ $c->nama }}
                    </option>
                    @endforeach
                </select>
                @error('cabang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            @if(isset($user))
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                           value="1" {{ old('is_active', $user->is_active ?? 1) ? 'checked':'' }}>
                    <label class="form-check-label" for="isActive">Akun Aktif</label>
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>{{ isset($user) ? 'Simpan Perubahan' : 'Tambah User' }}
                </button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
function toggleCabang() {
    const role = document.getElementById('roleSelect').value;
    document.getElementById('cabangField').style.display = role === 'admin_cabang' ? 'block' : 'none';
}
document.getElementById('roleSelect').addEventListener('change', toggleCabang);
toggleCabang(); // run on load
</script>
@endpush