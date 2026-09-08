@extends('layouts.app')

@section('title', 'Pusat Log Sistem & Riwayat Koneksi')
@section('header-title', 'Pusat Log Sistem & Riwayat Koneksi')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-1">
                <i class="bi bi-clock-history text-primary me-1"></i> Audit Trail &amp; Catatan Aktivitas Sistem
            </h5>
            <p class="small text-muted mb-0">Seluruh proses sinkronisasi background BMKG, BIG, dan interaksi pengguna terekam otomatis.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <!-- Tombol Ekspor CSV -->
            <a href="{{ route('admin.logs.export') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Ekspor Log (CSV)
            </a>
            
            <!-- Tombol Bersihkan Log (Fitur Kontrol Admin) -->
            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh riwayat log sistem ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                    <i class="bi bi-trash me-1"></i> Bersihkan Log
                </button>
            </form>

            <!-- Tombol Uji Sinkron -->
            <form action="{{ route('admin.sync-bmkg') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                    <i class="bi bi-arrow-repeat me-1"></i> Uji Sinkron BMKG
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 60px;">No</th>
                    <th>Waktu Catat</th>
                    <th>Pengguna / Pemicu</th>
                    <th>Sumber Data</th>
                    <th>Jenis Data</th>
                    <th>Keterangan Aktivitas</th>
                    <th class="text-center pe-4">Status Koneksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                <tr>
                    <td class="ps-4 text-muted">{{ $logs->firstItem() + $index }}</td>
                    <td class="text-muted">{{ $log->waktu_update ? $log->waktu_update->format('d/m/Y H:i:s') : '-' }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $log->user->name ?? 'System Bot (Automated)' }}
                        </span>
                    </td>
                    <td><b>{{ $log->sumber }}</b></td>
                    <td><span class="badge bg-light text-dark border">{{ $log->jenis_data }}</span></td>
                    <td class="text-muted">{{ $log->keterangan }}</td>
                    <td class="text-center pe-4">
                        <span class="badge {{ strtolower($log->status_koneksi) === 'terhubung' || strtolower($log->status_koneksi) === 'berhasil' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($log->status_koneksi) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada catatan log sistem yang terekam.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection