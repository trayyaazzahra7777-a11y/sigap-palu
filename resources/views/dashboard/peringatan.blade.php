@extends('layouts.app')
@section('title', 'Peringatan Kondisi')
@section('content')
<div class="card-custom p-3">
    <h6 class="fw-bold mb-3">Status Peringatan Kondisi Wilayah</h6>
    <div class="alert alert-warning border d-flex align-items-center gap-3">
        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
        <div>
            <div class="fw-bold">LEVEL WASPADA: Pemantauan Seismik Mikro Palu Barat</div>
            <small>Terdeteksi dinamika getaran mikro dangkal. Wilayah dalam pantauan rutin tim posko.</small>
        </div>
    </div>
</div>
@endsection