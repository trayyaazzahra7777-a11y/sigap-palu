@extends('layouts.app')
@section('title', 'Kesiapsiagaan Wilayah')
@section('content')
<div class="card-custom p-4 mb-3">
    <h5 class="fw-bold">Indeks Kesiapsiagaan Kota Palu</h5>
    <h1 class="fw-bold text-success my-2">78% <span class="fs-5 text-muted fw-normal">Status: BAIK</span></h1>
    <div class="progress my-3" style="height: 12px;">
        <div class="progress-bar bg-success" style="width: 78%"></div>
    </div>
</div>
<div class="card-custom p-3">
    <h6 class="fw-bold mb-3">Indikator Komponen Ketahanan</h6>
    <ul class="list-group list-group-flush small">
        <li class="list-group-item d-flex justify-content-between"><span>Kesiapan Jalur Evakuasi Tsunami</span><span class="badge badge-rendah">Tinggi (82%)</span></li>
        <li class="list-group-item d-flex justify-content-between"><span>Akses Informasi Peringatan Dini</span><span class="badge badge-rendah">Tinggi (85%)</span></li>
        <li class="list-group-item d-flex justify-content-between"><span>Ketersediaan Fasilitas Penampungan Sementara</span><span class="badge badge-sedang">Sedang (70%)</span></li>
        <li class="list-group-item d-flex justify-content-between"><span>Kapasitas Respons Tanggap Cepat Komunitas</span><span class="badge badge-sedang">Sedang (75%)</span></li>
    </ul>
</div>
@endsection