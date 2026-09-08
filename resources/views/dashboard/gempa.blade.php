@extends('layouts.app')
@section('title', 'Monitoring Gempa Bumi')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card-custom p-4">
            <span class="badge bg-danger mb-2">SUMBER DATA: BMKG</span>
            <small class="text-muted d-block">Pembaruan Data: Terakhir diterima sistem</small>
            <h2 class="fw-bold my-2 text-danger">M {{ $gempa_list[0]['magnitudo'] }}</h2>
            <h6 class="fw-bold text-dark">{{ $gempa_list[0]['lokasi'] }}</h6>
            <div class="mt-3 small text-muted">
                <div>Kedalaman: <b>{{ $gempa_list[0]['kedalaman'] }}</b></div>
                <div>Waktu: <b>{{ $gempa_list[0]['waktu'] }}</b></div>
                <div>Potensi Tsunami: <span class="badge bg-success-subtle text-success border mt-1">{{ $gempa_list[0]['potensi'] }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card-custom p-3">
            <h6 class="fw-bold mb-2">Aktivitas Seismik Palu-Koro (Waktu vs Magnitudo)</h6>
            <canvas id="chartGempa" style="max-height: 210px;"></canvas>
        </div>
    </div>
</div>

<div class="card-custom p-3">
    <h6 class="fw-bold mb-3">Katalog Aktivitas Gempa Bumi Terbaru (BMKG)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle small">
            <thead class="table-light">
                <tr>
                    <th>Waktu Kejadian</th>
                    <th>Magnitudo</th>
                    <th>Kedalaman</th>
                    <th>Lokasi Pusat</th>
                    <th>Potensi Tsunami</th>
                    <th>Sumber</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gempa_list as $g)
                <tr>
                    <td class="fw-semibold">{{ $g['waktu'] }}</td>
                    <td><span class="badge bg-danger">M {{ $g['magnitudo'] }}</span></td>
                    <td>{{ $g['kedalaman'] }}</td>
                    <td>{{ $g['lokasi'] }}</td>
                    <td><span class="badge badge-rendah">{{ $g['potensi'] }}</span></td>
                    <td><span class="badge bg-light text-dark border">{{ $g['sumber'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-2 bg-light border rounded small text-muted mt-2">
        <i class="bi bi-info-circle me-1"></i> <b>Catatan Ilmiah:</b> Sistem menampilkan rekaman data seismisitas BMKG dan analisis potensi spasial. Sistem tidak memprediksi waktu pasti kejadian gempa bumi berikutnya.
    </div>
</div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('chartGempa'), {
        type: 'bar',
        data: {
            labels: ['05 Sep', '07 Sep', '08 Sep'],
            datasets: [{
                label: 'Magnitudo',
                data: [3.5, 2.8, 3.2],
                backgroundColor: '#ef4444',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: { y: { min: 1, max: 6 } }
        }
    });
</script>
@endpush