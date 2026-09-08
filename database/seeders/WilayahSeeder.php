<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = [
            ['nama_wilayah' => 'Palu Barat', 'kecamatan' => 'Palu Barat', 'latitude' => -0.8923, 'longitude' => 119.8492],
            ['nama_wilayah' => 'Palu Timur', 'kecamatan' => 'Palu Timur', 'latitude' => -0.8872, 'longitude' => 119.8821],
            ['nama_wilayah' => 'Palu Selatan', 'kecamatan' => 'Palu Selatan', 'latitude' => -0.9234, 'longitude' => 119.8899],
            ['nama_wilayah' => 'Palu Utara', 'kecamatan' => 'Palu Utara', 'latitude' => -0.7915, 'longitude' => 119.8631],
            ['nama_wilayah' => 'Tatanga', 'kecamatan' => 'Tatanga', 'latitude' => -0.9254, 'longitude' => 119.8512],
            ['nama_wilayah' => 'Ulujadi', 'kecamatan' => 'Ulujadi', 'latitude' => -0.8521, 'longitude' => 119.8241],
            ['nama_wilayah' => 'Mantikulore', 'kecamatan' => 'Mantikulore', 'latitude' => -0.8712, 'longitude' => 119.9142],
            ['nama_wilayah' => 'Tawaeli', 'kecamatan' => 'Tawaeli', 'latitude' => -0.7231, 'longitude' => 119.8921],
        ];

        foreach ($wilayah as $w) {
            Wilayah::updateOrCreate(['nama_wilayah' => $w['nama_wilayah']], $w);
        }
    }
}
