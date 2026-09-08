<?php

namespace Database\Seeders;

use App\Models\DataMukaLaut;
use App\Models\SumberData;
use Illuminate\Database\Seeder;

class DataMukaLautSeeder extends Seeder
{
    public function run(): void
    {
        $sumber = SumberData::where('nama_sumber', 'like', '%BIG%')->first();
        $idSumber = $sumber ? $sumber->id_sumber : 2;

        $tideData = [
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(6)->toDateTimeString(), 'tinggi_muka_laut' => 1.15, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(5)->toDateTimeString(), 'tinggi_muka_laut' => 1.22, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(4)->toDateTimeString(), 'tinggi_muka_laut' => 1.35, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(3)->toDateTimeString(), 'tinggi_muka_laut' => 1.48, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Pasang'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(2)->toDateTimeString(), 'tinggi_muka_laut' => 1.39, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->subHours(1)->toDateTimeString(), 'tinggi_muka_laut' => 1.28, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
            ['stasiun' => 'Pantoloan - Teluk Palu', 'tanggal_waktu' => now()->toDateTimeString(), 'tinggi_muka_laut' => 1.19, 'satuan' => 'meter', 'jenis_data' => 'sensor', 'sumber' => 'BIG - Badan Informasi Geospasial', 'status' => 'Normal'],
        ];

        foreach ($tideData as $t) {
            $t['id_sumber'] = $idSumber;
            DataMukaLaut::create($t);
        }
    }
}
