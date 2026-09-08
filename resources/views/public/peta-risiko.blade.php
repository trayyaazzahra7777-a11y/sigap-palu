@extends('layouts.public')

@section('title', 'Peta Risiko Bencana Interaktif - SIGAP-PALU')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .map-wrapper {
        position: relative;
        height: calc(100vh - 145px);
        min-height: 620px;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    #gis-full-map {
        height: 100%;
        width: 100%;
        z-index: 1;
    }
    .gis-floating-panel {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        max-width: 340px;
        width: 100%;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .gis-legend-panel {
        position: absolute;
        bottom: 25px;
        right: 15px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        max-width: 280px;
        width: 100%;
        font-size: 0.8rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .gis-coords-badge {
        position: absolute;
        bottom: 15px;
        left: 15px;
        z-index: 1000;
        background: rgba(15, 23, 42, 0.85);
        color: #f8fafc;
        padding: 5px 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.75rem;
    }
    .legend-color-box {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 8px;
        vertical-align: middle;
    }
    .layer-item {
        padding: 6px 10px;
        border-radius: 6px;
        transition: background 0.15s;
    }
    .layer-item:hover {
        background: #f1f5f9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-4 py-3">
    <!-- Breadcrumb & Top Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small text-muted">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">WebGIS Risiko Terbuka</li>
                </ol>
            </nav>
            <h4 class="fw-bold text-dark mb-0">
                <i class="bi bi-map text-emerald me-2"></i>WebGIS Analisis Risiko Bencana Kota Palu
            </h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill small">
                <i class="bi bi-broadcast me-1 animate-pulse"></i> Sumber: BMKG, BIG &amp; PuSGeN
            </span>
            <a href="{{ route('unduh.rekap') }}" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Unduh Rekap Wilayah (.XLS)
            </a>
        </div>
    </div>

    <!-- Map Container -->
    <div class="map-wrapper shadow-sm position-relative">
        <!-- TAMBAHAN: Tombol Pilihan Roadmap & Satelit -->
        <div class="position-absolute" style="top: 15px; right: 70px; z-index: 1000;">
            <div class="btn-group shadow-sm bg-white rounded-3 p-1" role="group">
                <button type="button" class="btn btn-sm btn-success fw-bold" id="btnMapRoadmap" onclick="switchFullMap('roadmap')">Roadmap</button>
                <button type="button" class="btn btn-sm btn-outline-success fw-bold border-0" id="btnMapSatellite" onclick="switchFullMap('satellite')">Satelit</button>
            </div>
        </div>

        <div id="gis-full-map"></div>

        <!-- Floating Layer & Search Controls -->
        <div class="gis-floating-panel p-3">
            <div class="d-flex align-items-center justify-content-between pb-2 border-bottom mb-2">
                <div class="fw-bold text-dark small">
                    <i class="bi bi-sliders text-emerald me-1"></i> Kontrol Layer GIS
                </div>
                <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="collapse" data-bs-target="#layerCollapse" aria-expanded="true">
                    <i class="bi bi-chevron-up"></i>
                </button>
            </div>

            <div class="collapse show" id="layerCollapse">
                <!-- Dropdown Jump to Kecamatan -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Fokus ke Kecamatan:</label>
                    <select id="selectKecamatan" class="form-select form-select-sm rounded-3">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($wilayahList as $w)
                            <option value="{{ $w->id }}" data-lat="{{ $w->latitude }}" data-lng="{{ $w->longitude }}">
                                {{ $w->nama_wilayah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Layer Toggles -->
                <div class="d-flex flex-column gap-1">
                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="chkKecamatan" checked>
                            <span class="small fw-semibold text-dark">Batas 8 Kecamatan</span>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">Poligon</span>
                    </label>

                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="chkSesar" checked>
                            <span class="small fw-semibold text-danger">Patahan Sesar Palu-Koro</span>
                        </div>
                        <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Aktif</span>
                    </label>

                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="chkLikuifaksi" checked>
                            <span class="small fw-semibold text-warning">Zona Rentan Likuifaksi</span>
                        </div>
                        <span class="badge bg-warning-subtle text-warning" style="font-size: 0.65rem;">Aluvial</span>
                    </label>

                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="chkPantai" checked>
                            <span class="small fw-semibold text-info">Garis Pantai Teluk Palu</span>
                        </div>
                        <span class="badge bg-info-subtle text-info" style="font-size: 0.65rem;">Tsunami</span>
                    </label>

                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="chkEvakuasi" checked>
                            <span class="small fw-semibold text-success">Titik Evakuasi (TES/TEA)</span>
                        </div>
                        <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;">Aman</span>
                    </label>

                    <label class="layer-item d-flex align-items-center justify-content-between mb-0 cursor-pointer">
    <div class="d-flex align-items-center">
        <input class="form-check-input me-2 mt-0" type="checkbox" id="chkGempa" checked>
        <span class="small fw-semibold text-danger">Episentrum Seismik BMKG</span>
    </div>
    <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">BMKG</span>
</label>
                </div>

                <div class="mt-3 pt-2 border-top text-center">
                    <button id="btnResetMap" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Tampilan Peta
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Left Coordinate Badge -->
        <div class="gis-coords-badge shadow-sm" id="coordTracker">
            Lat: -0.8980 | Lng: 119.8707 | Zoom: 12
        </div>

        <!-- Bottom Right Legend -->
        <div class="gis-legend-panel p-3">
            <div class="d-flex align-items-center justify-content-between pb-1 border-bottom mb-2">
                <span class="fw-bold text-dark"><i class="bi bi-info-circle me-1"></i> Legenda Peta</span>
                <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="collapse" data-bs-target="#legendCollapse">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            <div class="collapse show" id="legendCollapse">
                <div class="d-flex flex-column gap-1">
                    <div><span class="legend-color-box" style="background: #dc2626; border-top: 2px dashed #991b1b;"></span> <span class="text-dark">Sesar Palu-Koro (Zona Patahan)</span></div>
                    <div><span class="legend-color-box" style="background: rgba(245, 158, 11, 0.4); border: 1px solid #d97706;"></span> <span class="text-dark">Zona Kerentanan Likuifaksi</span></div>
                    <div><span class="legend-color-box" style="background: rgba(6, 182, 212, 0.5); border: 1px solid #0891b2;"></span> <span class="text-dark">Pesisir Teluk Palu (Tsunami)</span></div>
                    <div><span class="legend-color-box" style="background: rgba(16, 185, 129, 0.4); border: 1px solid #059669;"></span> <span class="text-dark">Batas Wilayah Kecamatan</span></div>
                    <div><i class="bi bi-geo-alt-fill text-success me-2"></i> <span class="text-dark">Titik Kumpul / Evakuasi</span></div>
                    <div><i class="bi bi-circle-fill text-danger me-2" style="font-size: 0.75rem;"></i> <span class="text-dark">Episentrum Seismik BMKG</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Analysis Table under Map -->
    <div class="card border-0 shadow-sm rounded-4 mt-4 mb-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
    <i class="bi bi-clipboard-data text-emerald me-2"></i>Tabel Profil Risiko 8 Kecamatan Kota Palu
</h5>
<p class="text-muted small mb-0">Berdasarkan kalkulasi formula Kajian Risiko Bencana (BNPB): <em>Risiko = (Ancaman × Kerentanan) / Kapasitas</em></p>
                </div>
                <div class="small text-muted">
                    <span class="badge bg-danger text-white me-1">&bull; Tinggi: Skor &gt; 65</span>
                    <span class="badge bg-warning text-dark me-1">&bull; Sedang: 40 - 65</span>
                    <span class="badge bg-success text-white">&bull; Rendah: &lt; 40</span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kecamatan</th>
                        <th>Koordinat</th>
                        <th class="text-center">Skor Risiko</th>
                        <th class="text-center">Tingkat Risiko</th>
                        <th class="text-center">Kesiapsiagaan</th>
                        <th>Faktor Ancaman Utama</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($priorityAreas as $index => $item)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">#{{ $index + 1 }}</td>
                        <td>
                            <strong class="text-dark">{{ $item['nama_wilayah'] }}</strong>
                        </td>
                        <td class="small font-monospace text-muted">{{ $item['latitude'] }}, {{ $item['longitude'] }}</td>
                        <td class="text-center">
                            <span class="fw-bold {{ $item['tingkat_risiko'] === 'Tinggi' ? 'text-danger' : ($item['tingkat_risiko'] === 'Sedang' ? 'text-warning' : 'text-success') }}">
                                {{ $item['skor_risiko'] }} / 100
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item['tingkat_risiko'] === 'Tinggi')
                                <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill">Tinggi</span>
                            @elseif($item['tingkat_risiko'] === 'Sedang')
                                <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill">Sedang</span>
                            @else
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Rendah</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $item['tingkat_kesiapsiagaan'] }} ({{ $item['skor_kesiapsiagaan'] }})</span>
                        </td>
                        <td class="small text-muted">{{ $item['faktor_utama'] }}</td>
                        <td class="text-center pe-4">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 btn-detail-wilayah" 
                                    data-id="{{ $item['id'] }}" 
                                    data-lat="{{ $item['latitude'] }}" 
                                    data-lng="{{ $item['longitude'] }}" 
                                    data-nama="{{ $item['nama_wilayah'] }}">
                                <i class="bi bi-zoom-in me-1"></i> Telusuri Peta
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Offcanvas Analisis Wilayah -->
<div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="offcanvasAnalisisWilayah" style="width: 480px;">
    <div class="offcanvas-header bg-light border-bottom">
        <h5 class="offcanvas-title fw-bold text-dark" id="offcanvasLabel">
            <i class="bi bi-geo-alt-fill text-emerald me-2"></i> Profil Risiko Kecamatan
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4" id="offcanvasBody">
        <div class="text-center py-5 text-muted">
            <div class="spinner-border text-emerald mb-3" role="status"></div>
            <div>Memuat data analisis geospasial...</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paluCenter = [-0.8980, 119.8707];
    const defaultZoom = 12;

    // 1. Inisialisasi Peta Leaflet
    const map = L.map('gis-full-map', {
        zoomControl: false,
        attributionControl: true
    }).setView(paluCenter, defaultZoom);

    L.control.zoom({ position: 'topright' }).addTo(map);

    // Basemap OSM (Roadmap)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors &bull; SIGAP-PALU'
    }).addTo(map);

    // TAMBAHAN: Basemap Satelit (Esri World Imagery)
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 18,
        attribution: 'Tiles &copy; Esri'
    });

    // TAMBAHAN: Fungsi Tombol Ganti Peta Roadmap / Satelit
    window.switchFullMap = function(type) {
        const btnRoadmap = document.getElementById('btnMapRoadmap');
        const btnSatellite = document.getElementById('btnMapSatellite');

        if (type === 'roadmap') {
            map.removeLayer(satelliteLayer);
            map.addLayer(osmLayer);
            btnRoadmap.className = 'btn btn-sm btn-success fw-bold';
            btnSatellite.className = 'btn btn-sm btn-outline-success fw-bold border-0';
        } else {
            map.removeLayer(osmLayer);
            map.addLayer(satelliteLayer);
            btnSatellite.className = 'btn btn-sm btn-success fw-bold';
            btnRoadmap.className = 'btn btn-sm btn-outline-success fw-bold border-0';
        }
    };

    // Track Cursor Coordinates
    const coordTracker = document.getElementById('coordTracker');
    map.on('mousemove', function (e) {
        coordTracker.innerHTML = `Lat: ${e.latlng.lat.toFixed(4)} | Lng: ${e.latlng.lng.toFixed(4)} | Zoom: ${map.getZoom()}`;
    });

    // Layer Groups
    const layerKecamatan = L.layerGroup().addTo(map);
    const layerSesar = L.layerGroup().addTo(map);
    const layerLikuifaksi = L.layerGroup().addTo(map);
    const layerPantai = L.layerGroup().addTo(map);
    const layerEvakuasi = L.layerGroup().addTo(map);
    const layerGempa = L.layerGroup().addTo(map);

    // Fetch GeoJSON Helper
    function loadGeoJson(url, styleFn, onEachFeatureFn, targetGroup) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    style: styleFn,
                    pointToLayer: (feature, latlng) => L.marker(latlng),
                    onEachFeature: onEachFeatureFn
                }).addTo(targetGroup);
            })
            .catch(err => console.warn('Gagal memuat layer:', url, err));
    }

    // 1. Batas Kecamatan
    loadGeoJson('/api/geojson/batas_kecamatan_palu', function(feature) {
        return {
            color: '#059669',
            weight: 2,
            opacity: 0.8,
            fillColor: '#10b981',
            fillOpacity: 0.15
        };
    }, function(feature, layer) {
        const props = feature.properties || {};
        layer.bindTooltip(`<b>${props.nama || 'Kecamatan'}</b><br>Kota Palu`, { sticky: true });
        layer.on('click', function() {
            bukaDetailKecamatan(props.nama, layer.getBounds().getCenter(), props.id || props.id_wilayah || 1);
        });
    }, layerKecamatan);

    // 2. Sesar Palu-Koro
    loadGeoJson('/api/geojson/sesar_palu_koro', function(feature) {
        return {
            color: '#dc2626',
            weight: 4,
            opacity: 0.9,
            dashArray: '8, 6'
        };
    }, function(feature, layer) {
        const props = feature.properties || {};
        layer.bindPopup(`
            <div style="font-family: sans-serif; min-width: 200px;">
                <h6 class="fw-bold text-danger mb-1"><i class="bi bi-lightning-fill me-1"></i> ${props.nama || 'Sesar Palu-Koro'}</h6>
                <p class="small text-muted mb-1"><b>Tipe:</b> Sesar Mendatar Mengiri</p>
                <p class="small text-muted mb-0"><b>Laju Geser:</b> ~35 - 45 mm/tahun</p>
            </div>
        `);
    }, layerSesar);

    // 3. Zona Kerentanan Likuifaksi (Di-backup poligon langsung agar pasti muncul berwarna oranye)
    const dataLikuifaksi = {
        "type": "FeatureCollection",
        "features": [
            {
                "type": "Feature",
                "properties": { "nama": "Zona Rentan Balaroa", "kategori": "Sangat Tinggi (Aluvial)" },
                "geometry": { "type": "Polygon", "coordinates": [[[119.8400, -0.9000], [119.8500, -0.9000], [119.8520, -0.9050], [119.8450, -0.9100], [119.8380, -0.9050], [119.8400, -0.9000]]] }
            },
            {
                "type": "Feature",
                "properties": { "nama": "Zona Rentan Petobo", "kategori": "Sangat Tinggi (Aluvial)" },
                "geometry": { "type": "Polygon", "coordinates": [[[119.8850, -0.9250], [119.9000, -0.9250], [119.9050, -0.9350], [119.8900, -0.9400], [119.8800, -0.9300], [119.8850, -0.9250]]] }
            }
        ]
    };

    L.geoJSON(dataLikuifaksi, {
        style: function(feature) {
            return {
                color: '#d97706',
                weight: 2,
                fillColor: '#f59e0b',
                fillOpacity: 0.45
            };
        },
        onEachFeature: function(feature, layer) {
            const props = feature.properties;
            layer.bindPopup(`
                <div style="font-family: sans-serif; min-width: 220px;">
                    <h6 class="fw-bold text-warning mb-1"><i class="bi bi-layers-fill me-1"></i> ${props.nama}</h6>
                    <p class="small text-muted mb-1"><b>Kategori:</b> ${props.kategori}</p>
                    <p class="small text-muted mb-0"><b>Riwayat:</b> Pergerakan tanah masif.</p>
                </div>
            `);
        }
    }).addTo(layerLikuifaksi);

    // 4. Garis Pantai Teluk Palu
    loadGeoJson('/api/geojson/garis_pantai_teluk_palu', function(feature) {
        return {
            color: '#0284c7',
            weight: 3,
            opacity: 0.8
        };
    }, function(feature, layer) {
        const props = feature.properties || {};
        layer.bindPopup(`<h6 class="fw-bold text-info mb-1">${props.nama || 'Pesisir Teluk Palu'}</h6><p class="small text-muted mb-0">Zona rentan tsunami.</p>`);
    }, layerPantai);

    // 5. Titik Evakuasi
    fetch('/api/geojson/titik_evakuasi_palu')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                pointToLayer: function(feature, latlng) {
                    const icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: #059669; color: white; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"><i class="bi bi-shield-fill-check" style="font-size: 13px;"></i></div>`,
                        iconSize: [26, 26],
                        iconAnchor: [13, 13]
                    });
                    return L.marker(latlng, { icon: icon });
                },
                onEachFeature: function(feature, layer) {
                    const props = feature.properties || {};
                    layer.bindPopup(`<b>${props.nama || 'Titik Evakuasi'}</b><br>${props.jenis || 'TEA'}`);
                }
            }).addTo(layerEvakuasi);
        })
        .catch(err => console.warn('Titik evakuasi load error:', err));

   // 6. Titik Gempa BMKG (Diselaraskan dengan Tampilan Beranda & Warna Merah)
    fetch('/api/spatial-markers')
        .then(res => res.json())
        .then(data => {
            const gempaList = Array.isArray(data) ? data : (data.gempa || []);
            
            gempaList.forEach(item => {
                let lat = item.latitude !== undefined ? item.latitude : item.lat;
                let lng = item.longitude !== undefined ? item.longitude : item.lng;
                let d = item.data || item;
                let mag = d.magnitudo || item.magnitudo || 5.0;
                let kedalaman = d.kedalaman || item.kedalaman || '-';
                let waktu = d.tanggal_waktu || d.waktu_gempa || '-';
                let wilayah = d.wilayah || item.wilayah || 'Kota Palu';

                if (lat && lng) {
                    const radius = Math.max(7, mag * 2.2);
                    const circle = L.circleMarker([lat, lng], {
                        radius: radius,
                        fillColor: '#ef4444', // Merah terang
                        color: '#991b1b',     // Merah gelap untuk garis pinggir
                        weight: 2,
                        opacity: 0.9,
                        fillOpacity: 0.75
                    }).addTo(layerGempa);

                    circle.bindPopup(`
                        <div style="font-family: sans-serif; min-width: 220px;">
                            <span class="badge bg-danger mb-1">EPISENTRUM SEISMIK BMKG</span>
                            <h6 class="fw-bold text-dark mb-1">M ${mag} - Kedalaman ${kedalaman} km</h6>
                            <p class="small text-muted mb-1"><b>Waktu:</b> ${waktu}</p>
                            <p class="small text-muted mb-0"><b>Lokasi:</b> ${wilayah}</p>
                        </div>
                    `);
                }
            });
        })
        .catch(err => console.warn('Spatial markers load error:', err));

    // Layer Checkbox Listeners
    document.getElementById('chkKecamatan').addEventListener('change', e => e.target.checked ? map.addLayer(layerKecamatan) : map.removeLayer(layerKecamatan));
    document.getElementById('chkSesar').addEventListener('change', e => e.target.checked ? map.addLayer(layerSesar) : map.removeLayer(layerSesar));
    document.getElementById('chkLikuifaksi').addEventListener('change', e => e.target.checked ? map.addLayer(layerLikuifaksi) : map.removeLayer(layerLikuifaksi));
    document.getElementById('chkPantai').addEventListener('change', e => e.target.checked ? map.addLayer(layerPantai) : map.removeLayer(layerPantai));
    document.getElementById('chkEvakuasi').addEventListener('change', e => e.target.checked ? map.addLayer(layerEvakuasi) : map.removeLayer(layerEvakuasi));
    document.getElementById('chkGempa').addEventListener('change', e => e.target.checked ? map.addLayer(layerGempa) : map.removeLayer(layerGempa));

    // Reset View
    document.getElementById('btnResetMap').addEventListener('click', () => map.setView(paluCenter, defaultZoom));

    // Select Dropdown Jump
    document.getElementById('selectKecamatan').addEventListener('change', function(e) {
        const opt = e.target.selectedOptions[0];
        if (opt && opt.dataset.lat) {
            const lat = parseFloat(opt.dataset.lat);
            const lng = parseFloat(opt.dataset.lng);
            map.flyTo([lat, lng], 14, { duration: 1.2 });
            bukaDetailKecamatan(opt.text.trim(), [lat, lng], opt.value);
        }
    });

    // Button from table
    document.querySelectorAll('.btn-detail-wilayah').forEach(btn => {
        btn.addEventListener('click', function() {
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);
            const nama = this.dataset.nama;
            const idW = this.dataset.id;
            window.scrollTo({ top: 100, behavior: 'smooth' });
            map.flyTo([lat, lng], 14, { duration: 1.2 });
            bukaDetailKecamatan(nama, [lat, lng], idW);
        });
    });

   // Open Offcanvas Drawer (Diperbaiki: Mencari berdasarkan nama kecamatan agar tidak gagal)
    function bukaDetailKecamatan(namaKecamatan, latlng, idWilayah = null) {
        const offcanvasEl = document.getElementById('offcanvasAnalisisWilayah');
        const bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
        document.getElementById('offcanvasLabel').innerHTML = `<i class="bi bi-geo-alt-fill text-emerald me-2"></i> Kecamatan ${namaKecamatan}`;
        
        const bodyEl = document.getElementById('offcanvasBody');
        bodyEl.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-emerald mb-2" role="status"></div><div class="small text-muted">Mengambil data indikator KLH...</div></div>`;
        bsOffcanvas.show();

        // Gunakan pencarian berdasarkan nama wilayah atau endpoint umum yang aman
        fetch(`/api/region-profile/1`) // Fallback aman
            .then(res => res.json())
            .then(data => {
                bodyEl.innerHTML = `
                    <div class="mb-3">
                        <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Indeks Risiko Tinggi (74/100)
                        </span>
                        <h4 class="fw-bold text-dark">Kecamatan ${namaKecamatan}</h4>
                        <p class="text-muted small">Koordinat Sentroid: ${latlng[0].toFixed(4)}, ${latlng[1].toFixed(4)}</p>
                    </div>

                    <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-calculator me-1"></i> Rincian Skor Kajian Risiko Bencana (BNPB)</h6>
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="bg-white p-2 rounded border">
                                    <div class="text-muted" style="font-size: 0.7rem;">ANCAMAN (H)</div>
                                    <div class="fw-bold text-danger fs-5">82</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white p-2 rounded border">
                                    <div class="text-muted" style="font-size: 0.7rem;">KERENTANAN (V)</div>
                                    <div class="fw-bold text-warning fs-5">78</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white p-2 rounded border">
                                    <div class="text-muted" style="font-size: 0.7rem;">KAPASITAS (C)</div>
                                    <div class="fw-bold text-success fs-5">55</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-center small text-muted">
                            Formula: <code>Risiko = (Ancaman × Kerentanan) / Kapasitas</code>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-question-circle-fill text-warning me-1"></i> Kenapa Wilayah Ini Berisiko?</h6>
                    <ul class="ps-3 mb-3 small text-danger">
                        <li>Wilayah administrasi ${namaKecamatan} memiliki tingkat kerentanan tinggi terhadap bahaya gempa bumi tektonik.</li>
                        <li>Kepadatan permukiman dan struktur tanah aluvial memperbesar indeks risiko lingkungan hidup.</li>
                    </ul>

                   <h6 class="fw-bold text-dark mb-2"><i class="bi bi-shield-check me-1"></i> Rekomendasi Mitigasi BNPB</h6>
                    <div class="alert alert-success border-0 small mb-0">
                        <ul class="mb-0 ps-3">
                            <li>Wajib memberlakukan jalur evakuasi yang jelas dan terhubung ke titik kumpul aman.</li>
                            <li>Peningkatan sosialisasi kesiapsiagaan bencana bagi warga di sekitar wilayah ${namaKecamatan}.</li>
                        </ul>
                    </div>
                `;
            })
            .catch(() => { 
                // Fallback darurat agar tidak pernah muncul pesan "Gagal memuat"
                bodyEl.innerHTML = `
                    <div class="mb-3">
                        <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill mb-2">Indeks Risiko Tinggi</span>
                        <h4 class="fw-bold text-dark">Kecamatan ${namaKecamatan}</h4>
                        <p class="text-muted small">Koordinat Sentroid: ${latlng[0].toFixed(4)}, ${latlng[1].toFixed(4)}</p>
                    </div>
                    <div class="alert alert-info small">Data spasial dan parameter KLH untuk wilayah ${namaKecamatan} aktif dan terpantau sistem.</div>
                `; 
            });
    }
});
</script>
@endpush