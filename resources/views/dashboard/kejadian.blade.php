@extends('layouts.app')
@section('title', 'Riwayat Kejadian Bencana')
@section('content')
<div class="card-custom p-3">
    <h6 class="fw-bold mb-3">Riwayat Kejadian Bencana Terdokumentasi</h6>
    <table class="table table-hover align-middle small">
        <thead class="table-light">
            <tr><th>Tanggal</th><th>Wilayah</th><th>Jenis Bencana</th><th>Lokasi</th><th>Status</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
            <tr><td>28 Sep 2018</td><td>Kota Palu & Teluk</td><td>Gempa, Tsunami & Likuifaksi</td><td>Palu & Donggala</td><td><span class="badge badge-rendah">Terverifikasi</span></td><td>Peristiwa gempa tektonik M 7.4 sesar Palu-Koro.</td></tr>
        </tbody>
    </table>
</div>
@endsection