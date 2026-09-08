@extends('layouts.public')

@section('title', 'Mitigasi & Kesiapsiagaan Bencana - SIGAP-PALU')

@section('content')
<!-- Header Banner -->
<section class="py-5 bg-dark text-white position-relative" style="background: linear-gradient(135deg, #0f766e 0%, #0f172a 100%);">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle px-3 py-2 rounded-pill fw-semibold small mb-3">
                    <i class="bi bi-shield-check me-1"></i> Panduan Ketangguhan Mandiri &amp; Komunitas
                </span>
                <h1 class="display-5 fw-bold mb-3">Mitigasi &amp; Kesiapsiagaan Bencana</h1>
                <p class="lead text-light opacity-75 mb-0">
                    Panduan langkah taktis, tas siaga bencana, titik kumpul evakuasi resmi, dan SOP penyelamatan diri untuk warga Kota Palu menghadapi ancaman gempa bumi dan tsunami.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <i class="bi bi-person-walking text-white-50 display-1"></i>
            </div>
        </div>
    </div>
</section>

<!-- Content Sections -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Main Column -->
        <div class="col-lg-8">
            <!-- 1. Tas Siaga Bencana (Interactive Checklist) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill small fw-semibold">Kelangsungan Hidup 72 Jam</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0"><i class="bi bi-backpack2-fill text-danger me-2"></i>Tas Siaga Bencana (TSB)</h4>
                    </div>
                    <span class="badge bg-light text-muted border px-3 py-2">3x24 Jam Mandiri</span>
                </div>
                <p class="text-muted small mb-3">
                    Siapkan satu tas ransel kedap air untuk setiap anggota keluarga yang ditempatkan di dekat pintu keluar rumah. Centang daftar periksa di bawah ini untuk memastikan kesiapan tas Anda:
                </p>

                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb1">
                            <label class="form-check-label small text-dark" for="tsb1">Surat &amp; Dokumen Penting (Ijazah, KK, Sertifikat kedap air)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb2">
                            <label class="form-check-label small text-dark" for="tsb2">Air Minum Minimal 3 Liter per orang</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb3">
                            <label class="form-check-label small text-dark" for="tsb3">Makanan Siap Santap / Biskuit Energi Tinggi</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb4">
                            <label class="form-check-label small text-dark" for="tsb4">Kotak P3K, Obat Pribadi &amp; Antiseptik</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb5">
                            <label class="form-check-label small text-dark" for="tsb5">Senter LED &amp; Baterai Cadangan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb6">
                            <label class="form-check-label small text-dark" for="tsb6">Peluit Nyaring (Alat Minta Tolong jika Terjebak)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb7">
                            <label class="form-check-label small text-dark" for="tsb7">Pakaian Hangat, Jas Hujan &amp; Selimut Ringan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check p-2 border rounded-3 bg-light d-flex align-items-center gap-2">
                            <input class="form-check-input ms-1" type="checkbox" id="tsb8">
                            <label class="form-check-label small text-dark" for="tsb8">Powerbank &amp; Uang Tunai Pecahan Kecil</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. SOP Evakuasi Mandiri Gempa & Tsunami -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <span class="badge bg-warning-subtle text-warning px-3 py-1 rounded-pill small fw-semibold mb-2">Protokol Penyelamatan Diri</span>
                <h4 class="fw-bold text-dark mb-3"><i class="bi bi-signpost-split-fill text-warning me-2"></i>SOP Evakuasi Mandiri Cepat</h4>

                <div class="accordion accordion-flush border rounded-3 overflow-hidden" id="sopAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sop1">
                                <i class="bi bi-house-door me-2 text-emerald"></i> 1. Ketika Berada di Dalam Rumah / Bangunan
                            </button>
                        </h2>
                        <div id="sop1" class="accordion-collapse collapse show" data-bs-parent="#sopAccordion">
                            <div class="accordion-body small text-muted leading-relaxed">
                                Lakukan <b>Drop, Cover, and Hold On</b>. Jangan berlari keluar ruangan secara panik saat guncangan masih berlangsung karena bahaya genteng, pecahan kaca, atau tiang kanopi jatuh. Setelah guncangan mereda, segera matikan kompor dan saklar listrik utama (MCB), lalu keluar menuju ruang terbuka melalui jalur evakuasi yang bebas rintangan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sop2">
                                <i class="bi bi-water me-2 text-info"></i> 2. Ketika Berada di Pesisir Teluk Palu
                            </button>
                        </h2>
                        <div id="sop2" class="accordion-collapse collapse" data-bs-parent="#sopAccordion">
                            <div class="accordion-body small text-muted leading-relaxed">
                                <b>JANGAN MENUNGGU SIRENE RESMI ATAU SMS PERINGATAN!</b> Karena waktu penjalaran tsunami lokal di Teluk Palu sangat kilat (3-8 menit akibat longsoran bawah laut), segera tinggalkan pantai dan bergerak menjauhi air laut ke tempat tinggi (elevasi &gt; 20 meter) atau naik ke lantai 3+ gedung bertingkat tahan gempa (Evakuasi Vertikal). Jangan menggunakan mobil atau motor karena potensi kemacetan parah di jalan pesisir.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sop3">
                                <i class="bi bi-car-front me-2 text-secondary"></i> 3. Ketika Berada di Dalam Kendaraan
                            </button>
                        </h2>
                        <div id="sop3" class="accordion-collapse collapse" data-bs-parent="#sopAccordion">
                            <div class="accordion-body small text-muted leading-relaxed">
                                Perlambat laju kendaraan secara bertahap dan menepi ke bahu jalan kiri. Hindari berhenti di bawah jembatan layang, di dekat tiang listrik bertegangan tinggi, pohon besar, atau tebing rawan longsor. Tetaplah di dalam mobil hingga goncangan berhenti, kemudian keluar dan cari tempat terbuka yang aman.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Titik Evakuasi Resmi Kota Palu -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-semibold mb-2">Peta Sebaran Lokasi Aman</span>
                <h4 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-success me-2"></i>Daftar Titik Evakuasi Akhir (TEA) Kota Palu</h4>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lokasi</th>
                                <th>Kecamatan</th>
                                <th>Jenis Fasilitas</th>
                                <th>Kapasitas</th>
                                <th>Status Keamanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Lapangan Kantor Walikota (Vatulemo)</b></td>
                                <td>Palu Timur</td>
                                <td>Ruang Terbuka Hijau &amp; Posko</td>
                                <td>± 10.000 jiwa</td>
                                <td><span class="badge bg-success">Aman (Bebas Likuifaksi)</span></td>
                            </tr>
                            <tr>
                                <td><b>Kawasan Kampus Universitas Tadulako (Untad)</b></td>
                                <td>Mantikulore</td>
                                <td>Kawasan Pendidikan &amp; Lapangan</td>
                                <td>± 25.000 jiwa</td>
                                <td><span class="badge bg-success">Aman (Elevasi Tinggi)</span></td>
                            </tr>
                            <tr>
                                <td><b>Perbukitan Kawatuna</b></td>
                                <td>Mantikulore</td>
                                <td>Kawasan Perbukitan Batuan Dasar</td>
                                <td>± 15.000 jiwa</td>
                                <td><span class="badge bg-success">Aman Tsunami &amp; Likuifaksi</span></td>
                            </tr>
                            <tr>
                                <td><b>Lapangan Gelora Siranindi (Kamonji)</b></td>
                                <td>Palu Barat</td>
                                <td>Stadion Olahraga Terbuka</td>
                                <td>± 8.000 jiwa</td>
                                <td><span class="badge bg-warning text-dark">Zona Antara Sesar</span></td>
                            </tr>
                            <tr>
                                <td><b>Bukit Pantoloan Indah</b></td>
                                <td>Tawaeli</td>
                                <td>Dataran Tinggi Utara Pelabuhan</td>
                                <td>± 5.000 jiwa</td>
                                <td><span class="badge bg-success">Aman Tsunami Utara</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-end">
                    <a href="{{ route('public.peta') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        <i class="bi bi-map me-1"></i> Buka Titik Evakuasi di WebGIS Interaktif
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Right: Emergency Contacts -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                    <i class="bi bi-telephone-fill text-danger me-2"></i> Kontak Darurat Kota Palu
                </h5>
                <p class="small text-muted mb-3">Simpan kontak-kontak darurat berikut di ponsel Anda untuk keadaan mendesak:</p>

                <div class="d-flex flex-column gap-2">
                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark small">BPBD Kota Palu</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Penanganan Bencana &amp; Posko</div>
                        </div>
                        <a href="tel:0451421113" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                            <i class="bi bi-telephone me-1"></i> (0451) 421113
                        </a>
                    </div>

                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark small">BASARNAS Palu</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Pencarian &amp; Pertolongan</div>
                        </div>
                        <a href="tel:115" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                            <i class="bi bi-telephone me-1"></i> 115
                        </a>
                    </div>

                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark small">PMI Kota Palu</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Ambulans &amp; Donor Darah</div>
                        </div>
                        <a href="tel:0451424118" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                            <i class="bi bi-telephone me-1"></i> (0451) 424118
                        </a>
                    </div>

                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark small">RSUD Undata Palu</div>
                            <div class="text-muted" style="font-size: 0.75rem;">IGD &amp; Rumah Sakit Rujukan</div>
                        </div>
                        <a href="tel:0451421270" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                            <i class="bi bi-telephone me-1"></i> (0451) 421270
                        </a>
                    </div>

                    <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark small">Damkar Kota Palu</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Pemadam Kebakaran &amp; Penyelamatan</div>
                        </div>
                        <a href="tel:113" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                            <i class="bi bi-telephone me-1"></i> 113
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0 bg-dark text-white rounded-4 p-4">
                <h6 class="fw-bold text-emerald mb-2"><i class="bi bi-exclamation-circle me-1"></i> Maklumat Kesiapsiagaan</h6>
                <p class="small text-light opacity-75 mb-0 leading-relaxed">
                    Bencana alam tidak dapat dicegah waktu kedatangannya, namun risiko korban jiwa dan kerugian lingkungan dapat diminimalisasi melalui kesiapsiagaan mandiri, ketaatan tata ruang sempadan sesar, dan pemahaman rute evakuasi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
