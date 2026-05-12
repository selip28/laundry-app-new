@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Daftar User</span>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-person-plus me-1"></i>Tambah User
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nama</th><th>Username</th><th>Role</th><th>Cabang</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td class="fw-semibold">{{ $u->nama }}</td>
                    <td><code>{{ $u->username }}</code></td>
                    <td>
                        @php
                            $roleColor = match($u->role) {
                                'superadmin'   => 'danger',
                                'admin_pusat'  => 'primary',
                                'admin_cabang' => 'info',
                                default => 'secondary',
                            };
                            $roleLabel = match($u->role) {
                                'superadmin'   => 'Super Admin',
                                'admin_pusat'  => 'Admin Pusat',
                                'admin_cabang' => 'Admin Cabang',
                                default => $u->role,
                            };
                        @endphp
                        <span class="badge bg-{{ $roleColor }}">{{ $roleLabel }}</span>
                    </td>
                    <td>{{ $u->cabang->nama ?? '—' }}</td>
                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus user {{ $u->nama }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->links() }}</div>
    @endif
</div>
@endsection