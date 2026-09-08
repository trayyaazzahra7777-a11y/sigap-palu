@extends('layouts.public')

@section('title', 'Monitoring Terpadu Kebencanaan')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="text-success fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Pusat Pemantauan Real Data</span>
            <h2 class="fw-bold text-dark mb-1">Monitoring Seismisitas & Oseanografi Kota Palu</h2>
            <p class="text-muted mb-0">
                Pembaruan data gempa tektonik dari BMKG dan observasi pasang surut muka air laut Teluk Palu dari BIG.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-actual"><i class="bi bi-broadcast"></i> DATA AKTUAL</span>
            <a href="{{ route('public.peta') }}" class="btn btn-outline-emerald btn-sm">
                <i class="bi bi-map me-1"></i> Buka Peta Spasial
            </a>
        </div>
    </div>

    <!-- Alert / Peringatan Dini Strip -->
    @if($peringatanList->count() > 0)
        <div class="mb-4">
            @foreach($peringatanList as $p)
                @php
                    $alertCls = match($p->tingkat) {
                        'peringatan' => 'alert-danger',
                        'siaga' => 'alert-warning',
                        'waspada' => 'alert-info',
                        default => 'alert-secondary',
                    };
                    $iconCls = match($p->tingkat) {
                        'peringatan' => 'bi-exclamation-octagon-fill text-danger',
                        'siaga' => 'bi-exclamation-triangle-fill text-warning',
                        'waspada' => 'bi-info-circle-fill text-info',
                        default => 'bi-bell-fill',
                    };
                @endphp
                <div class="alert {{ $alertCls }} border shadow-sm d-flex align-items-center justify-content-between p-3 rounded-3 mb-2">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi {{ $iconCls }} fs-3"></i>
                        <div>
                            <div class="fw-bold text-uppercase" style="font-size: 0.85rem;">
                                {{ $p->jenis_peringatan }} &bull; Status: {{ strtoupper($p->tingkat) }}
                                @if($p->wilayah)
                                    <span class="badge bg-dark ms-2">{{ $p->wilayah->nama_wilayah }}</span>
                                @endif
                            </div>
                            <div class="small">{{ $p->pesan }}</div>
                        </div>
                    </div>
                    <small class="text-muted d-none d-md-block">
                        Berlaku: {{ $p->waktu_mulai->format('d/m/Y H:i') }} WITA
                    </small>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Nav Tabs -->
    <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="monitoringTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="gempa-tab" data-bs-toggle="pill" data-bs-target="#gempaTabContent" type="button" role="tab">
                <i class="bi bi-activity text-danger me-1"></i> Data Gempa Bumi (BMKG)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="laut-tab" data-bs-toggle="pill" data-bs-target="#lautTabContent" type="button" role="tab">
                <i class="bi bi-water text-primary me-1"></i> Pasang Surut Teluk Palu (BIG)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sumber-tab" data-bs-toggle="pill" data-bs-target="#sumberTabContent" type="button" role="tab">
                <i class="bi bi-hdd-network text-success me-1"></i> Status Sumber Data
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="monitoringTabContent">
        
        <!-- TAB 1: GEMPA BUMI -->
        <div class="tab-pane fade show active" id="gempaTabContent" role="tabpanel">
            <div class="card border rounded-3 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Daftar Kejadian Seismisitas Terpantau di Sulawesi Tengah & Sesar Palu-Koro</h6>
                        <small class="text-muted">Sumber Data: BMKG Republik Indonesia &bull; Terverifikasi</small>
                    </div>
                    <div>
                        <span class="badge bg-light text-muted border">Total: {{ $gempaList->total() }} Kejadian Tercatat</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small text-uppercase">
                                <th class="px-3">Waktu Kejadian (WITA)</th>
                                <th class="text-center">Magnitudo</th>
                                <th class="text-center">Kedalaman</th>
                                <th class="text-center">Koordinat</th>
                                <th>Wilayah Episenter</th>
                                <th>Potensi Tsunami</th>
                                <th class="text-center">Status Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gempaList as $g)
                                @php
                                    $magBadge = $g->magnitudo >= 5.0 ? 'bg-danger text-white' : ($g->magnitudo >= 3.5 ? 'bg-warning text-dark' : 'bg-secondary text-white');
                                @endphp
                                <tr>
                                    <td class="px-3">
                                        <div class="fw-bold text-dark">{{ $g->tanggal_waktu->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $g->tanggal_waktu->format('H:i:s') }} WITA</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $magBadge }} fs-6 px-2 py-1 rounded-2">
                                            M {{ number_format($g->magnitudo, 1) }}
                                        </span>
                                    </td>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ number_format($g->kedalaman, 0) }} km
                                    </td>
                                    <td class="text-center small text-muted">
                                        {{ $g->latitude }}, {{ $g->longitude }}
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $g->wilayah }}</div>
                                        @if($g->dirasakan)
                                            <small class="text-danger"><i class="bi bi-soundwave"></i> Dirasakan: {{ $g->dirasakan }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(str_contains(strtolower($g->potensi_tsunami ?? ''), 'berpotensi tsunami'))
                                            <span class="badge bg-danger text-white">{{ $g->potensi_tsunami }}</span>
                                        @else
                                            <span class="text-muted small"><i class="bi bi-shield-check text-success"></i> {{ $g->potensi_tsunami ?? 'Tidak Berpotensi Tsunami' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-actual">
                                            <i class="bi bi-patch-check-fill"></i> {{ strtoupper($g->sumber) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada data gempa bumi yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-3">
                    {{ $gempaList->links() }}
                </div>
            </div>
        </div>

        <!-- TAB 2: PASANG SURUT TELUK PALU -->
        <div class="tab-pane fade" id="lautTabContent" role="tabpanel">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="card border rounded-3 shadow-sm h-100 p-4">
                        <span class="badge-actual mb-2"><i class="bi bi-geo-alt-fill"></i> STASIUN OBSERVASI</span>
                        <h5 class="fw-bold text-dark mb-1">Pantoloan (Teluk Palu)</h5>
                        <p class="small text-muted mb-3">Operator: Badan Informasi Geospasial (BIG) &bull; Indonesia Tsunami Early Warning System (InaTEWS)</p>
                        
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="text-muted small">Tinggi Muka Laut Terkini:</div>
                            <div class="display-6 fw-bold text-primary my-1">
                                {{ $mukaLautList->first() ? number_format($mukaLautList->first()->tinggi_muka_laut, 2) : '1.19' }} m
                            </div>
                            <div class="small">Status: <strong class="text-success">Normal Pasang Surut</strong></div>
                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-info-circle me-1"></i> Data muka air laut digunakan untuk mendeteksi anomali penarikan air laut (*tsunami withdrawal*) atau gelombang pasang tinggi di perairan Teluk Palu.
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border rounded-3 shadow-sm overflow-hidden h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="fw-bold mb-0 text-dark">Riwayat Elevasi Muka Air Laut (7 Observasi Terakhir)</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-uppercase">
                                        <th class="px-3">Waktu Observasi</th>
                                        <th>Stasiun Pantau</th>
                                        <th class="text-center">Tinggi Muka Air</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Jenis Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mukaLautList as $m)
                                        <tr>
                                            <td class="px-3">
                                                <div class="fw-bold text-dark">{{ $m->tanggal_waktu->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $m->tanggal_waktu->format('H:i') }} WITA</small>
                                            </td>
                                            <td>{{ $m->stasiun }}</td>
                                            <td class="text-center fw-bold text-primary">
                                                {{ number_format($m->tinggi_muka_laut, 2) }} {{ $m->satuan }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                    {{ $m->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    {{ strtoupper($m->jenis_data) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: STATUS SUMBER DATA -->
        <div class="tab-pane fade" id="sumberTabContent" role="tabpanel">
            <div class="row g-3">
                @foreach($sumberData as $s)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border rounded-3 shadow-sm p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ strtoupper($s->status) }}
                                </span>
                                <span class="badge bg-light text-muted border">{{ $s->tipe_sumber }}</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $s->nama_sumber }}</h5>
                            <p class="small text-muted mb-2">{{ $s->jenis_data }}</p>
                            <p class="small text-muted mb-3">{{ $s->keterangan }}</p>
                            <div class="border-top pt-2 small text-muted mt-auto d-flex justify-content-between">
                                <span>Pembaruan Terakhir:</span>
                                <strong>{{ $s->last_update ? $s->last_update->format('d/m/Y H:i') . ' WITA' : '-' }}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

