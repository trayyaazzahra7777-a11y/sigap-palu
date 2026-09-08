@extends('layouts.app')

@section('title', 'Input Pasang Surut & Muka Laut')
@section('header-title', 'Pencatatan Sensor Muka Air Laut Teluk Palu')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Form Input Observasi Laut -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-3">
                <i class="bi bi-water text-info me-1"></i> Catat Muka Air Laut
            </h5>
            <form action="{{ route('operator.muka-laut.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Nama Stasiun / Dermaga:</label>
                    <input type="text" name="stasiun" class="form-control rounded-3" value="Stasiun Tide Gauge Pantoloan (BIG)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Tinggi Muka Air Laut:</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="tinggi_muka_laut" class="form-control rounded-start-3" placeholder="Contoh: 1.45" required>
                        <select name="satuan" class="form-select" style="max-width: 90px;">
                            <option value="m" selected>meter</option>
                            <option value="cm">cm</option>
                        </select>
                    </div>
                    <div class="form-text small">Referensi terhadap Lowest Astronomical Tide (LAT).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Status Kondisi Air:</label>
                    <select name="status" class="form-select rounded-3" required>
                        <option value="normal" selected>Normal (Pasut Harian Teratur)</option>
                        <option value="waspada">Waspada (Anomali Ketinggian &plusmn; 0.5m)</option>
                        <option value="siaga">Siaga (Kenaikan / Penurunan Drastis)</option>
                        <option value="awas">Awas (Indikasi Tsunami Cepat)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-info text-white w-100 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Observasi Muka Laut
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat Data Pasut Muka Laut -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-graph-up-arrow text-emerald me-1"></i> Rekam Data Pengamatan Muka Laut Teluk Palu
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Waktu Pengamatan</th>
                            <th>Stasiun Pengukur</th>
                            <th class="text-center">Tinggi Air</th>
                            <th>Tipe Data</th>
                            <th>Sumber Penginput</th>
                            <th class="text-center pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mukaLautList as $m)
                        <tr>
                            <td class="ps-4 text-muted">{{ $m->tanggal_waktu ? $m->tanggal_waktu->format('d/m/Y H:i:s') : '-' }}</td>
                            <td><b>{{ $m->stasiun }}</b></td>
                            <td class="text-center fw-bold text-dark">{{ $m->tinggi_muka_laut }} {{ $m->satuan }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $m->jenis_data }}</span></td>
                            <td class="small text-muted">{{ $m->sumber }}</td>
                            <td class="text-center pe-4">
                                <span class="badge {{ $m->status === 'normal' ? 'bg-success' : ($m->status === 'waspada' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ strtoupper($m->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada rekaman muka air laut.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $mukaLautList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
