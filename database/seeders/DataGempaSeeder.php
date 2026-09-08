<?php

namespace Database\Seeders;

use App\Models\DataGempa;
use App\Models\SumberData;
use Illuminate\Database\Seeder;

class DataGempaSeeder extends Seeder
{
    public function run(): void
    {
        $sumber = SumberData::where('nama_sumber', 'like', '%BMKG%')->first();
        $idSumber = $sumber ? $sumber->id_sumber : 1;

        $gempaList = [
            [
                'event_id' => 'BMKG-20180928-170244-PaluMainshock',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2018-09-28 18:02:44',
                'magnitudo' => 7.5,
                'kedalaman' => 10.0,
                'latitude' => -0.178,
                'longitude' => 119.840,
                'wilayah' => '26 km Utara Donggala - Teluk Palu',
                'potensi_tsunami' => 'Berpotensi Tsunami (Status Awas: Palu & Donggala Barat)',
                'dirasakan' => 'VIII-IX MMI di Palu, VII-VIII MMI di Donggala',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20180928-140000-PaluForeshock',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2018-09-28 15:00:00',
                'magnitudo' => 6.0,
                'kedalaman' => 10.0,
                'latitude' => -0.350,
                'longitude' => 119.780,
                'wilayah' => 'Donggala - Pantai Barat',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'VI-VII MMI di Donggala dan Palu',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20180928-171400-PaluAftershock',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2018-09-28 18:14:00',
                'magnitudo' => 5.8,
                'kedalaman' => 10.0,
                'latitude' => -0.280,
                'longitude' => 119.820,
                'wilayah' => 'Teluk Palu',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'V-VI MMI di Palu',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20120818-164100-SigiPalu',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2012-08-18 17:41:00',
                'magnitudo' => 6.2,
                'kedalaman' => 10.0,
                'latitude' => -1.330,
                'longitude' => 119.980,
                'wilayah' => 'Lembah Palu - Sigi',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'VI MMI di Palu dan Sigi',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20260510-141200-PaluTimur',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2026-05-10 15:12:00',
                'magnitudo' => 3.4,
                'kedalaman' => 8.0,
                'latitude' => -0.887,
                'longitude' => 119.882,
                'wilayah' => '6 km Timur Laut Palu Timur',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'II-III MMI di Palu Timur',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20260601-082400-PaluBarat',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2026-06-01 09:24:00',
                'magnitudo' => 3.8,
                'kedalaman' => 9.0,
                'latitude' => -0.892,
                'longitude' => 119.849,
                'wilayah' => 'Segmen Sesar Palu Barat - Ulujadi',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'III MMI di Palu Barat dan Tatanga',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
            [
                'event_id' => 'BMKG-20260905-210500-TelukPalu',
                'id_sumber' => $idSumber,
                'tanggal_waktu' => '2026-09-05 22:05:00',
                'magnitudo' => 3.2,
                'kedalaman' => 10.0,
                'latitude' => -0.820,
                'longitude' => 119.855,
                'wilayah' => 'Perairan Teluk Palu Bagian Tengah',
                'potensi_tsunami' => 'Tidak Berpotensi Tsunami',
                'dirasakan' => 'II MMI di Ulujadi dan Palu Utara',
                'sumber' => 'BMKG',
                'status_data' => 'terverifikasi',
            ],
        ];

        foreach ($gempaList as $g) {
            DataGempa::updateOrCreate(['event_id' => $g['event_id']], $g);
        }
    }
}
