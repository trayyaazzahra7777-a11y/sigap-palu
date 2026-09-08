@extends('layouts.app')

@section('title', 'Dashboard Posko Operator')
@section('header-title', 'Posko Pengendalian & Operasi Darurat')

@section('content')
<!-- Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Peringatan Dini Aktif</div>
                    <div class="fs-3 fw-bold {{ $stats['peringatan_aktif'] > 0 ? 'text-danger' : 'text-success' }}">{{ $stats['peringatan_aktif'] }}</div>
                </div>
                <div class="p-3 bg-danger-subtle text-danger rounded-3"><i class="bi bi-bell-fill fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Data Seismik BMKG</div>
                    <div class="fs-3 fw-bold text-dark">{{ $stats['gempa_terekam'] }}</div>
                </div>
                <div class="p-3 bg-primary-subtle text-primary rounded-3"><i class="bi bi-activity fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Observasi Muka Laut</div>
                    <div class="fs-3 fw-bold text-dark">{{ $stats['pantau_muka_laut'] }}</div>
                </div>
                <div class="p-3 bg-info-subtle text-info rounded-3"><i class="bi bi-water fs-4"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Laporan Kejadian</div>
                    <div class="fs-3 fw-bold text-dark">{{ $stats['total_kejadian'] }}</div>
                </div>
                <div class="p-3 bg-warning-subtle text-warning rounded-3"><i class="bi bi-shield-exclamation fs-4"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Peringatan Aktif & Aksi Cepat -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-broadcast text-danger me-1"></i> Siaran Peringatan Dini yang Sedang Berjalan
                </h5>
                <a href="{{ route('operator.peringatan') }}" class="btn btn-sm btn-danger rounded-pill px-3">
                    + Terbitkan Peringatan
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tingkat</th>
                            <th>Jenis</th>
                            <th>Wilayah Cakupan</th>
                            <th>Pesan / Instruksi</th>
                            <th>Waktu Terbit</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peringatanAktif as $p)
                        <tr>
                            <td class="ps-4">
                                <span class="badge {{ $p->tingkat === 'Awas' ? 'bg-danger' : ($p->tingkat === 'Siaga' ? 'bg-warning text-dark' : 'bg-info text-dark') }} px-2 py-1">
                                    {{ $p->tingkat }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $p->jenis_peringatan }}</td>
                            <td>{{ $p->wilayah?->nama_wilayah ?? 'Seluruh Kota Palu' }}</td>
                            <td class="text-muted" style="max-width: 250px;">{{ \Illuminate\Support\Str::limit($p->pesan, 70) }}</td>
                            <td class="text-muted">{{ $p->waktu_mulai ? $p->waktu_mulai->diffForHumans() : '-' }}</td>
                            <td class="text-center pe-4">
                                <form action="{{ route('operator.peringatan.selesai', $p->id_peringatan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="return confirm('Tandai peringatan ini selesai?')">
                                        Akhiri
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-shield-check fs-2 text-success d-block mb-1"></i>
                                Tidak ada siaran peringatan dini yang aktif saat ini. Situasi aman terkendali.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laporan Kejadian Bencana Terbaru -->
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-clipboard-pulse text-warning me-1"></i> Log Kejadian Lapangan
                </h5>
                <a href="{{ route('operator.kejadian') }}" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3">
                    + Catat Kejadian
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>Kecamatan</th>
                            <th>Jenis</th>
                            <th>Lokasi Spesifik</th>
                            <th>Status Penanganan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kejadianList as $k)
                        <tr>
                            <td class="ps-4 text-muted">{{ $k->tanggal_waktu ? $k->tanggal_waktu->format('d/m H:i') : '-' }}</td>
                            <td><b>{{ $k->wilayah?->nama_wilayah ?? '-' }}</b></td>
                            <td><span class="badge bg-secondary">{{ $k->jenisBencana?->nama_bencana ?? 'Bencana' }}</span></td>
                            <td class="text-muted">{{ $k->lokasi }}</td>
                            <td>
                                <span class="badge {{ $k->status === 'selesai' ? 'bg-success' : ($k->status === 'ditangani' ? 'bg-warning text-dark' : 'bg-primary') }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada laporan kejadian terkini yang masuk ke posko.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Monitoring Sensor Live -->
    <div class="col-lg-4">
        <!-- Gempa BMKG Terkini -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-activity text-danger me-1"></i> Seismik BMKG Masuk</h6>
                <span class="badge bg-success-subtle text-success">Live Sinkron</span>
            </div>
            <div class="d-flex flex-column gap-2">
                @forelse($gempaTerbaru as $g)
                <div class="p-2 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark small">M {{ $g->magnitudo }} &bull; Kedalaman {{ $g->kedalaman_km }} km</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ $g->wilayah_terdampak }}</div>
                    </div>
                    <span class="badge bg-danger">{{ $g->waktu_gempa ? $g->waktu_gempa->format('H:i') : '' }}</span>
                </div>
                @empty
                <div class="text-muted small">Belum ada rekaman gempa.</div>
                @endforelse
            </div>
        </div>

        <!-- Muka Laut Pantoloan -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-water text-info me-1"></i> Muka Air Laut Teluk</h6>
                <a href="{{ route('operator.muka-laut') }}" class="btn btn-sm btn-outline-info rounded-pill px-2 py-0" style="font-size: 0.75rem;">
                    + Input
                </a>
            </div>
            <div class="d-flex flex-column gap-2">
                @forelse($mukaLautTerbaru as $m)
                <div class="p-2 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark small">{{ $m->stasiun }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Tinggi: <b>{{ $m->tinggi_muka_laut }} {{ $m->satuan }}</b> ({{ $m->status }})</div>
                    </div>
                    <span class="badge bg-info text-dark">{{ $m->tanggal_waktu ? $m->tanggal_waktu->format('H:i') : '' }}</span>
                </div>
                @empty
                <div class="text-muted small">Belum ada data stasiun pasut.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
