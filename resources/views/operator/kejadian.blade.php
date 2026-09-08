@extends('layouts.app')

@section('title', 'Laporan Kejadian Bencana')
@section('header-title', 'Pencatatan & Verifikasi Kejadian Bencana')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Form Input Kejadian Lapangan -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-plus-circle-fill text-warning me-1"></i> Catat Kejadian Bencana
            </h5>
            <form action="{{ route('operator.kejadian.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Kecamatan:</label>
                    <select name="id_wilayah" class="form-select rounded-3" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($wilayahList as $w)
                            <option value="{{ $w->id_wilayah }}">{{ $w->nama_wilayah }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Jenis Bencana:</label>
                    <select name="id_bencana" class="form-select rounded-3" required>
                        @foreach($jenisBencanaList as $jb)
                            <option value="{{ $jb->id_bencana }}">{{ $jb->nama_bencana }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Lokasi Spesifik / Alamat:</label>
                    <input type="text" name="lokasi" class="form-control rounded-3" placeholder="Contoh: Jl. Talise No. 12, Pesisir Teluk" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Keterangan Situasi:</label>
                    <textarea name="keterangan" rows="3" class="form-control rounded-3" placeholder="Deskripsikan kondisi lapangan secara ringkas..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Estimasi Dampak / Korban:</label>
                    <input type="text" name="dampak" class="form-control rounded-3" placeholder="Contoh: Dinding rumah retak, nihil korban jiwa">
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 rounded-pill fw-bold text-dark shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Laporan Kejadian
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat Kejadian Bencana -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-journal-medical text-emerald me-1"></i> Rekam Kejadian Bencana Lapangan
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>Wilayah &amp; Lokasi</th>
                            <th>Jenis Bencana</th>
                            <th>Keterangan / Dampak</th>
                            <th>Status Penanganan</th>
                            <th class="text-center pe-4">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kejadianList as $k)
                        <tr>
                            <td class="ps-4 text-muted">{{ $k->tanggal_waktu ? $k->tanggal_waktu->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <b>{{ $k->wilayah?->nama_wilayah }}</b>
                                <div class="text-muted small">{{ $k->lokasi }}</div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $k->jenisBencana?->nama_bencana }}</span></td>
                            <td class="text-muted" style="max-width: 180px;">
                                <div>{{ \Illuminate\Support\Str::limit($k->keterangan, 40) }}</div>
                                <div class="text-danger small">{{ $k->dampak }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $k->status === 'selesai' ? 'bg-success' : ($k->status === 'ditangani' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <form action="{{ route('operator.kejadian.status', $k->id_kejadian) }}" method="POST" class="d-inline-flex gap-1">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm rounded-2 py-0" style="font-size: 0.75rem;" onchange="this.form.submit()">
                                        <option value="tercatat" {{ $k->status === 'tercatat' ? 'selected' : '' }}>Tercatat</option>
                                        <option value="diverifikasi" {{ $k->status === 'diverifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                        <option value="ditangani" {{ $k->status === 'ditangani' ? 'selected' : '' }}>Ditangani</option>
                                        <option value="selesai" {{ $k->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada kejadian tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $kejadianList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
