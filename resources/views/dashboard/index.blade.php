@extends('layouts.app')
@section('title', 'Dashboard Monitoring')

@section('content')
<!-- 6 SUMMARY METRIC CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Tingkat Risiko Kota</small>
            <h4 class="fw-bold my-1 text-warning">SEDANG</h4>
            <span class="badge badge-sedang small">Indeks Komposit</span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Tingkat Kesiapsiagaan</small>
            <h4 class="fw-bold my-1 text-success">BAIK</h4>
            <span class="badge badge-rendah small">Skor 78% Wilayah</span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Gempa Terbaru (BMKG)</small>
            <h4 class="fw-bold my-1 text-danger">M 3.2</h4>
            <small class="text-muted" style="font-size: 0.72rem;">12 km TL Palu (10 km)</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Muka Laut (Simulasi)</small>
            <h4 class="fw-bold my-1 text-info">1.21 m</h4>
            <span class="badge bg-light text-dark border small">Stasiun Pantoloan</span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Wilayah Dipantau</small>
            <h4 class="fw-bold my-1 text-dark">8 Wilayah</h4>
            <small class="text-muted" style="font-size: 0.75rem;">Kecamatan Terdata</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card-custom p-3">
            <small class="text-muted fw-semibold">Peringatan Aktif</small>
            <h4 class="fw-bold my-1 text-primary">1</h4>
            <span class="badge bg-warning-subtle text-warning border small">Level Waspada</span>
        </div>
    </div>
</div>

<!-- LEAFLET MAP & TABEL STATUS WILAYAH -->
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2 text-teal"></i>Peta Monitoring Risiko Bencana Kota Palu</h6>
                <div class="d-flex gap-2 small">
                    <span><i class="bi bi-circle-fill text-danger"></i> Tinggi</span>
                    <span><i class="bi bi-circle-fill text-warning"></i> Sedang</span>
                    <span><i class="bi bi-circle-fill text-success"></i> Rendah</span>
                </div>
            </div>
            <div id="mapMonitoring" style="height: 440px; border-radius: 8px;"></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-custom p-3 h-100 d-flex flex-column">
            <h6 class="fw-bold mb-3"><i class="bi bi-shield-check me-2"></i>Status Risiko Wilayah Terkini</h6>
            <div class="table-responsive flex-grow-1">
                <table class="table table-sm align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th>Kecamatan</th>
                            <th>Risiko</th>
                            <th>Kesiapsiagaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wilayah as $w)
                        <tr>
                            <td class="fw-semibold">{{ $w['nama'] }}</td>
                            <td><span class="badge badge-{{ strtolower($w['risiko']) }}">{{ $w['risiko'] }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $w['kesiapsiagaan'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-2 mt-2 bg-light rounded border" style="font-size: 0.78rem;">
                <strong>Interpretasi Sistem:</strong> Analisis potensi dihitung dari indeks kerentanan dan kapasitas evakuasi koridor Lembah Palu.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const map = L.map('mapMonitoring').setView([-0.8917, 119.8707], 11);
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
    const dataWilayah = @json($wilayah);
    dataWilayah.forEach(item => {
        let color = item.risiko === 'Tinggi' ? '#ef4444' : (item.risiko === 'Sedang' ? '#f59e0b' : '#10b981');
        L.circleMarker([item.lat, item.lng], {
            radius: 9,
            fillColor: color,
            color: '#ffffff',
            weight: 2,
            fillOpacity: 0.9
        }).addTo(map).bindPopup(`
            <div style="font-size: 0.85rem;">
                <strong>${item.nama}</strong><br>
                Tingkat Risiko: <b>${item.risiko}</b><br>
                Kesiapsiagaan: ${item.kesiapsiagaan}<br>
                Ancaman: ${item.ancaman} | Kerentanan: ${item.kerentanan}
            </div>
        `);
    });
</script>
@endpush