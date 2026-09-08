@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header-title', 'Kelola Akun Pengguna & Hak Akses')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Form Tambah User Baru -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-person-plus-fill text-primary me-1"></i> Daftarkan Pengguna Baru
            </h5>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Nama Lengkap:</label>
                    <input type="text" name="name" class="form-control rounded-3" placeholder="Nama Lengkap" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Alamat Email:</label>
                    <input type="email" name="email" class="form-control rounded-3" placeholder="email@contoh.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Peran / Hak Akses:</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="user" selected>Warga / Peneliti</option>
                        <option value="operator">Operator Posko Bencana</option>
                        <option value="admin">Administrator Utama</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Kata Sandi (Password):</label>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="Minimal 6 karakter" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-person-check me-1"></i> Simpan Pengguna Baru
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Pengguna Sistem -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-people text-emerald me-1"></i> Daftar Akun Terdaftar
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Peran Saat Ini</th>
                            <th class="text-center pe-4">Ubah Hak Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $u)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                            <td><b>{{ $u->name }}</b></td>
                            <td class="text-muted">{{ $u->email }}</td>
                            <td>
                                <span class="badge {{ $u->role === 'admin' ? 'bg-danger' : ($u->role === 'operator' ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ strtoupper($u->role) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="d-inline-flex gap-1">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm rounded-2 py-0" style="font-size: 0.75rem;" onchange="this.form.submit()">
                                        <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>Warga</option>
                                        <option value="operator" {{ $u->role === 'operator' ? 'selected' : '' }}>Operator</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada akun pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
