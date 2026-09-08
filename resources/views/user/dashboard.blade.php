@extends('layouts.app')

@section('title', 'Dashboard Warga & Peneliti')
@section('header-title', 'Dashboard Kesiapsiagaan Warga')

@section('content')
<div class="row g-4">
    <!-- Welcome Banner -->
    <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm text-white" style="background: linear-gradient(135deg, #059669 0%, #064e3b 100%);">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <span class="badge bg-white text-success px-3 py-1 rounded-pill fw-semibold small mb-2">
                            <i class="bi bi-person-check-fill me-1"></i> Akun Terverifikasi
                        </span>
                        <h3 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="text-white-50 mb-0">Selamat datang di portal mandiri SIGAP-PALU. Pantau risiko lingkungan tempat tinggal Anda dan uji skenario mitigasi.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.simulasi') }}" class="btn btn-light text-success fw-bold px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-cpu me-1"></i> Simulator Bencana
                        </a>
                        <a href="{{ route('user.unduh-kajian') }}" class="btn btn-outline-light px-3 py-2 rounded-pill">
                            <i class="bi bi-download me-1"></i> Unduh Rekap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilih Wilayah Domisili -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-geo-alt-fill text-emerald me-1"></i> Profil Risiko Domisili Anda
                    </h5>
                    <!-- Form ganti wilayah -->
                    <form action="{{ route('user.dashboard') }}" method="GET" class="d-flex gap-2">
                        <select name="wilayah_id" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                            @foreach($wilayahList as $w)
                                <option value="{{ $w->id_wilayah }}" {{ $selectedWilayah->id_wilayah == $w->id_wilayah ? 'selected' : '' }}>
                                    Kecamatan {{ $w->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-5 text-center border-end">
                        <div class="p-3">
                            <div class="small text-muted mb-1 text-uppercase fw-semibold">Indeks Risiko Bencana</div>
                            <div class="display-4 fw-bold {{ $selectedAreaAnalysis['tingkat_risiko'] === 'Tinggi' ? 'text-danger' : 'text-warning' }}">
                                {{ $selectedAreaAnalysis['skor_risiko'] }}
                            </div>
                            <span class="badge {{ $selectedAreaAnalysis['tingkat_risiko'] === 'Tinggi' ? 'bg-danger' : 'bg-warning text-dark' }} px-3 py-1 rounded-pill mt-1">
                                Risiko {{ $selectedAreaAnalysis['tingkat_risiko'] }}
                            </span>
                            <div class="small text-muted mt-2">Kecamatan {{ $selectedWilayah->nama_wilayah }}</div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="ps-md-2">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Faktor Ancaman Utama:</h6>
                            <p class="small text-muted mb-3">{{ $selectedAreaAnalysis['faktor_utama'] }}</p>

                            <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border mb-2">
                                <span class="small fw-semibold text-dark">Skor Kesiapsiagaan Wilayah:</span>
                                <span class="badge bg-success">{{ $selectedAreaAnalysis['tingkat_kesiapsiagaan'] }} ({{ $selectedAreaAnalysis['skor_kesiapsiagaan'] }}/100)</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border">
                                <span class="small fw-semibold text-dark">Koordinat Wilayah:</span>
                                <span class="small font-monospace text-muted">{{ $selectedWilayah->latitude }}, {{ $selectedWilayah->longitude }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-3 mb-0 small">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    <b>Rekomendasi Aksi Mandiri:</b> Pastikan keluarga Anda telah mengetahui lokasi Tempat Evakuasi Akhir (TEA) terdekat dan telah menyiapkan Tas Siaga Bencana untuk cadangan logistik selama 3x24 jam.
                </div>
            </div>
        </div>

       <!-- Riwayat Simulasi Mandiri -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-clock-history text-primary me-1"></i> Riwayat Pengujian Simulasi Anda
            </h5>
            <a href="{{ route('user.simulasi') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                + Buat Skenario Baru
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Skenario</th>
                        <th>Tipe Bahaya</th>
                        <th>Waktu Eksekusi</th>
                        <th>Ringkasan Hasil</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pe-4" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userSimulations as $sim)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $sim->nama_skenario }}</td>
                        <td>
                            <span class="badge {{ $sim->jenis_simulasi === 'gempa' ? 'bg-danger-subtle text-danger' : ($sim->jenis_simulasi === 'tsunami' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning') }}">
                                {{ strtoupper($sim->jenis_simulasi) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ isset($sim->created_at) ? $sim->created_at->format('d M Y H:i') : '-' }}</td>
                        <td class="text-muted" style="max-width: 250px;">{{ \Illuminate\Support\Str::limit($sim->hasil_ringkas, 60) }}</td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success">{{ $sim->status ?? 'Selesai' }}</span>
                        </td>
                        <td class="text-center pe-4">
                            <!-- Tombol Hapus dengan Ikon Tempat Sampah -->
                            <form action="{{ route('user.simulasi.hapus', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat simulasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus Riwayat">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-cpu fs-3 d-block mb-1 text-muted"></i>
                            Belum ada pengujian simulasi yang Anda jalankan. Klik "Simulator Bencana" untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Right Column: Quick Tools & Contacts -->
    <div class="col-lg-4">
        <!-- Shortcut WebGIS -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-map text-emerald me-1"></i> Jelajahi Peta Risiko Spasial</h6>
            <p class="small text-muted mb-3">Tinjau layer patahan Sesar Palu-Koro, zona rawan likuifaksi Petobo, dan jalur evakuasi di WebGIS interaktif.</p>
            <a href="{{ route('public.peta') }}" target="_blank" class="btn btn-emerald w-100 rounded-pill fw-semibold">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka WebGIS Terbuka
            </a>
        </div>

        <!-- Checklist Cepat TSB -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-backpack text-danger me-1"></i> Cek Cepat Tas Siaga (TSB)</h6>
            <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                <li><i class="bi bi-check2-square text-success me-1"></i> Dokumen penting kedap air</li>
                <li><i class="bi bi-check2-square text-success me-1"></i> Air mineral &amp; biskuit darurat</li>
                <li><i class="bi bi-check2-square text-success me-1"></i> Kotak P3K &amp; obat keluarga</li>
                <li><i class="bi bi-check2-square text-success me-1"></i> Senter &amp; peluit darurat</li>
            </ul>
            <div class="mt-3 text-end">
                <a href="{{ route('public.mitigasi') }}" target="_blank" class="small text-decoration-none fw-semibold">
                    Lihat panduan lengkap &rarr;
                </a>
            </div>
        </div>

        <!-- Hotline Card -->
        <div class="card border-0 bg-dark text-white rounded-4 p-4">
            <div class="small fw-semibold text-danger text-uppercase mb-1"><i class="bi bi-telephone-outbound me-1"></i> Nomor Posko Darurat</div>
            <h5 class="fw-bold mb-1">BPBD Kota Palu: (0451) 421113</h5>
            <div class="text-white-50 small mb-3">BASARNAS Sulawesi Tengah: 115</div>
            <a href="tel:0451421113" class="btn btn-danger btn-sm rounded-pill w-100 fw-bold">
                <i class="bi bi-telephone me-1"></i> Hubungi Posko BPBD
            </a>
        </div>
    </div>
</div>
@endsection
