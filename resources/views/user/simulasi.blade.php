@extends('layouts.app')

@section('title', 'Simulator Skenario Bencana')
@section('header-title', 'Simulator Skenario Bencana Mandiri')

@section('content')
<!-- Mandatory Simulation Disclaimer Banner -->
<div class="alert alert-warning border-2 border-warning shadow-sm rounded-4 p-4 mb-4" role="alert">
    <div class="d-flex align-items-center gap-3">
        <div class="fs-1 text-warning"><i class="bi bi-shield-exclamation"></i></div>
        <div>
            <h5 class="fw-bold text-dark mb-1">[MODE SIMULASI — BUKAN PERINGATAN RESMI]</h5>
            <p class="mb-0 text-muted small">
               Fitur ini adalah mesin simulasi skenario deterministik untuk keperluan edukasi, riset, dan Kajian Risiko Bencana (KRB). Seluruh angka guncangan MMI, waktu tiba tsunami, dan zona likuifaksi merupakan hasil pemodelan matematis teoretis dan <b>TIDAK mencerminkan peringatan evakuasi resmi saat ini</b>.
            </p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Form Input Skenario -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-sliders text-emerald me-1"></i> Konfigurasi Skenario
            </h5>

            <form action="{{ route('user.simulasi.run') }}" method="POST">
                @csrf

                <!-- Pilihan Tipe Skenario -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Pilih Jenis Bahaya Bencana:</label>
                    <select name="jenis_simulasi" id="selectJenis" class="form-select rounded-3" required onchange="updateFormInputs(this.value)">
                        <option value="gempa" {{ old('jenis_simulasi') === 'gempa' ? 'selected' : '' }}>Gempa Bumi Sesar Palu-Koro</option>
                        <option value="tsunami" {{ old('jenis_simulasi') === 'tsunami' ? 'selected' : '' }}>Tsunami Kilat Teluk Palu</option>
                        <option value="likuefaksi" {{ old('jenis_simulasi') === 'likuefaksi' ? 'selected' : '' }}>Likuifaksi Lapisan Aluvial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Nama Skenario / Catatan Uji:</label>
                    <input type="text" name="nama_skenario" class="form-control rounded-3" placeholder="Contoh: Uji Gempa Mw 7.4 Sesar Palu-Koro" value="{{ old('nama_skenario', 'Skenario Uji Mitigasi ' . date('d/m/Y')) }}">
                </div>

                <!-- Input Khusus Gempa & Tsunami -->
                <div id="sectionGempaTsunami">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark d-flex justify-content-between">
                            <span>Magnitudo Gempa (Mw):</span>
                            <span id="labelMag" class="fw-bold text-danger">7.4 Mw</span>
                        </label>
                        <input type="range" name="magnitudo" id="rangeMag" class="form-range" min="5.0" max="8.5" step="0.1" value="7.4" oninput="document.getElementById('labelMag').innerText = this.value + ' Mw'">
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.75rem;">
                            <span>M 5.0 (Sedang)</span>
                            <span>M 7.4 (2018)</span>
                            <span>M 8.5 (Ekstrem)</span>
                        </div>
                    </div>

                    <div class="mb-3" id="groupKedalaman">
                        <label class="form-label small fw-semibold text-dark">Kedalaman Hiposenter (km):</label>
                        <input type="number" name="kedalaman" class="form-control rounded-3" min="5" max="150" value="10">
                        <div class="form-text small">Gempa dangkal (&lt; 20 km) menimbulkan guncangan MMI paling destruktif.</div>
                    </div>
                </div>

                <!-- Input Khusus Likuifaksi -->
                <div id="sectionLikuifaksi" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark d-flex justify-content-between">
                            <span>Percepatan Tanah Puncak (PGA):</span>
                            <span id="labelPga" class="fw-bold text-warning">0.35 g</span>
                        </label>
                        <input type="range" name="pga_g" id="rangePga" class="form-range" min="0.1" max="0.8" step="0.05" value="0.35" oninput="document.getElementById('labelPga').innerText = this.value + ' g'">
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.75rem;">
                            <span>0.10 g</span>
                            <span>0.35 g (Kritis)</span>
                            <span>0.80 g</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-emerald w-100 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-play-circle me-1"></i> Jalankan Simulasi Deterministik
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Hasil Simulasi -->
    <div class="col-lg-7">
        @if(isset($simulationResult))
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold mb-1">
                            {{ $simulationResult['disclaimer'] }}
                        </span>
                        <h5 class="fw-bold text-dark mb-0">{{ $simulationResult['nama_skenario'] }}</h5>
                    </div>
                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{ $simulationResult['jenis'] }}</span>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-light border rounded-3 mb-4">
                        <div class="small fw-semibold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i> Ringkasan Hasil Pemodelan:</div>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $simulationResult['hasil_ringkas'] }}</p>
                    </div>

                    <!-- Jika Hasil Gempa -->
                    @if($simulationResult['jenis'] === 'gempa')
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-graph-up text-danger me-1"></i> Estimasi Sebaran Intensitas MMI per Kecamatan:</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kecamatan</th>
                                        <th class="text-center">Jarak Episentrum</th>
                                        <th class="text-center">Intensitas (MMI)</th>
                                        <th>Tingkat Bahaya</th>
                                        <th>Dampak Kerusakan Fisik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($simulationResult['hasil_per_wilayah'] as $h)
                                    <tr>
                                        <td><b>{{ $h['nama_wilayah'] }}</b></td>
                                        <td class="text-center text-muted">{{ $h['jarak_km'] }} km</td>
                                        <td class="text-center">
                                            <span class="badge {{ $h['mmi'] >= 7.0 ? 'bg-danger' : ($h['mmi'] >= 5.0 ? 'bg-warning text-dark' : 'bg-success') }} px-2 py-1">
                                                Skala {{ $h['skala_romawi'] }} ({{ $h['mmi'] }})
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $h['tingkat_bahaya'] === 'Tinggi' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }}">
                                                {{ $h['tingkat_bahaya'] }}
                                            </span>
                                        </td>
                                        <td class="small text-muted" style="max-width: 200px;">{{ $h['deskripsi_dampak'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Jika Hasil Tsunami -->
                    @if($simulationResult['jenis'] === 'tsunami')
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-water text-info me-1"></i> Estimasi Waktu Tiba &amp; Limpasan Pesisir:</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sektor Pesisir</th>
                                        <th>Kecamatan</th>
                                        <th class="text-center">Estimasi Waktu Tiba (ETA)</th>
                                        <th class="text-center">Perkiraan Run-Up</th>
                                        <th>Status Ancaman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($simulationResult['hasil_per_pesisir'] as $p)
                                    <tr>
                                        <td><b>{{ $p['wilayah_pesisir'] }}</b></td>
                                        <td class="text-muted">{{ $p['kecamatan'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-danger px-3 py-1 font-monospace">{{ $p['estimasi_waktu_tiba_menit'] }} Menit</span>
                                        </td>
                                        <td class="text-center fw-bold text-info">
                                            ~{{ $p['perkiraan_tinggi_runup_m'] }} meter
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger">{{ $p['tingkat_ancaman'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Jika Hasil Likuifaksi -->
                    @if($simulationResult['jenis'] === 'likuefaksi')
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-layers text-warning me-1"></i> Evaluasi Kerentanan Lapisan Tanah:</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle small mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Zona Aluvial</th>
                                        <th>Litologi Tanah</th>
                                        <th>Potensi Likuifaksi</th>
                                        <th>Rekomendasi Tata Ruang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($simulationResult['zona_analisis'] as $z)
                                    <tr>
                                        <td><b>{{ $z['zona'] }}</b><br><small class="text-muted">{{ $z['kecamatan'] }}</small></td>
                                        <td class="small text-muted">{{ $z['litologi'] }}</td>
                                        <td>
                                            <span class="badge {{ str_contains($z['potensi'], 'Sangat') ? 'bg-danger' : (str_contains($z['potensi'], 'Tinggi') ? 'bg-warning text-dark' : 'bg-success') }}">
                                                {{ $z['potensi'] }}
                                            </span>
                                        </td>
                                        <td class="small">{{ $z['rekomendasi'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Placeholder Belum Menjalankan Simulasi -->
            <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center mb-4">
                <div class="py-4">
                    <i class="bi bi-cpu text-emerald display-3 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Skenario yang Dijalankan</h5>
                    <p class="text-muted small mx-auto mb-4" style="max-width: 450px;">
                        Gunakan panel kontrol di sebelah kiri untuk memilih jenis bahaya, mengatur besaran magnitudo atau PGA, lalu klik "Jalankan Simulasi Deterministik".
                    </p>
                    <div class="d-inline-flex gap-2 text-start bg-light p-3 rounded-3 small">
                        <i class="bi bi-lightbulb text-warning fs-5"></i>
                        <div>
                            <b>Tips Mitigasi:</b> Cobalah menguji skenario Gempa M 7.4 kedalaman 10 km untuk melihat korelasi matematis dengan peristiwa gempa Palu 2018.
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateFormInputs(jenis) {
    const sectionGempaTsunami = document.getElementById('sectionGempaTsunami');
    const groupKedalaman = document.getElementById('groupKedalaman');
    const sectionLikuifaksi = document.getElementById('sectionLikuifaksi');

    if (jenis === 'gempa') {
        sectionGempaTsunami.style.display = 'block';
        groupKedalaman.style.display = 'block';
        sectionLikuifaksi.style.display = 'none';
    } else if (jenis === 'tsunami') {
        sectionGempaTsunami.style.display = 'block';
        groupKedalaman.style.display = 'none';
        sectionLikuifaksi.style.display = 'none';
    } else if (jenis === 'likuefaksi') {
        sectionGempaTsunami.style.display = 'none';
        sectionLikuifaksi.style.display = 'block';
    }
}
</script>
@endpush
