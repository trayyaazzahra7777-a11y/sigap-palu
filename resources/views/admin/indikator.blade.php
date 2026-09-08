@extends('layouts.app')

@section('title', 'Indikator & Pembobotan KRB')
@section('header-title', 'Konfigurasi Parameter & Indikator Risiko Bencana')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white py-3 border-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="bi bi-sliders text-emerald me-1"></i> Matriks 12 Indikator Kajian Risiko Bencana</h5>
                <p class="text-muted small mb-0">Formula: <code>Risiko = (Ancaman × Kerentanan) / Kapasitas</code></p>
            </div>
            <div class="small text-muted">
                <span class="badge bg-danger-subtle text-danger me-1">Ancaman</span>
                <span class="badge bg-warning-subtle text-warning me-1">Kerentanan</span>
                <span class="badge bg-success-subtle text-success">Kapasitas</span>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        @foreach($indikatorList as $kategori => $items)
            <div class="mb-4">
                <h6 class="fw-bold text-dark text-uppercase pb-2 border-bottom d-flex align-items-center gap-2">
                    <span class="badge {{ str_contains(strtolower($kategori), 'ancaman') ? 'bg-danger' : (str_contains(strtolower($kategori), 'kerentanan') ? 'bg-warning text-dark' : 'bg-success') }}">
                        {{ $kategori }}
                    </span>
                    <span class="small text-muted fw-normal">({{ $items->count() }} Indikator)</span>
                </h6>

                <div class="table-responsive">
                    <table class="table table-hover align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Indikator</th>
                                <th>Satuan Ukur</th>
                                <th class="text-center" style="width: 140px;">Bobot (%)</th>
                                <th>Deskripsi / Dasar Kajian</th>
                                <th class="text-center" style="width: 120px;">Aksi Simpan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $ind)
                            <tr>
                                <td><b>{{ $ind->nama_indikator }}</b></td>
                                <td><span class="badge bg-light text-dark border">{{ $ind->satuan }}</span></td>
                                <td>
                                    <form action="{{ route('admin.indikator.update', $ind->id_indikator) }}" method="POST" id="form-ind-{{ $ind->id_indikator }}">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.5" name="bobot" class="form-control text-center rounded-start" value="{{ $ind->bobot }}" min="1" max="100" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                </td>
                                <td>
                                        <input type="text" name="deskripsi" class="form-control form-control-sm rounded" value="{{ $ind->deskripsi }}">
                                </td>
                                <td class="text-center">
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                            <i class="bi bi-check-lg"></i> Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection