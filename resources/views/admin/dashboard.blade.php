@extends('layouts.app')

@section('title', 'Panel Administrator Utama')
@section('header-title', 'Pusat Kontrol Administrator Sistem')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Quick Metrics -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Total Pengguna Terdaftar</div>
                    <div class="fs-3 fw-bold text-dark">{{ $userCounts['total'] }}</div>
                    <div class="small text-muted">{{ $userCounts['user'] }} Warga &bull; {{ $userCounts['operator'] }} Operator</div>
                </div>
                <div class="p-3 bg-primary-subtle text-primary rounded-3"><i class="bi bi-people-fill fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Indikator Risiko Aktif</div>
                    <div class="fs-3 fw-bold text-emerald">{{ $totalIndikator }}</div>
                    <div class="small text-muted">4 Dimensi Penilaian</div>
                </div>
                <div class="p-3 bg-success-subtle text-success rounded-3"><i class="bi bi-sliders fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Feed Eksternal</div>
                    <div class="fs-3 fw-bold text-info">{{ $sumberList->count() }}</div>
                    <div class="small text-muted">BMKG, BIG, BPBD, PuSGeN</div>
                </div>
                <div class="p-3 bg-info-subtle text-info rounded-3"><i class="bi bi-cloud-arrow-down fs-4"></i></div>
            </div>
        </div>
    </div>
   <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Sinkronisasi BMKG</div>
                    <form action="{{ route('admin.sync-bmkg') }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="bi bi-arrow-repeat me-1"></i> Sinkron Sekarang
                        </button>
                    </form>
                </div>
                <div class="p-3 bg-danger-subtle text-danger rounded-3"><i class="bi bi-broadcast fs-4"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Audit Trail & Log Terkini -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-clock-history text-primary me-1"></i> Audit Trail &amp; Log Pembaruan Sistem
                </h5>
                <a href="{{ route('admin.logs') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    Lihat Semua Log
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>Sumber Data</th>
                            <th>Jenis Data</th>
                            <th>Keterangan</th>
                            <th class="text-center pe-4">Status Koneksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr>
                            <td class="ps-4 text-muted">{{ $log->waktu_update ? $log->waktu_update->format('d/m H:i:s') : '-' }}</td>
                            <td><b>{{ $log->sumber }}</b></td>
                            <td><span class="badge bg-light text-dark border">{{ $log->jenis_data }}</span></td>
                            <td class="text-muted">{{ $log->keterangan }}</td>
                            <td class="text-center pe-4">
                                <span class="badge {{ $log->status_koneksi === 'berhasil' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($log->status_koneksi) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada catatan log.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Feed Sumber Data API Status -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-hdd-network text-emerald me-1"></i> Status Feed API Terhubung
            </h5>
            <div class="d-flex flex-column gap-3">
                @foreach($sumberList as $s)
                <div class="p-3 border rounded-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-dark small">{{ $s->nama_sumber }}</span>
                        <span class="badge {{ $s->status === 'aktif' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </div>
                    <div class="small text-muted mb-1">{{ $s->tipe_sumber }} &bull; {{ $s->url_endpoint }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Terakhir sinkron: {{ $s->terakhir_diperbarui ? $s->terakhir_diperbarui->diffForHumans() : '-' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
