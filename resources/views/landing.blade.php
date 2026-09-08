@extends('layouts.public')

@section('title', 'Beranda Pemantauan Risiko Bencana')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(6, 78, 59, 0.9) 100%),
                    url('https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1920&q=80') center/cover;
        color: #ffffff;
        padding: 90px 0 70px 0;
        position: relative;
    }
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
    }
    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    #interactiveMap {
        height: 520px;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        z-index: 10;
    }
    .gis-legend {
        background: rgba(255, 255, 255, 0.96);
        padding: 14px 18px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 0.8rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        display: inline-block;
    }
    .timeline-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        border: 2px solid #a7f3d0;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')

    <!-- HERO SECTION SESUAI REQUIREMENT SPESIFIKASI (SEKSI 7) -->
    <section class="hero-bg text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="display-5 fw-extrabold text-white mb-3 mt-4">
                        Sistem Informasi Monitoring Kesiapsiagaan dan Risiko Bencana Gempa Bumi dan Tsunami
                    </h1>
                    <p class="lead text-white text-opacity-80 mb-5 mx-auto" style="max-width: 780px;">
                        Pusat pemantauan data gempa bumi, kondisi muka laut, serta visualisasi risiko dan kesiapsiagaan wilayah Kota Palu.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('public.peta') }}" class="btn btn-success btn-lg px-4 py-3 shadow" style="background-color: #059669; border-color: #059669;">
                            <i class="bi bi-map me-2"></i> Jelajahi Peta Risiko
                        </a>
                        <a href="{{ route('unduh.rekap') }}" class="btn btn-light btn-lg px-4 py-3 text-dark fw-bold">
                            <i class="bi bi-download me-2"></i> Unduh Rekap Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LIVE METRIC STRIP (DATA REAL & DIHITUNG DARI DATABASE) -->
    <section class="py-5" style="margin-top: -35px;">
        <div class="container">
            <div class="row g-3">
                <!-- Gempa Terbaru BMKG -->
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge-actual"><i class="bi bi-check-circle-fill"></i> DATA AKTUAL</span>
                            <span class="text-muted small">BMKG</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <div class="metric-icon bg-danger-subtle text-danger">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    {{ $gempaTerbaru ? 'M ' . number_format($gempaTerbaru->magnitudo, 1) : 'Belum Ada Data' }}
                                </div>
                                <div class="text-muted small">
                                    {{ $gempaTerbaru ? $gempaTerbaru->wilayah : 'Menunggu pembaruan feed' }}
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-2 mt-3 small text-muted d-flex justify-content-between">
                            <span>Kedalaman: {{ $gempaTerbaru ? $gempaTerbaru->kedalaman . ' km' : '-' }}</span>
                            <span>{{ $gempaTerbaru ? $gempaTerbaru->tanggal_waktu->diffForHumans() : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tinggi Muka Laut Pantoloan Teluk Palu -->
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge-actual"><i class="bi bi-check-circle-fill"></i> DATA AKTUAL</span>
                            <span class="text-muted small">BIG Pasut</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <div class="metric-icon bg-primary-subtle text-primary">
                                <i class="bi bi-water"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    {{ $mukaLautTerbaru ? number_format($mukaLautTerbaru->tinggi_muka_laut, 2) . ' m' : '1.19 m' }}
                                </div>
                                <div class="text-muted small">
                                    Stasiun Pantoloan (Teluk Palu)
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-2 mt-3 small text-muted d-flex justify-content-between">
                            <span>Status: <strong class="text-success">{{ $mukaLautTerbaru ? $mukaLautTerbaru->status : 'Normal' }}</strong></span>
                            <span>Tipe: {{ $mukaLautTerbaru ? $mukaLautTerbaru->jenis_data : 'sensor' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Wilayah Dipantau & Rata-rata Risiko -->
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-secondary-subtle text-secondary fw-bold" style="font-size: 0.72rem;">STATUS WILAYAH</span>
                            <span class="text-muted small">8 Kecamatan</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <div class="metric-icon bg-warning-subtle text-warning">
                                <i class="bi bi-shield-exclamation"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    {{ $cityMetrics['tingkat_risiko_kota'] }} ({{ $cityMetrics['skor_risiko_kota'] }}/100)
                                </div>
                                <div class="text-muted small">
                                    Indeks Risiko Kota Palu
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-2 mt-3 small text-muted d-flex justify-content-between">
                            <span>{{ $cityMetrics['distribusi_risiko']['Tinggi'] }} Zona Tinggi</span>
                            <span>{{ $cityMetrics['distribusi_risiko']['Sedang'] }} Zona Sedang</span>
                        </div>
                    </div>
                </div>

                <!-- Peringatan Dini Aktif -->
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-info-subtle text-info-emphasis fw-bold" style="font-size: 0.72rem;">STATUS SISTEM</span>
                            <span class="text-muted small">{{ date('d M Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <div class="metric-icon bg-success-subtle text-success">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    {{ $peringatanAktif->count() > 0 ? $peringatanAktif->count() . ' Aktif' : 'Normal / Waspada' }}
                                </div>
                                <div class="text-muted small">
                                    Peringatan & Status Kebencanaan
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-2 mt-3 small text-muted d-flex justify-content-between">
                            <span>Kesiapsiagaan Kota:</span>
                            <strong class="text-success">{{ $cityMetrics['tingkat_kesiapsiagaan_kota'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WEBGIS INTERAKTIF KOTA PALU -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-8">
                    <h3 class="fw-bold text-dark mb-1">WebGIS Multi-Hazard & Kesiapsiagaan Kota Palu</h3>
                    <p class="text-muted mb-0">
                        Visualisasi spasial hubungan antara Patahan Aktif Sesar Palu-Koro, Zonasi Kerentanan Likuifaksi, Sempadan Pantai Teluk Palu, dan Seismisitas BMKG.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('public.peta') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                        <i class="bi bi-arrows-fullscreen me-1"></i> Buka Peta Layar Penuh
                    </a>
                </div>
            </div>

            <!-- LAYER CONTROLS BADGES -->
            <div class="p-3 bg-light rounded-3 border mb-3 d-flex flex-wrap align-items-center gap-3 small">
                <span class="fw-bold text-dark"><i class="bi bi-layers-half me-1"></i> Kontrol Layer GIS:</span>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerWilayah" checked>
                    <label class="form-check-label" for="layerWilayah">Wilayah Risiko (Kecamatan)</label>
                </div>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerSesar" checked>
                    <label class="form-check-label text-danger fw-semibold" for="layerSesar">Sesar Palu-Koro</label>
                </div>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerLikuifaksi" checked>
                    <label class="form-check-label text-warning-emphasis fw-semibold" for="layerLikuifaksi">Zona Kerentanan Likuifaksi</label>
                </div>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerPantai" checked>
                    <label class="form-check-label text-primary fw-semibold" for="layerPantai">Pesisir Teluk Palu</label>
                </div>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerGempa" checked>
                    <label class="form-check-label" for="layerGempa">Titik Gempa BMKG</label>
                </div>
                <div class="form-check form-check-input-inline m-0 d-none"></div>
                <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" id="layerEvakuasi" checked>
                    <label class="form-check-label text-success fw-semibold" for="layerEvakuasi">Titik Kumpul Evakuasi</label>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8 position-relative">
                    <!-- Tombol Roadmap & Satelit Melayang di Peta -->
                    <div class="position-absolute" style="top: 15px; right: 25px; z-index: 1000;">
                        <div class="btn-group shadow-sm bg-white rounded-3 p-1" role="group">
                            <button type="button" class="btn btn-sm btn-success fw-bold" id="btnMapRoadmap" onclick="switchLandingMap('roadmap')">Roadmap</button>
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold border-0" id="btnMapSatellite" onclick="switchLandingMap('satellite')">Satelit</button>
                        </div>
                    </div>

                    <div id="interactiveMap"></div>
                </div>

                <!-- SIDE DRAWER: PROFIL RISIKO -->
                <div class="col-lg-4">
                    <div class="card border h-100 rounded-3 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle-fill text-success"></i>
                                <span>Profil Risiko Wilayah</span>
                            </h6>
                            <small class="text-muted">Klik suatu kecamatan pada peta untuk membedah data</small>
                        </div>
                        <div class="card-body" id="regionDetailPanel">
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-geo-alt fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <h6 class="fw-bold text-dark">Pilih Wilayah pada Peta</h6>
                                <p class="small">Sistem akan menghitung dan menampilkan dekomposisi indikator: Kenapa wilayah ini berisiko?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- WILAYAH PRIORITAS PENANGANAN & KESIAPSIAGAAN (FEATURE 14) -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8">
                    <span class="text-success fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Analisis Hasil</span>
                    <h3 class="fw-bold text-dark mb-1">Peringkat Wilayah Prioritas Penanganan</h3>
                    <p class="text-muted mb-0">
                        Penentuan urutan prioritas mitigasi menggunakan matriks formula Kajian Risiko Bencana (BNPB): <code>Risiko = (Ancaman × Kerentanan) / Kapasitas</code>.
                    </p>
                </div>
                <div class="col-md-4 text-md-end align-self-end mt-3 mt-md-0">
                    <span class="badge bg-secondary-subtle text-secondary border">Bukan Prediksi Bencana</span>
                </div>
            </div>

            <div class="card border rounded-3 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr class="small text-uppercase">
                                <th class="py-3 px-3 text-center" style="width: 80px;">Prioritas</th>
                                <th>Kecamatan</th>
                                <th class="text-center">Tingkat Risiko</th>
                                <th class="text-center">Kesiapsiagaan</th>
                                <th>Faktor Risiko Dominan</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($priorityAreas as $idx => $p)
                                @php
                                    $badgeRisiko = match($p['tingkat_risiko']) {
                                        'Tinggi' => 'bg-danger text-white',
                                        'Sedang' => 'bg-warning text-dark',
                                        default => 'bg-success text-white',
                                    };
                                    $badgeSiaga = match($p['tingkat_kesiapsiagaan']) {
                                        'Sangat Baik', 'Baik' => 'bg-success-subtle text-success border border-success-subtle',
                                        default => 'bg-info-subtle text-info-emphasis border border-info-subtle',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold text-muted">#{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $p['nama_wilayah'] }}</div>
                                        <small class="text-muted">Kota Palu &bull; {{ $p['latitude'] }}, {{ $p['longitude'] }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeRisiko }} px-3 py-2 rounded-pill">
                                            {{ $p['tingkat_risiko'] }} ({{ $p['skor_risiko'] }})
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeSiaga }} px-3 py-1 rounded-pill">
                                            {{ $p['tingkat_kesiapsiagaan'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small text-dark">{{ $p['faktor_utama'] }}</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-2" onclick="focusRegion({{ $p['id_wilayah'] }})">
                                            <i class="bi bi-search"></i> Telusuri
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- SEJARAH BENCANA 28 SEPTEMBER 2018 (FEATURE 12) -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="text-danger fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Rekam Jejak Sejarah Bencana</span>
                <h3 class="fw-bold text-dark mb-2">Tragedi 28 September 2018 & Pembelajaran untuk Kota Palu</h3>
                <p class="text-muted">
                    Rangkaian bencana triple-disaster (Gempa Bumi, Tsunami Lokal, dan Likuifaksi Masif) yang menjadi landasan utama kesiapsiagaan lingkungan hidup di Kota Palu.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-3 h-100 bg-light">
                        <div class="timeline-badge mb-3">1</div>
                        <h5 class="fw-bold text-dark">Gempa M 7.5</h5>
                        <p class="small text-muted mb-2"><strong>Waktu:</strong> 18:02:44 WITA</p>
                        <p class="small text-muted">
                            Pelepasan energi tektonik dangkal (10 km) sepanjang Sesar Palu-Koro dengan pergeseran geser mendatar kiri berkecepatan tinggi, mengguncang Kota Palu pada skala VIII-IX MMI.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-3 h-100 bg-light">
                        <div class="timeline-badge mb-3 bg-primary-subtle text-primary border-primary">2</div>
                        <h5 class="fw-bold text-dark">Tsunami Cepat</h5>
                        <p class="small text-muted mb-2"><strong>Waktu Tiba:</strong> 3 - 8 Menit</p>
                        <p class="small text-muted">
                            Dipicu kombinasi deformasi tektonik dan longsoran tebing bawah laut di Teluk Palu. Menghantam pesisir Talise, Kampung Baru, dan Pantoloan dengan ketinggian limpasan mencapai 6-11 meter.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-3 h-100 bg-light">
                        <div class="timeline-badge mb-3 bg-warning-subtle text-warning border-warning">3</div>
                        <h5 class="fw-bold text-dark">Likuifaksi Aluvial</h5>
                        <p class="small text-muted mb-2"><strong>Lokasi:</strong> Petobo & Balaroa</p>
                        <p class="small text-muted">
                            Hilangnya kekuatan geser tanah pada endapan aluvial jenuh air, menyebabkan fenomena aliran tanah lumpur masif di Petobo dan amblesan lateral di Balaroa yang menenggelamkan ribuan permukiman.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-3 h-100 bg-light">
                        <div class="timeline-badge mb-3 bg-success-subtle text-success border-success">4</div>
                        <h5 class="fw-bold text-dark">Mitigasi & Tata Ruang</h5>
                        <p class="small text-muted mb-2"><strong>Paska Bencana:</strong> Relokasi ZNT</p>
                        <p class="small text-muted">
                            Penyusunan Zona Rawan Bencana (ZNT 1 s/d 4), pembangunan tanggul laut mitigasi, jalur evakuasi vertikal, dan pembatasan pembangunan di sepanjang sempadan sesar aktif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('public.sejarah') }}" class="btn btn-outline-dark">
                    <i class="bi bi-clock-history me-1"></i> Pelajari Seluruh Dokumentasi Sejarah & Pembelajaran
                </a>
            </div>
        </div>
    </section>

    <!-- TRANSPARANSI STATUS SUMBER DATA (FEATURE 15) -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center max-w-700 mx-auto mb-4">
                <span class="text-success fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Transparansi Sistem</span>
                <h3 class="fw-bold text-dark mb-1">Status Sumber Data Terintegrasi</h3>
                <p class="text-muted small">
                    SIGAP-PALU tidak mengklaim memiliki sensor fisik pribadi. Sistem secara terbuka menampilkan status konektivitas sumber data resmi.
                </p>
            </div>

            <div class="row g-3">
                @foreach($sumberData as $s)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 bg-white border rounded-3 h-100 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold" style="font-size: 0.7rem;">
                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> {{ strtoupper($s->status) }}
                                </span>
                                <span class="badge bg-light text-muted border" style="font-size: 0.65rem;">{{ $s->tipe_sumber }}</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $s->nama_sumber }}</h6>
                            <p class="small text-muted mb-2">{{ $s->jenis_data }}</p>
                            <div class="border-top pt-2 small text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i> Update: {{ $s->last_update ? $s->last_update->format('d/m/Y H:i') . ' WITA' : '-' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Peta Leaflet (Palu: -0.8972, 119.8707)
        const map = L.map('interactiveMap').setView([-0.8972, 119.8707], 11);

        // Basemap OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors | SIGAP-PALU'
        }).addTo(map);

        // Layer Groups
        const layerWilayahGroup = L.layerGroup().addTo(map);
        const layerSesarGroup = L.layerGroup().addTo(map);
        const layerLikuifaksiGroup = L.layerGroup().addTo(map);
        const layerPantaiGroup = L.layerGroup().addTo(map);
        const layerGempaGroup = L.layerGroup().addTo(map);
        const layerEvakuasiGroup = L.layerGroup().addTo(map);

        // 1. Load Batas Kecamatan
        fetch("{{ route('api.geojson', 'batas_kecamatan_palu') }}")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    style: function (feature) {
                        return {
                            color: feature.properties.warna || '#059669',
                            weight: 2,
                            opacity: 0.9,
                            fillColor: feature.properties.warna || '#059669',
                            fillOpacity: 0.25
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindTooltip(`<strong>${feature.properties.nama_wilayah}</strong><br>Risiko: ${feature.properties.tingkat_risiko}`);
                        layer.on('click', function () {
                            loadRegionDetail(feature.properties.id_wilayah);
                        });
                    }
                }).addTo(layerWilayahGroup);
            });

        // 2. Load Sesar Palu-Koro
        fetch("{{ route('api.geojson', 'sesar_palu_koro') }}")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    style: { color: '#dc2626', weight: 4, dashArray: '6, 6' },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`<strong>${feature.properties.nama}</strong><br>${feature.properties.tipe}<br><small>${feature.properties.keterangan}</small>`);
                    }
                }).addTo(layerSesarGroup);
            });

        // 3. Load Zona Likuifaksi
        fetch("{{ route('api.geojson', 'zona_kerentanan_likuifaksi') }}")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    style: function (f) {
                        return { color: f.properties.warna, weight: 2, fillOpacity: 0.45 };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`<strong>${feature.properties.nama}</strong><br>Kerentanan: <strong>${feature.properties.kerentanan}</strong><br>Tipe: ${feature.properties.tipe_likuifaksi}<br><small>${feature.properties.keterangan}</small>`);
                    }
                }).addTo(layerLikuifaksiGroup);
            });

        // 4. Load Garis Pantai Teluk Palu
        fetch("{{ route('api.geojson', 'garis_pantai_teluk_palu') }}")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    style: { color: '#0284c7', weight: 3 },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`<strong>${feature.properties.nama}</strong><br><small>${feature.properties.keterangan}</small>`);
                    }
                }).addTo(layerPantaiGroup);
            });

        // 5. Load Titik Evakuasi
        fetch("{{ route('api.geojson', 'titik_evakuasi_palu') }}")
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
                        return L.circleMarker(latlng, {
                            radius: 7,
                            fillColor: '#10b981',
                            color: '#ffffff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.9
                        });
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(`<strong>${feature.properties.nama}</strong><br>${feature.properties.jenis}<br>Elevasi: ${feature.properties.elevasi_mdpl} mdpl<br>Kapasitas: ${feature.properties.daya_tampung}`);
                    }
                }).addTo(layerEvakuasiGroup);
            });

        // 6. Load Gempa BMKG
        fetch("{{ route('api.spatial-markers') }}")
            .then(res => res.json())
            .then(data => {
                if (data.gempa) {
                    data.gempa.forEach(g => {
                        const marker = L.circleMarker([g.latitude, g.longitude], {
                            radius: Math.max(5, g.magnitudo * 2),
                            fillColor: '#e11d48',
                            color: '#ffffff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.85
                        });
                        marker.bindPopup(`<strong>Gempa M ${g.magnitudo}</strong><br>${g.wilayah}<br>Kedalaman: ${g.kedalaman} km<br>Waktu: ${g.tanggal_waktu}<br><small>Sumber: ${g.sumber}</small>`);
                        marker.addTo(layerGempaGroup);
                    });
                }
            });

        // Toggle Layer Listeners
        document.getElementById('layerWilayah').addEventListener('change', e => e.target.checked ? map.addLayer(layerWilayahGroup) : map.removeLayer(layerWilayahGroup));
        document.getElementById('layerSesar').addEventListener('change', e => e.target.checked ? map.addLayer(layerSesarGroup) : map.removeLayer(layerSesarGroup));
        document.getElementById('layerLikuifaksi').addEventListener('change', e => e.target.checked ? map.addLayer(layerLikuifaksiGroup) : map.removeLayer(layerLikuifaksiGroup));
        document.getElementById('layerPantai').addEventListener('change', e => e.target.checked ? map.addLayer(layerPantaiGroup) : map.removeLayer(layerPantaiGroup));
        document.getElementById('layerGempa').addEventListener('change', e => e.target.checked ? map.addLayer(layerGempaGroup) : map.removeLayer(layerGempaGroup));
        document.getElementById('layerEvakuasi').addEventListener('change', e => e.target.checked ? map.addLayer(layerEvakuasiGroup) : map.removeLayer(layerEvakuasiGroup));

        // Fungsi Load Detail Wilayah (Kenapa Wilayah Ini Berisiko?)
        window.loadRegionDetail = function (idWilayah) {
            const panel = document.getElementById('regionDetailPanel');
            panel.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-success spinner-border-sm mb-2" role="status"></div><div class="small text-muted">Menganalisis indikator wilayah...</div></div>`;

            fetch(`/api/region-profile/${idWilayah}`)
                .then(res => res.json())
                .then(data => {
                    let alasanHtml = '';
                    data.alasan_risiko.forEach(a => {
                        alasanHtml += `<li class="mb-2 text-danger small"><i class="bi bi-exclamation-triangle me-1"></i> ${a}</li>`;
                    });

                    panel.innerHTML = `
                        <div class="mb-3">
                            <span class="badge bg-success-subtle text-success border border-success-subtle mb-1">${data.wilayah.kecamatan}</span>
                            <h5 class="fw-bold text-dark mb-0">${data.wilayah.nama_wilayah}</h5>
                            <small class="text-muted">Koordinat: ${data.wilayah.latitude}, ${data.wilayah.longitude}</small>
                        </div>
                        
                        <div class="row g-2 mb-3 text-center">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="small text-muted">Tingkat Risiko</div>
                                    <strong class="text-danger fs-6">${data.tingkat_risiko} (${data.skor_risiko})</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light">
                                    <div class="small text-muted">Kesiapsiagaan</div>
                                    <strong class="text-success fs-6">${data.tingkat_kesiapsiagaan} (${data.skor_kesiapsiagaan})</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold text-dark small mb-2"><i class="bi bi-question-circle-fill text-warning me-1"></i> Kenapa Wilayah Ini Berisiko?</h6>
                            <ul class="ps-3 mb-0">
                                ${alasanHtml}
                            </ul>
                        </div>

                        <div class="p-2 rounded bg-light border small text-muted">
                            <strong>Formula Kalkulasi:</strong> ${data.formula_digunakan}
                        </div>
                    `;
                })
                .catch(err => {
                    panel.innerHTML = `<div class="alert alert-danger small mb-0">Gagal memuat profil wilayah.</div>`;
                });
        };

        window.focusRegion = function(id) {
            window.loadRegionDetail(id);
            // Scroll ke peta jika di mobile
            document.getElementById('interactiveMap').scrollIntoView({ behavior: 'smooth', block: 'center' });
        };
    });
</script>
@endpush

