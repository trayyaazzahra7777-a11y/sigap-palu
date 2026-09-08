@extends('layouts.app')
@section('title', 'Monitoring Muka Laut')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-custom p-4">
            <span class="badge bg-secondary mb-2">SUMBER: DATA SIMULASI</span>
            <small class="text-muted d-block">Stasiun: Pantoloan - Teluk Palu</small>
            <h1 class="fw-bold text-teal my-2" style="color: #0f766e;">{{ end($data_laut)['tinggi'] }} <span class="fs-5 text-muted">meter</span></h1>
            <span class="badge badge-rendah">Status: {{ end($data_laut)['status'] }}</span>
            <p class="small text-muted mt-3 mb-0">Fluktuasi elevasi permukaan perairan berdasarkan kalkulasi pasang surut astronomis lokal.</p>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-custom p-3">
            <h6 class="fw-bold mb-2">Grafik Elevasi Muka Air Laut Teluk Palu (Waktu vs Tinggi)</h6>
            <canvas id="seaChart" style="max-height: 210px;"></canvas>
        </div>
    </div>
</div>

<div class="card-custom p-3">
    <h6 class="fw-bold mb-3">Tabel Pengamatan Elevasi Muka Laut</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Stasiun</th>
                    <th>Tinggi Muka Laut</th>
                    <th>Waktu Pengamatan</th>
                    <th>Status</th>
                    <th>Sumber Validasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_laut as $d)
                <tr>
                    <td class="fw-semibold">Stasiun Pantoloan</td>
                    <td>{{ $d['tinggi'] }} m</td>
                    <td>Hari ini, {{ $d['waktu'] }} WITA</td>
                    <td><span class="badge badge-rendah">{{ $d['status'] }}</span></td>
                    <td><span class="badge bg-secondary-subtle text-secondary border">Data Simulasi</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const records = @json($data_laut);
    new Chart(document.getElementById('seaChart'), {
        type: 'line',
        data: {
            labels: records.map(r => r.waktu),
            datasets: [{
                label: 'Elevasi (m)',
                data: records.map(r => r.tinggi),
                borderColor: '#0f766e',
                backgroundColor: 'rgba(15, 118, 110, 0.08)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { min: 0.5, max: 2.0 } }
        }
    });
</script>
@endpush