@extends('layouts.public')

@section('title', 'Tentang SIGAP-PALU')

@section('content')
<!-- Header Banner -->
<section class="py-5 bg-dark text-white position-relative" style="background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%);">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold small mb-3">
                    <i class="bi bi-shield-check me-1"></i> Platform Mitigasi &amp; Kesiapsiagaan Wilayah
                </span>
                <h1 class="display-5 fw-bold mb-3">Tentang Sistem SIGAP-PALU</h1>
                <p class="lead text-light opacity-75 mb-0">
                    Sistem Informasi Monitoring Kesiapsiagaan dan Risiko Bencana Gempa Bumi dan Tsunami di Kota Palu — Dikembangkan sebagai platform analitis spasial dan mitigasi mandiri berbasis data terbuka resmi.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <i class="bi bi-diagram-3-fill text-white-50 display-1"></i>
            </div>
        </div>
    </div>
</section>

<!-- Content Body -->
<div class="container py-5">
    <!-- 3 Pilar Utama Sistem (Menggantikan 10 Kotak Kaku) -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="mb-3 text-success fs-3">
                    <i class="bi bi-cpu"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Simulasi Deterministik</h5>
                <p class="small text-muted mb-0 leading-relaxed">
                    Mesin pemodelan skenario mandiri untuk menguji dampak guncangan gempa (MMI), estimasi waktu tiba tsunami Teluk Palu, dan kerentanan likuifaksi lapisan aluvial secara real-time.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="mb-3 text-primary fs-3">
                    <i class="bi bi-map"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">WebGIS &amp; Spasial Risiko</h5>
                <p class="small text-muted mb-0 leading-relaxed">
                    Integrasi pemetaan digital untuk memantau trase Sesar Aktif Palu-Koro, zona rawan likuifaksi (seperti Petobo dan Balaroa), serta jalur dan titik evakuasi terdekat.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="mb-3 text-warning fs-3">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Dasbor Kesiapsiagaan Warga</h5>
                <p class="small text-muted mb-0 leading-relaxed">
                    Portal mandiri bagi warga dan peneliti untuk memantau profil risiko domisili tingkat kecamatan, mengunduh rekap laporan rekam jejak, serta panduan Tas Siaga Bencana (TSB).
                </p>
            </div>
        </div>
    </div>

    <!-- Rumus Ilmiah Box -->
    <div class="card border-0 bg-light rounded-4 p-4 p-md-5 mb-5 shadow-sm">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge bg-success text-white px-3 py-1 rounded-pill small fw-semibold mb-2">Metodologi Perhitungan</span>
                <h3 class="fw-bold text-dark">Matriks Risiko Bencana Wilayah</h3>
                <p class="text-muted leading-relaxed mb-3">
                    Dalam standar penanggulangan bencana modern, tingkat risiko tidak hanya diukur dari kekuatan goncangan bumi (bahaya fisik semata), tetapi merupakan fungsi komprehensif dari kerentanan penduduk serta kapasitas kelembagaan masyarakat:
                </p>
                <div class="p-3 bg-white rounded-3 border text-center shadow-sm mb-3">
                    <div class="fs-4 fw-bold text-success font-monospace mb-1">
                        Risiko = (Ancaman × Kerentanan) / Kapasitas
                    </div>
                    <div class="small text-muted">Formula Baku Standar Perka BNPB No. 2 Tahun 2012</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded-3 border">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders text-success me-2"></i>Komponen Pembobotan Indikator:</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                            <span><b>Ancaman (Hazard / H):</b> Jarak Sesar Palu-Koro, Riwayat MMI, Elevasi Pantai</span>
                            <span class="badge bg-danger">Bobot 40%</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                            <span><b>Kerentanan (Vulnerability / V):</b> Kepadatan Penduduk, Struktur Tanah Aluvial, Lansia/Balita</span>
                            <span class="badge bg-warning text-dark">Bobot 35%</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                            <span><b>Kapasitas (Capacity / C):</b> Titik Evakuasi Akhir, Sirine Peringatan, Relawan Tangguh</span>
                            <span class="badge bg-success">Bobot 25%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Source Transparency -->
    <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm">
        <h5 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle-fill text-info me-2"></i> Transparansi Sumber Data &amp; Maklumat Sistem</h5>
        <p class="small text-muted mb-0 leading-relaxed">
            SIGAP-PALU memanfaatkan data terbuka resmi dari instansi berwenang seperti BMKG (Badan Meteorologi, Klimatologi, dan Geofisika), Badan Informasi Geospasial (BIG), Pusat Studi Gempa Nasional (PuSGeN), dan BPBD Kota Palu. SIGAP-PALU tidak menggantikan otoritas resmi pemerintah dalam mengeluarkan peringatan dini darurat nasional.
        </p>
    </div>
</div>
@endsection