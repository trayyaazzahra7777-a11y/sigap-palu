<?php

namespace Database\Seeders;

use App\Models\Indikator;
use Illuminate\Database\Seeder;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $indikators = [
            // Kategori: Ancaman (Hazard)
            [
                'nama_indikator' => 'Kedekatan dengan Jejak Sesar Palu-Koro',
                'kategori' => 'ancaman',
                'satuan' => 'km',
                'bobot' => 0.35,
                'deskripsi' => 'Jarak rata-rata permukiman di kecamatan terhadap jejak patahan aktif Sesar Palu-Koro.',
            ],
            [
                'nama_indikator' => 'Keterpaparan Sempadan Pantai Teluk Palu',
                'kategori' => 'ancaman',
                'satuan' => '% wilayah pesisir',
                'bobot' => 0.35,
                'deskripsi' => 'Persentase wilayah kecamatan yang berada pada elevasi < 10 mdpl di pesisir Teluk Palu rawan tsunami.',
            ],
            [
                'nama_indikator' => 'Kerapatan Seismisitas Sejarah',
                'kategori' => 'ancaman',
                'satuan' => 'kejadian/dekade',
                'bobot' => 0.30,
                'deskripsi' => 'Jumlah gempa dangkal berpusat di sekitar kecamatan dalam 20 tahun terakhir.',
            ],

            // Kategori: Kerentanan (Vulnerability)
            [
                'nama_indikator' => 'Proporsi Wilayah Zona Likuifaksi Tinggi',
                'kategori' => 'kerentanan',
                'satuan' => '% luas',
                'bobot' => 0.40,
                'deskripsi' => 'Rasio luas zona kerentanan likuifaksi tinggi/sangat tinggi terhadap total luas kecamatan.',
            ],
            [
                'nama_indikator' => 'Kepadatan Penduduk',
                'kategori' => 'kerentanan',
                'satuan' => 'jiwa/km²',
                'bobot' => 0.35,
                'deskripsi' => 'Konsentrasi populasi yang rentan terdampak saat bencana berlangsung.',
            ],
            [
                'nama_indikator' => 'Rasio Bangunan Rentan Kerusakan',
                'kategori' => 'kerentanan',
                'satuan' => '%',
                'bobot' => 0.25,
                'deskripsi' => 'Persentase rumah tangga dengan konstruksi bangunan sederhana non-engineered.',
            ],

            // Kategori: Kapasitas (Capacity)
            [
                'nama_indikator' => 'Ketersediaan Shelter & Titik Evakuasi Aman',
                'kategori' => 'kapasitas',
                'satuan' => 'titik/kecamatan',
                'bobot' => 0.40,
                'deskripsi' => 'Ketersediaan ruang terbuka aman dan gedung shelter evakuasi vertikal/horizontal.',
            ],
            [
                'nama_indikator' => 'Aksesibilitas Fasilitas Kesehatan Rujukan',
                'kategori' => 'kapasitas',
                'satuan' => 'unit',
                'bobot' => 0.35,
                'deskripsi' => 'Jumlah RS/Puskesmas siaga darurat dengan akses jalur tidak terputus.',
            ],
            [
                'nama_indikator' => 'Relawan & Tim Siaga Bencana Kelurahan',
                'kategori' => 'kapasitas',
                'satuan' => 'orang',
                'bobot' => 0.25,
                'deskripsi' => 'Jumlah personil relawan tanggap bencana terlatih di tingkat kelurahan.',
            ],

            // Kategori: Kesiapsiagaan (Preparedness)
            [
                'nama_indikator' => 'Keterjangkauan Sirine & Sistem Peringatan Dini',
                'kategori' => 'kesiapsiagaan',
                'satuan' => '% cakupan',
                'bobot' => 0.40,
                'deskripsi' => 'Cakupan jangkauan sirine tsunami dan diseminasi peringatan dini BMKG di kecamatan.',
            ],
            [
                'nama_indikator' => 'Kelengkapan Peta & Rambu Jalur Evakuasi',
                'kategori' => 'kesiapsiagaan',
                'satuan' => '% kelurahan terpasang',
                'bobot' => 0.35,
                'deskripsi' => 'Persentase kelurahan yang memiliki rambu evakuasi terverifikasi dan jelas.',
            ],
            [
                'nama_indikator' => 'Frekuensi Simulasi & Sosialisasi Mitigasi Warga',
                'kategori' => 'kesiapsiagaan',
                'satuan' => 'kali/tahun',
                'bobot' => 0.25,
                'deskripsi' => 'Frekuensi gladi lapang atau edukasi evakuasi mandiri bersama warga dalam setahun.',
            ],
        ];

        foreach ($indikators as $ind) {
            Indikator::create($ind);
        }
    }
}
