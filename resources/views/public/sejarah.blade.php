@extends('layouts.public')

@section('title', 'Sejarah Bencana 28 September 2018 Kota Palu - SIGAP-PALU')

@section('content')
<!-- Header Banner -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container position-relative py-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-semibold small mb-3">
                    <i class="bi bi-clock-history me-1"></i> Dokumentasi &amp; Pembelajaran Ilmiah KLH
                </span>
                <h1 class="display-5 fw-bold mb-3">Tragedi 28 September 2018: Titik Balik Mitigasi Bencana Palu</h1>
                <p class="lead text-light opacity-75 mb-4">
                    Gempa Mw 7.4, Tsunami Kilat Teluk Palu, dan Likuifaksi Masif — Analisis ilmiah multi-hazard terkompleks dalam sejarah modern Indonesia sebagai pijakan kajian lingkungan dan tata ruang masa depan.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#kronologi" class="btn btn-emerald px-4 py-2 rounded-pill fw-semibold shadow-sm">
                        <i class="bi bi-arrow-down me-1"></i> Telusuri Kronologi
                    </a>
                    <a href="#analisis-ilmiah" class="btn btn-outline-light px-4 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Analisis Tiga Bahaya
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                    <div class="display-3 fw-bold text-danger mb-0">Mw 7.4</div>
                    <div class="fw-semibold text-light">Magnitudo Gempa Utama</div>
                    <hr class="border-secondary my-3">
                    <div class="row text-center g-2">
                        <div class="col-6">
                            <div class="fs-4 fw-bold text-warning">3 - 8 Menit</div>
                            <div class="small text-muted">Kedatangan Tsunami</div>
                        </div>
                        <div class="col-6">
                            <div class="fs-4 fw-bold text-emerald">4.340+</div>
                            <div class="small text-muted">Korban Jiwa / Hilang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ringkasan Statistik -->
