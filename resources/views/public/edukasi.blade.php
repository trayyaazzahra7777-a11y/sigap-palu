@extends('layouts.public')

@section('title', 'Pusat Edukasi Kebencanaan - SIGAP-PALU')

@section('content')
<!-- Header Banner -->
<section class="py-5 bg-dark text-white position-relative" style="background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%);">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle px-3 py-2 rounded-pill fw-semibold small mb-3">
                    <i class="bi bi-book-half me-1"></i> Pusat Literasi Kebencanaan Geologis
                </span>
                <h1 class="display-5 fw-bold mb-3">Pusat Edukasi &amp; Pengetahuan Kebencanaan</h1>
                <p class="lead text-light opacity-75 mb-0">
                    Memahami sains di balik fenomena gempa bumi, tsunami kilat, likuifaksi masif, dan sesar aktif Palu-Koro untuk membangun ketangguhan masyarakat Palu berbasis sains dan kajian lingkungan hidup.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <i class="bi bi-mortarboard-fill text-white-50 display-1"></i>
            </div>
        </div>
    </div>
</section>

<!-- Nav Tabs Topik Utama -->
<div class="bg-white border-bottom sticky-top" style="top: 72px; z-index: 99;">
    <div class="container">
        <ul class="nav nav-pills nav-fill py-2 gap-2" id="edukasiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-semibold" id="gempa-tab" data-bs-toggle="tab" data-bs-target="#tab-gempa" type="button" role="tab">
                    <i class="bi bi-activity me-1"></i> Gempa Bumi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold" id="tsunami-tab" data-bs-toggle="tab" data-bs-target="#tab-tsunami" type="button" role="tab">
                    <i class="bi bi-water me-1"></i> Tsunami
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold" id="likuifaksi-tab" data-bs-toggle="tab" data-bs-target="#tab-likuifaksi" type="button" role="tab">
                    <i class="bi bi-layers-fill me-1"></i> Likuifaksi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold" id="sesar-tab" data-bs-toggle="tab" data-bs-target="#tab-sesar" type="button" role="tab">
                    <i class="bi bi-slash-lg me-1"></i> Sesar Palu-Koro
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold" id="kamus-tab" data-bs-toggle="tab" data-bs-target="#tab-kamus" type="button" role="tab">
                    <i class="bi bi-card-text me-1"></i> Kamus Istilah
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Tab Content -->
<div class="container py-5">
    <div class="tab-content" id="edukasiTabContent">
        <!-- TAB 1: GEMPA BUMI -->
        <div class="tab-pane fade show active" id="tab-gempa" role="tabpanel">
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-7">
                    <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill small fw-semibold mb-2">Bahaya Primer Geologis</span>
                    <h2 class="fw-bold text-dark">Apa Itu Gempa Bumi Tektonik?</h2>
                    <p class="text-muted leading-relaxed">
                        Gempa bumi tektonik adalah pelepasan energi gelombang seismik secara tiba-tiba akibat deformasi dan pergeseran lempeng atau batuan pada kerak bumi di sepanjang bidang sesar (fault). Kota Palu terletak tepat di atas persimpangan tiga lempeng tektonik utama dunia (Indo-Australia, Eurasia, dan Pasifik-Laut Filipina).
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <h6 class="fw-bold text-dark mb-1"><i class="bi bi-aspect-ratio text-danger me-1"></i> Magnitudo (M)</h6>
                                <p class="small text-muted mb-0">Ukuran kuantitatif total energi yang dilepaskan di pusat gempa (hiposentrum), diukur dengan seismograf (skala Moment Magnitude / Mw).</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <h6 class="fw-bold text-dark mb-1"><i class="bi bi-speedometer text-warning me-1"></i> Intensitas (MMI)</h6>
                                <p class="small text-muted mb-0">Ukuran dampak guncangan yang dirasakan manusia dan kerusakan fisik bangunan di lokasi tertentu (Modified Mercalli Intensity I - XII).</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-shield-check text-emerald me-1"></i> Prinsip Tindakan Saat Gempa:</h6>
                        <div class="d-flex gap-3 align-items-start mb-3">
                            <div class="p-2 bg-success-subtle text-success rounded-3 fw-bold fs-5 px-3">1</div>
                            <div>
                                <strong class="text-dark">DROP (Merunduk)</strong>
                                <p class="small text-muted mb-0">Segera rendahkan tubuh Anda ke lantai sebelum guncangan menjatuhkan Anda.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start mb-3">
                            <div class="p-2 bg-success-subtle text-success rounded-3 fw-bold fs-5 px-3">2</div>
                            <div>
                                <strong class="text-dark">COVER (Berlindung)</strong>
                                <p class="small text-muted mb-0">Lindungi kepala dan leher di bawah meja kokoh dari reruntuhan plafon dan kaca.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <div class="p-2 bg-success-subtle text-success rounded-3 fw-bold fs-5 px-3">3</div>
                            <div>
                                <strong class="text-dark">HOLD ON (Bertahan)</strong>
                                <p class="small text-muted mb-0">Pegang erat kaki meja hingga guncangan benar-benar berhenti sempurna.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: TSUNAMI -->
        <div class="tab-pane fade" id="tab-tsunami" role="tabpanel">
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-7">
                    <span class="badge bg-info-subtle text-info px-3 py-1 rounded-pill small fw-semibold mb-2">Bahaya Hidrodinamika Pesisir</span>
                    <h2 class="fw-bold text-dark">Sains Tsunami &amp; Karakteristik Teluk Palu</h2>
                    <p class="text-muted leading-relaxed">
                        Tsunami adalah rangkaian gelombang laut dengan panjang gelombang ratusan kilometer yang menjalar dengan kecepatan mencapai 600–800 km/jam di laut dalam. Ketika mendekati teluk dangkal seperti Teluk Palu, gelombang melambat namun energinya terkompresi secara vertikal menjadi dinding air setinggi belasan meter.
                    </p>
                    <div class="alert alert-warning border-0 rounded-3 small">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> <b>Penting: Metode 20-20-20 di Pesisir Palu:</b>
                        Jika Anda merasakan gempa kuat selama <b>20 detik</b> atau lebih, Anda hanya memiliki waktu sekitar <b>20 menit</b> (atau kurang di Palu karena faktor longsoran dasar laut hanya 3-8 menit) untuk segera lari ke tempat dengan elevasi minimal <b>20 meter</b> di atas permukaan laut!
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-bell-fill text-info me-1"></i> Tanda-Tanda Alam Datangnya Tsunami</h6>
                        <ul class="list-unstyled small d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2-circle text-info fs-5 mt-n1"></i>
                                <span><b>Guncangan Hebat:</b> Gempa kuat membuat sulit berdiri di tepi pantai.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2-circle text-info fs-5 mt-n1"></i>
                                <span><b>Surut Air Laut Tiba-Tiba:</b> Terumbu karang dan ikan terdampar kelihatan ke tengah laut dalam sekejap.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2-circle text-info fs-5 mt-n1"></i>
                                <span><b>Suara Gemuruh Dahsyat:</b> Suara seperti pesawat jet berdesing atau deru ledakan dari arah laut lepas.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2-circle text-info fs-5 mt-n1"></i>
                                <span><b>Bau Belerang Menyengat:</b> Terangkatnya gas sulfida dari sedimen dasar laut yang teraduk oleh gelombang masif.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: LIKUIFAKSI -->
        <div class="tab-pane fade" id="tab-likuifaksi" role="tabpanel">
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-7">
                    <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill small fw-semibold mb-2">Fenomena Geoteknik Tanah</span>
                    <h2 class="fw-bold text-dark">Mengapa Tanah Padat Bisa Mencair Menjadi Lumpur?</h2>
                    <p class="text-muted leading-relaxed">
                        Likuifaksi (liquefaction) adalah fenomena hilangnya kekuatan geser (shear strength) pada lapisan tanah pasiran jenuh air ketika terkena beban siklik dinamis seperti getaran gempa bumi. Tekanan air pori (pore water pressure) meningkat drastis melampaui tekanan efektif antarbutir pasir, menyebabkan partikel tanah melayang bebas dalam air dan bertindak menyerupai zat cair kental.
                    </p>
                    <div class="card border-0 bg-light rounded-3 p-3">
                        <h6 class="fw-bold text-dark mb-2">Syarat Terjadinya Likuifaksi Aliran di Palu:</h6>
                        <ol class="small text-muted mb-0 ps-3">
                            <li class="mb-1"><b>Lapisan Pasir Lepas:</b> Butiran pasir seragam yang tidak terkonsolidasi (aluvial muda).</li>
                            <li class="mb-1"><b>Muka Air Tanah Dangkal:</b> Kedalaman air tanah kurang dari 5 meter dari permukaan tanah.</li>
                            <li class="mb-1"><b>Beban Gempa Kuat:</b> Percepatan tanah puncak (PGA) lebih dari 0.15–0.2 g dengan durasi goncangan panjang.</li>
                            <li><b>Kemiringan Lereng Rendah:</b> Kelerengan 1–3 derajat cukup untuk memicu aliran tanah (flow slide) gravitasi sejauh ribuan meter.</li>
                        </ol>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-layers-half text-warning me-1"></i> Lokasi Rawan Likuifaksi di Kota Palu</h6>
                        <div class="d-flex flex-column gap-2 small">
                            <div class="p-2 border rounded bg-warning-subtle text-dark">
                                <strong>Kelurahan Petobo (Palu Selatan):</strong> Endapan pasiran aluvial jenuh air dekat jaringan irigasi saluran terbuka.
                            </div>
                            <div class="p-2 border rounded bg-warning-subtle text-dark">
                                <strong>Kelurahan Balaroa (Palu Barat):</strong> Lereng batuan dasar berselingan lapisan aluvial bertekanan air artesis.
                            </div>
                            <div class="p-2 border rounded bg-warning-subtle text-dark">
                                <strong>Desa Jono Oge &amp; Sibalaya (Sigi):</strong> Cekungan lembah Palu dengan sedimen lempung pasiran basah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: SESAR PALU-KORO -->
        <div class="tab-pane fade" id="tab-sesar" role="tabpanel">
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-7">
                    <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill small fw-semibold mb-2">Patahan Tektonik Aktif</span>
                    <h2 class="fw-bold text-dark">Sains Sesar Mendatar Mengiri Palu-Koro</h2>
                    <p class="text-muted leading-relaxed">
                        Sesar Palu-Koro membelah Kota Palu dari Teluk Palu ke arah selatan-tenggara. Sesar ini tergolong patahan mendatar sinistral (left-lateral strike-slip), di mana blok batuan sebelah timur bergerak ke arah utara relatif terhadap blok barat.
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <strong class="text-danger">Panjang Jalur Patahan</strong>
                                <div class="fs-4 fw-bold text-dark">&gt; 500 km</div>
                                <div class="small text-muted">Dari Laut Sulawesi ke Teluk Bone</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <strong class="text-danger">Laju Pergeseran (Slip Rate)</strong>
                                <div class="fs-4 fw-bold text-dark">35 - 45 mm/thn</div>
                                <div class="small text-muted">Salah satu tercepat di daratan dunia</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-shield-lock text-danger me-1"></i> Aturan Sempadan Patahan (ZRB 4)</h6>
                        <p class="small text-muted leading-relaxed mb-3">
                            Hasil kajian PuSGeN dan Kementerian ATR/BPN menetapkan koridor bebas bangunan permanen di sekitar bidang patahan:
                        </p>
                        <div class="border-start border-3 border-danger ps-3">
                            <div class="fw-bold text-danger small">Zona Terlarang (ZRB 4): 50 - 100 Meter</div>
                            <p class="small text-muted mb-0">Hanya diizinkan untuk fungsi lindung, taman memorial, ruang terbuka hijau (RTH), dan jalur inspeksi hidrologis non-hunian.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: KAMUS ISTILAH -->
        <div class="tab-pane fade" id="tab-kamus" role="tabpanel">
            <h3 class="fw-bold text-dark mb-4"><i class="bi bi-journal-bookmark text-emerald me-2"></i>Kamus Istilah Kebencanaan &amp; KLH</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                        <h6 class="fw-bold text-dark mb-1">Hiposentrum &amp; Episentrum</h6>
                        <p class="small text-muted mb-0"><b>Hiposentrum:</b> Titik pusat pelepasan energi gempa di kedalaman kerak bumi. <b>Episentrum:</b> Titik proyeksi hiposentrum tepat tegak lurus di permukaan bumi.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                        <h6 class="fw-bold text-dark mb-1">PGA (Peak Ground Acceleration)</h6>
                        <p class="small text-muted mb-0">Percepatan tanah maksimum yang terjadi pada suatu lokasi saat getaran gempa, diukur dalam satuan % g (gravitasi bumi).</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                        <h6 class="fw-bold text-dark mb-1">Inundasi &amp; Run-Up Tsunami</h6>
                        <p class="small text-muted mb-0"><b>Inundasi:</b> Jarak terjauh genangan air laut menerobos masuk ke daratan. <b>Run-Up:</b> Elevasi vertikal maksimum air laut di atas muka laut rata-rata saat menyentuh daratan.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                        <h6 class="fw-bold text-dark mb-1">Daya Dukung Lingkungan Geologis</h6>
                        <p class="small text-muted mb-0">Kemampuan bentang alam batuan dan tanah dalam menopang beban struktur buatan manusia tanpa mengalami kegagalan massa tanah atau amplifikasi gelombang berlebih.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
