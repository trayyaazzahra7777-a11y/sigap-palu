<?php

namespace Database\Seeders;

use App\Models\SumberData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // Jangan lupa import Facades Schema

class SumberDataSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key sebentar untuk menghindari error constraint
        Schema::disableForeignKeyConstraints();
        
        SumberData::truncate();

        // Aktifkan kembali foreign key setelah truncate
        Schema::enableForeignKeyConstraints();

        $sumber = [
            [
                'nama_sumber' => 'BMKG - Data Terbuka Gempabumi',
                'jenis_data' => 'Seismisitas & Parameter Gempa',
                'url_sumber' => 'https://data.bmkg.go.id/DataMKG/TEKTONIK/autogempa.json',
                'tipe_sumber' => 'API',
                'status' => 'aktif',
                'last_update' => now(),
                'keterangan' => 'Endpoint resmi BMKG Republik Indonesia untuk data gempa M 5.0+ dan gempa dirasakan.',
            ],
            [
                'nama_sumber' => 'Badan Informasi Geospasial (BIG) - Stasiun Pasut Pantoloan',
                'jenis_data' => 'Tinggi Muka Laut Real-Time',
                'url_sumber' => 'https://srgi.big.go.id/tides',
                'tipe_sumber' => 'API',
                'status' => 'aktif',
                'last_update' => now(),
                'keterangan' => 'Stasiun pasang surut Pantoloan Teluk Palu untuk pemantauan muka air laut dan anomali gelombang.',
            ],
            [
                'nama_sumber' => 'Pusat Air Tanah dan Geologi Tata Lingkungan (PATGTL) - Badan Geologi ESDM',
                'jenis_data' => 'Peta Zona Kerentanan Likuifaksi Kota Palu',
                'url_sumber' => 'https://vsi.esdm.go.id',
                'tipe_sumber' => 'GIS',
                'status' => 'aktif',
                'last_update' => now(),
                'keterangan' => 'Data spasial zona kerentanan likuifaksi pasca-bencana 28 September 2018 (Balaroa, Petobo, Jono Oge).',
            ],
            [
                'nama_sumber' => 'Pusat Studi Gempa Nasional (PuSGeN) - Peta Sumber Bahaya Gempa Indonesia',
                'jenis_data' => 'Jejak Spasial Sesar Palu-Koro',
                'url_sumber' => 'https://pusgen.pu.go.id',
                'tipe_sumber' => 'GIS',
                'status' => 'aktif',
                'last_update' => now(),
                'keterangan' => 'Trase patahan aktif sesar geser mendatar kiri (sinistral strike-slip) Palu-Koro segmen Palu.',
            ],
            [
                'nama_sumber' => 'BPBD Kota Palu & Bappeda',
                'jenis_data' => 'Data Jalur & Titik Kumpul Evakuasi Mandiri',
                'url_sumber' => null,
                'tipe_sumber' => 'file',
                'status' => 'aktif',
                'last_update' => now(),
                'keterangan' => 'Inventarisasi ruang evakuasi sementara (TES) dan ruang evakuasi akhir (TEA) terverifikasi di 8 kecamatan.',
            ],
        ];

        foreach ($sumber as $s) {
            SumberData::create($s);
        }
    }
}