<section class="py-4 bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="p-3">
                    <div class="text-danger fs-2 fw-bold mb-1"><i class="bi bi-activity me-1"></i> 7.4 Mw</div>
                    <div class="text-muted small">Gempa Sesar Palu-Koro (18:02:44 WITA)</div>
                </div>
            </div>
            <div class="col-6 col-md-3 border-start">
                <div class="p-3">
                    <div class="text-info fs-2 fw-bold mb-1"><i class="bi bi-water me-1"></i> 4 - 11.3 m</div>
                    <div class="text-muted small">Tinggi Run-up Gelombang Tsunami</div>
                </div>
            </div>
            <div class="col-6 col-md-3 border-start">
                <div class="p-3">
                    <div class="text-warning fs-2 fw-bold mb-1"><i class="bi bi-layers-fill me-1"></i> &gt; 350 Ha</div>
                    <div class="text-muted small">Lahan Ambles Akibat Likuifaksi Masif</div>
                </div>
            </div>
            <div class="col-6 col-md-3 border-start">
                <div class="p-3">
                    <div class="text-secondary fs-2 fw-bold mb-1"><i class="bi bi-house-slash me-1"></i> 68.451</div>
                    <div class="text-muted small">Rumah Rusak Berat &amp; Hilang</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Sidebar Quick Nav -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h6 class="fw-bold text-dark px-2 mb-3">
                        <i class="bi bi-compass text-emerald me-1"></i> Daftar Isi Kajian
                    </h6>
                    <nav class="nav flex-column small">
                        <a class="nav-link py-2 text-dark rounded-2" href="#kronologi"><i class="bi bi-chevron-right me-1 text-muted"></i> 1. Kronologi 28 September</a>
                        <a class="nav-link py-2 text-dark rounded-2" href="#gempa-palukoro"><i class="bi bi-chevron-right me-1 text-muted"></i> 2. Mekanisme Gempa Palu-Koro</a>
                        <a class="nav-link py-2 text-dark rounded-2" href="#tsunami-telukpalu"><i class="bi bi-chevron-right me-1 text-muted"></i> 3. Misteri Tsunami Cepat Teluk Palu</a>
                        <a class="nav-link py-2 text-dark rounded-2" href="#likuifaksi-aluvial"><i class="bi bi-chevron-right me-1 text-muted"></i> 4. Likuifaksi Petobo &amp; Balaroa</a>
                        <a class="nav-link py-2 text-dark rounded-2" href="#pembelajaran-klh"><i class="bi bi-chevron-right me-1 text-muted"></i> 5. Implikasi Tata Ruang &amp; KLH</a>
                    </nav>

                    <div class="alert alert-info border-0 rounded-3 small mt-4 mb-0">
                        <i class="bi bi-info-circle-fill me-1"></i> <b>Kajian Lingkungan:</b> Dokumen ini disusun sebagai acuan akademis evaluasi daya dukung dan daya tampung lingkungan hidup Kota Palu.
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Articles -->
        <div class="col-lg-9">
            <!-- 1. Kronologi -->
            <section id="kronologi" class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-danger rounded-pill px-3 py-2">Fase Kejadian</span>
                    <h3 class="fw-bold text-dark mb-0">1. Kronologi Bencana 28 September 2018</h3>
                </div>
                <p class="text-muted leading-relaxed">
                    Rangkaian peristiwa seismik tanggal 28 September 2018 di Sulawesi Tengah diawali sejak siang hari dan memuncak pada senja yang mengubah secara drastis bentang alam geologis Kota Palu dan sekitarnya:
                </p>

                <div class="position-relative border-start border-3 border-emerald ps-4 my-4 d-flex flex-column gap-4">
                    <div class="position-relative">
                        <div class="position-absolute" style="left: -33px; top: 0; width: 18px; height: 18px; background: #059669; border: 3px solid #ffffff; border-radius: 50%;"></div>
                        <span class="badge bg-secondary-subtle text-secondary small mb-1">14:00:00 WITA &bull; Gempa Pembuka (Foreshock)</span>
                        <h5 class="fw-bold text-dark mb-1">Gempa Awal M 6.0 di Donggala</h5>
                        <p class="text-muted small mb-0">
                            Gempa pertama berpusat di darat sekitar 26 km utara Donggala dengan kedalaman 10 km. Menimbulkan kerusakan awal pada beberapa bangunan rumah di pesisir barat Sulawesi Tengah dan menimbulkan kepanikan warga.
                        </p>
                    </div>

                    <div class="position-relative">
                        <div class="position-absolute" style="left: -33px; top: 0; width: 18px; height: 18px; background: #dc2626; border: 3px solid #ffffff; border-radius: 50%;"></div>
                        <span class="badge bg-danger text-white small mb-1">18:02:44 WITA &bull; Gempa Utama (Mainshock)</span>
                        <h5 class="fw-bold text-danger mb-1">Patahan Sesar Palu-Koro Pecah: Mw 7.4</h5>
                        <p class="text-muted small mb-0">
                            Pelepasan energi tektonik dahsyat terjadi di sepanjang segmen patahan Palu-Koro sepanjang ±150 km. Patahan bergerak mengiri (sinistral) hingga sejauh 4–7 meter dalam waktu kurang dari 30 detik dengan intensitas guncangan VIII-IX MMI. Jembatan Palu IV (Ponulele) runtuh seketika.
                        </p>
                    </div>

                    <div class="position-relative">
                        <div class="position-absolute" style="left: -33px; top: 0; width: 18px; height: 18px; background: #0284c7; border: 3px solid #ffffff; border-radius: 50%;"></div>
                        <span class="badge bg-info-subtle text-info small mb-1">18:06:00 - 18:10:00 WITA &bull; Tsunami Kilat</span>
                        <h5 class="fw-bold text-info mb-1">Gelombang Tsunami Menghempas Teluk Palu</h5>
                        <p class="text-muted small mb-0">
                            Hanya 3 hingga 8 menit pasca-guncangan utama, gelombang tsunami menghantam bibir pantai Talise, Pantoloan, Lere, dan sekitarnya dengan ketinggian mencapai 4 hingga 11.3 meter. Warga yang berada di festival Palu Nomoni di pesisir pantai tidak sempat menerima evakuasi.
                        </p>
                    </div>

                    <div class="position-relative">
                        <div class="position-absolute" style="left: -33px; top: 0; width: 18px; height: 18px; background: #d97706; border: 3px solid #ffffff; border-radius: 50%;"></div>
                        <span class="badge bg-warning-subtle text-warning small mb-1">18:05:00 - 18:30:00 WITA &bull; Tanah Mencair</span>
                        <h5 class="fw-bold text-warning mb-1">Likuifaksi Aliran (Flow Liquefaction) Masif</h5>
                        <p class="text-muted small mb-0">
                            Lapisan tanah pasir jenuh air di Petobo, Balaroa, Jono Oge, dan Sibalaya kehilangan daya dukung akibat tekanan air pori tinggi dari guncangan gempa. Ratusan hektar daratan berubah wujud menjadi bubur lumpur yang mengalir membawa ribuan rumah beserta isinya.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 2. Sesar Palu-Koro -->
            <section id="gempa-palukoro" class="mb-5 pt-3 border-top">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-danger rounded-pill px-3 py-2">Geologi Tektonik</span>
                    <h3 class="fw-bold text-dark mb-0">2. Karakteristik Sesar Palu-Koro</h3>
                </div>
                <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h5 class="fw-bold text-dark mb-2">Patahan Paling Cepat dan Aktif di Daratan Indonesia</h5>
                            <p class="text-muted small mb-3 leading-relaxed">
                                Sesar Palu-Koro merupakan sesar geser mengiri (sinistral strike-slip) yang membentang lebih dari 500 km dari Selat Makassar, membelah lembah Kota Palu, Danau Lindu, hingga menyambung ke Sesar Matano di Teluk Bone.
                            </p>
                            <ul class="list-unstyled small text-muted d-flex flex-column gap-2 mb-0">
                                <li><i class="bi bi-check-circle-fill text-danger me-2"></i><b>Laju Pergeseran (Slip Rate):</b> Sekitar 35 hingga 45 milimeter per tahun.</li>
                                <li><i class="bi bi-check-circle-fill text-danger me-2"></i><b>Kecepatan Ruptur:</b> Mengalami fenomena <em>supershear</em> (kecepatan retakan melebihi kecepatan gelombang geser seismik ~4.1 km/detik).</li>
                                <li><i class="bi bi-check-circle-fill text-danger me-2"></i><b>Offset Horizontal 2018:</b> Pergeseran fisik tanah mencapai rata-rata 4.5 hingga 5.8 meter di sepanjang Kota Palu.</li>
                            </ul>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0 text-center">
                            <div class="p-3 bg-white rounded-3 border shadow-sm text-start">
                                <div class="small fw-bold text-muted text-uppercase mb-1">Zona Bahaya Patahan</div>
                                <div class="fw-bold text-danger fs-5 mb-2">Zona Sempadan Sesar Aktif</div>
                                <p class="small text-muted mb-2">Berdasarkan Peta ZRB Kementerian ATR/BPN, koridor 50-100 meter kiri-kanan jejak retakan permukaan sesar ditetapkan sebagai <b>Zona Terlarang Bangun</b> permanen.</p>
                                <a href="{{ route('public.peta') }}" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                    <i class="bi bi-map me-1"></i> Tampilkan Garis Sesar di WebGIS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Tsunami Teluk Palu -->
            <section id="tsunami-telukpalu" class="mb-5 pt-3 border-top">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">Oseanografi &amp; Pesisir</span>
                    <h3 class="fw-bold text-dark mb-0">3. Misteri Tsunami Cepat di Teluk Palu</h3>
                </div>
                <p class="text-muted leading-relaxed">
                    Secara teoritis, gempa bumi dengan mekanisme sesar mendatar (strike-slip) jarang memicu tsunami dahsyat karena tidak menimbulkan pergeseran vertikal kolom air laut yang signifikan. Namun kejadian 28 September di Teluk Palu menghasilkan anomali gelombang tinggi dengan waktu kedatangan (arrival time) yang sangat singkat (3 - 8 menit).
                </p>

                <div class="row g-4 my-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="p-2 bg-info-subtle text-info rounded-3"><i class="bi bi-water fs-4"></i></div>
                                <h6 class="fw-bold text-dark mb-0">Longsoran Bawah Laut (Submarine Landslide)</h6>
                            </div>
                            <p class="small text-muted mb-0 leading-relaxed">
                                Survei batimetri multibeam pasca-bencana oleh BIG, BPPT, dan tim internasional mengonfirmasi adanya sedimentasi tebal di tebing curam bawah laut Teluk Palu yang runtuh akibat guncangan gempa (liquefied submarine slope failure). Runtuhan material ratusan juta meter kubik inilah sumber utama gelombang tsunami lokal berketinggian ekstrem.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="p-2 bg-primary-subtle text-primary rounded-3"><i class="bi bi-funnel fs-4"></i></div>
                                <h6 class="fw-bold text-dark mb-0">Efek Penyempitan Teluk (Funneling Effect)</h6>
                            </div>
                            <p class="small text-muted mb-0 leading-relaxed">
                                Morfologi Teluk Palu yang berbentuk corong sempit memanjang (panjang ±30 km dan lebar mengerucut dari 7 km di mulut teluk menjadi 3 km di pusat kota) mengamplifikasi energi gelombang laut, sehingga tinggi genangan (run-up) berlipat ganda saat menyentuh daratan pesisir Palu Barat dan Mantikulore.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Likuifaksi Masif -->
            <section id="likuifaksi-aluvial" class="mb-5 pt-3 border-top">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Geoteknik &amp; Hidrologi</span>
                    <h3 class="fw-bold text-dark mb-0">4. Tragedi Likuifaksi Petobo, Balaroa &amp; Jono Oge</h3>
                </div>
                <p class="text-muted leading-relaxed">
                    Likuifaksi di Lembah Palu tercatat sebagai salah satu peristiwa <em>flow slide</em> paling merusak di dunia. Struktur geologi lembah Palu tersusun atas endapan aluvial Kuarter muda yang belum terkonsolidasi sempurna, berupa pasir lepas jenuh air dengan kedalaman muka air tanah kurang dari 2-5 meter.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <div class="fw-bold text-dark mb-1"><i class="bi bi-geo-alt text-warning me-1"></i> Likuifaksi Petobo (Palu Selatan)</div>
                            <p class="small text-muted mb-0">
                                Aliran lumpur (mudflow) menerjang sekitar 180 hektar permukiman padat penduduk. Dipicu oleh keberadaan saluran irigasi Gumbasa yang membasahi lapisan tanah permeabel di lereng atas, menyebabkan pergerakan massa tanah sejauh hampir 1.5 kilometer dengan kemiringan lereng hanya 1.5–2.5 derajat.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-white">
                            <div class="fw-bold text-dark mb-1"><i class="bi bi-geo-alt text-warning me-1"></i> Likuifaksi Balaroa (Palu Barat)</div>
                            <p class="small text-muted mb-0">
                                Mengalami peristiwa amblasan dan pengangkatan simultan (lateral spreading &amp; graben formation). Sekitar 47 hektar kompleks perumahan Balaroa amblas hingga kedalaman 5–8 meter ke dalam cekungan tanah, sementara sebagian lainnya terangkat ke atas setinggi bangunan dua lantai.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. Pembelajaran KLH & Tata Ruang -->
            <section id="pembelajaran-klh" class="pt-3 border-top">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-emerald text-white rounded-pill px-3 py-2">Kajian Lingkungan Hidup (KLH)</span>
                    <h3 class="fw-bold text-dark mb-0">5. Implikasi Kebijakan Tata Ruang &amp; Rekomendasi KLH</h3>
                </div>
                <div class="card border-0 bg-success-subtle rounded-4 p-4">
                    <h5 class="fw-bold text-success mb-3">Integrasi Peta Risiko dalam Revisi RTRW Kota Palu</h5>
                    <p class="text-dark small leading-relaxed mb-3">
                        Pelajaran berharga dari 28 September 2018 membuktikan bahwa pembangunan permukiman dan infrastruktur tidak boleh lagi mengabaikan daya dukung lingkungan geologis (carrying capacity). SIGAP-PALU merekomendasikan pilar-pilar KLH berikut:
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="fw-bold text-dark small mb-1"><i class="bi bi-shield-slash text-danger me-1"></i> Penegakan Zona Rawan Bencana 4 (ZRB 4)</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    Kawasan Petobo, Balaroa terlikuifaksi, dan sempadan patahan aktif Palu-Koro tidak boleh dihuni kembali sebagai kawasan residensial, melainkan dialihfungsikan menjadi Ruang Terbuka Hijau (RTH), hutan kota, dan monumen peringatan bencana.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="fw-bold text-dark small mb-1"><i class="bi bi-building-check text-emerald me-1"></i> Penataan Hunian Tetap (Huntap) di Dataran Tinggi</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    Relokasi warga korban ke kawasan perbukitan yang memiliki batuan dasar metamorfik kokoh (seperti Huntap Duyu, Tondo, Talise) dengan pemenuhan daya tampung air bersih dan sanitasi berkelanjutan.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="fw-bold text-dark small mb-1"><i class="bi bi-trees text-success me-1"></i> Sabuk Hijau Pesisir (Coastal Greenbelt)</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    Penanaman mangrove dan vegetasi pantai tahan salinitas sepanjang 100-200 meter dari pasang tertinggi untuk memecah energi kinetik gelombang tsunami masa depan.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <div class="fw-bold text-dark small mb-1"><i class="bi bi-diagram-3 text-info me-1"></i> Sistem Monitoring Lingkungan Terpadu</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    Penguatan jaringan seismograf BMKG, stasiun pasang surut Pantoloan BIG, sumur pantau muka air tanah, dan instrumen piezometer untuk deteksi dini risiko multi-hazard secara transparan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
