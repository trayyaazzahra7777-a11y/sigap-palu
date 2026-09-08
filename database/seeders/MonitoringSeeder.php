<?php

namespace Database\Seeders;

use App\Models\Indikator;
use App\Models\JenisBencana;
use App\Models\Monitoring;
use App\Models\MonitoringIndikator;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class MonitoringSeeder extends Seeder
{
    public function run(): void
    {
        $wilayahList = Wilayah::all();
        $bencanaGempa = JenisBencana::where('nama_bencana', 'Gempa Bumi')->first();
        $bencanaTsunami = JenisBencana::where('nama_bencana', 'Tsunami')->first();
        $indikators = Indikator::all();

        if ($wilayahList->isEmpty() || ! $bencanaGempa || $indikators->isEmpty()) {
            return;
        }

        // Matriks baseline risiko spasial per kecamatan di Kota Palu
        // Berdasarkan kondisi geomorfologi dan riwayat bencana nyata di Palu
        $profilWilayah = [
            'Palu Barat' => ['ancaman' => 'Tinggi', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Sedang', 'risiko' => 'Tinggi', 'kesiapsiagaan' => 'Cukup'],
            'Tatanga' => ['ancaman' => 'Tinggi', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Sedang', 'risiko' => 'Tinggi', 'kesiapsiagaan' => 'Cukup'],
            'Ulujadi' => ['ancaman' => 'Tinggi', 'kerentanan' => 'Sedang', 'kapasitas' => 'Sedang', 'risiko' => 'Tinggi', 'kesiapsiagaan' => 'Baik'],
            'Palu Timur' => ['ancaman' => 'Sedang', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Tinggi', 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik'],
            'Palu Selatan' => ['ancaman' => 'Sedang', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Sedang', 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik'],
            'Palu Utara' => ['ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Sedang', 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Cukup'],
            'Mantikulore' => ['ancaman' => 'Rendah', 'kerentanan' => 'Sedang', 'kapasitas' => 'Tinggi', 'risiko' => 'Rendah', 'kesiapsiagaan' => 'Sangat Baik'],
            'Tawaeli' => ['ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Sedang', 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Cukup'],
        ];

        foreach ($wilayahList as $wilayah) {
            $nama = $wilayah->nama_wilayah;
            $profil = $profilWilayah[$nama] ?? ['ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Sedang', 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik'];

            // Monitoring Gempa Bumi
            $monitoringGempa = Monitoring::create([
                'id_wilayah' => $wilayah->id_wilayah,
                'id_bencana' => $bencanaGempa->id_bencana,
                'tanggal' => now()->toDateString(),
                'tingkat_ancaman' => $profil['ancaman'],
                'tingkat_kerentanan' => $profil['kerentanan'],
                'kapasitas' => $profil['kapasitas'],
                'tingkat_risiko' => $profil['risiko'],
                'tingkat_kesiapsiagaan' => $profil['kesiapsiagaan'],
                'status' => 'aktif',
            ]);

            // Monitoring Tsunami (khusus wilayah pesisir Teluk Palu)
            $isPesisir = in_array($nama, ['Palu Barat', 'Ulujadi', 'Palu Timur', 'Palu Utara', 'Tawaeli']);
            $monitoringTsunami = Monitoring::create([
                'id_wilayah' => $wilayah->id_wilayah,
                'id_bencana' => $bencanaTsunami->id_bencana,
                'tanggal' => now()->toDateString(),
                'tingkat_ancaman' => $isPesisir ? 'Tinggi' : 'Rendah',
                'tingkat_kerentanan' => $isPesisir ? 'Tinggi' : 'Rendah',
                'kapasitas' => $profil['kapasitas'],
                'tingkat_risiko' => $isPesisir ? 'Tinggi' : 'Rendah',
                'tingkat_kesiapsiagaan' => $profil['kesiapsiagaan'],
                'status' => 'aktif',
            ]);

            // Nilai indikator untuk monitoring gempa
            foreach ($indikators as $ind) {
                $nilai = match ($ind->kategori) {
                    'ancaman' => ($profil['ancaman'] === 'Tinggi' ? 85.0 : ($profil['ancaman'] === 'Sedang' ? 60.0 : 35.0)),
                    'kerentanan' => ($profil['kerentanan'] === 'Tinggi' ? 80.0 : ($profil['kerentanan'] === 'Sedang' ? 55.0 : 30.0)),
                    'kapasitas' => ($profil['kapasitas'] === 'Tinggi' ? 75.0 : ($profil['kapasitas'] === 'Sedang' ? 55.0 : 40.0)),
                    'kesiapsiagaan' => ($profil['kesiapsiagaan'] === 'Sangat Baik' ? 90.0 : ($profil['kesiapsiagaan'] === 'Baik' ? 75.0 : 50.0)),
                };

                MonitoringIndikator::create([
                    'id_monitoring' => $monitoringGempa->id_monitoring,
                    'id_indikator' => $ind->id_indikator,
                    'nilai' => $nilai,
                    'status_indikator' => 'terverifikasi',
                ]);
            }
        }
    }
}
