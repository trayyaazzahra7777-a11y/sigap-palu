<?php

namespace Database\Seeders;

use App\Models\LayerGis;
use Illuminate\Database\Seeder;

class LayerGisSeeder extends Seeder
{
    public function run(): void
    {
        $layers = [
            [
                'nama_layer' => 'Batas Administrasi Kecamatan Kota Palu',
                'jenis_layer' => 'Polygon Administrasi',
                'sumber' => 'BPS / BIG',
                'format_data' => 'GeoJSON',
                'file_path' => 'data/geojson/batas_kecamatan_palu.geojson',
                'status' => 'aktif',
                'keterangan' => 'Poligon 8 kecamatan Kota Palu untuk visualisasi choropleth indeks risiko dan kesiapsiagaan.',
            ],
            [
                'nama_layer' => 'Trase Sesar Aktif Palu-Koro',
                'jenis_layer' => 'LineString Geologi',
                'sumber' => 'PuSGeN (Pusat Studi Gempa Nasional)',
                'format_data' => 'GeoJSON',
                'file_path' => 'data/geojson/sesar_palu_koro.geojson',
                'status' => 'aktif',
                'keterangan' => 'Trase patahan aktif sesar mendatar mengiri (sinistral strike-slip fault) segmen Palu.',
            ],
            [
                'nama_layer' => 'Zona Kerentanan Likuifaksi',
                'jenis_layer' => 'Polygon Kerentanan',
                'sumber' => 'Badan Geologi Kementerian ESDM',
                'format_data' => 'GeoJSON',
                'file_path' => 'data/geojson/zona_kerentanan_likuifaksi.geojson',
                'status' => 'aktif',
                'keterangan' => 'Zonasi kerentanan likuifaksi (Sangat Tinggi, Tinggi, Sedang, Rendah) pasca-bencana 2018.',
            ],
            [
                'nama_layer' => 'Garis Pantai & Sempadan Teluk Palu',
                'jenis_layer' => 'LineString Pesisir',
                'sumber' => 'BIG / Pemkot Palu',
                'format_data' => 'GeoJSON',
                'file_path' => 'data/geojson/garis_pantai_teluk_palu.geojson',
                'status' => 'aktif',
                'keterangan' => 'Kawasan sempadan pantai rawan limpasan/inundasi tsunami lokal Teluk Palu.',
            ],
            [
                'nama_layer' => 'Titik Kumpul & Shelter Evakuasi',
                'jenis_layer' => 'Point Fasilitas',
                'sumber' => 'BPBD Kota Palu',
                'format_data' => 'GeoJSON',
                'file_path' => 'data/geojson/titik_evakuasi_palu.geojson',
                'status' => 'aktif',
                'keterangan' => 'Titik kumpul sementara (TES) dan titik evakuasi akhir (TEA) terdaftar resmi.',
            ],
        ];

        foreach ($layers as $l) {
            LayerGis::create($l);
        }
    }
}
