@extends('layouts.app')

@section('title', 'Siaran Peringatan Dini')
@section('header-title', 'Kelola Siaran Peringatan Dini Bencana')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Form Terbitkan Peringatan -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-megaphone-fill text-danger me-1"></i> Terbitkan Peringatan Dini
            </h5>
            <form action="{{ route('operator.peringatan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Wilayah Cakupan:</label>
                    <select name="id_wilayah" class="form-select rounded-3">
                        <option value="">-- Seluruh Kota Palu (General) --</option>
                        @foreach($wilayahList as $w)
                            <option value="{{ $w->id_wilayah }}">Kecamatan {{ $w->nama_wilayah }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Jenis Peringatan:</label>
                    <input type="text" name="jenis_peringatan" class="form-control rounded-3" placeholder="Contoh: Peringatan Gempa Susulan / Air Pasang" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Tingkat Status:</label>
                    <select name="tingkat" class="form-select rounded-3" required>
                        <option value="informasi">Informasi (Pemberitahuan)</option>
                        <option value="waspada">Waspada (Siaga Ringan)</option>
                        <option value="siaga" selected>Siaga (Potensi Bahaya)</option>
                        <option value="peringatan">Peringatan / Awas (Evakuasi Cepat)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Instruksi &amp; Pesan untuk Warga:</label>
                    <textarea name="pesan" rows="4" class="form-control rounded-3" placeholder="Tuliskan arahan evakuasi, titik kumpul, dan himbauan keselamatan..." required></textarea>
                </div>

                <button type="submit" class="btn btn-danger w-100 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-broadcast me-1"></i> Publikasikan Peringatan
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat Seluruh Peringatan -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-list-stars text-emerald me-1"></i> Daftar Peringatan Dini Sistem
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tingkat</th>
                            <th>Jenis Peringatan</th>
                            <th>Wilayah</th>
                            <th>Isi Pesan</th>
                            <th>Waktu Mulai</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peringatanList as $p)
                        <tr>
                            <td class="ps-4">
                                <span class="badge {{ $p->tingkat === 'Awas' ? 'bg-danger' : ($p->tingkat === 'Siaga' ? 'bg-warning text-dark' : 'bg-info text-dark') }} px-2 py-1">
                                    {{ $p->tingkat }}
                                </span>
                            </td>
                            <td><b>{{ $p->jenis_peringatan }}</b></td>
                            <td class="text-muted">{{ $p->wilayah?->nama_wilayah ?? 'Kota Palu' }}</td>
                            <td class="text-muted" style="max-width: 200px;">{{ \Illuminate\Support\Str::limit($p->pesan, 60) }}</td>
                            <td class="text-muted">{{ $p->waktu_mulai ? $p->waktu_mulai->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <span class="badge {{ $p->status === 'aktif' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                @if($p->status === 'aktif')
                                <form action="{{ route('operator.peringatan.selesai', $p->id_peringatan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" onclick="return confirm('Akhiri masa aktif peringatan ini?')">
                                        Akhiri
                                    </button>
                                </form>
                                @else
                                <span class="text-muted small">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat peringatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $peringatanList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
