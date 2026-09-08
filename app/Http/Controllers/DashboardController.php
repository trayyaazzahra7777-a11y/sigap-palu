<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function index()
    {
        // Menyediakan data riil & fallback simulasi jika database belum dimigrasi penuh
        $wilayah = [
            ['id' => 1, 'nama' => 'Palu Barat', 'lat' => -0.8923, 'lng' => 119.8492, 'risiko' => 'Tinggi', 'kesiapsiagaan' => 'Cukup', 'ancaman' => 'Tinggi', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Sedang'],
            ['id' => 2, 'nama' => 'Palu Timur', 'lat' => -0.8872, 'lng' => 119.8821, 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Baik'],
            ['id' => 3, 'nama' => 'Palu Selatan', 'lat' => -0.9234, 'lng' => 119.8899, 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Baik'],
            ['id' => 4, 'nama' => 'Palu Utara', 'lat' => -0.7915, 'lng' => 119.8631, 'risiko' => 'Rendah', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Rendah', 'kerentanan' => 'Rendah', 'kapasitas' => 'Baik'],
            ['id' => 5, 'nama' => 'Tatanga', 'lat' => -0.9254, 'lng' => 119.8512, 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Cukup', 'ancaman' => 'Sedang', 'kerentanan' => 'Tinggi', 'kapasitas' => 'Sedang'],
            ['id' => 6, 'nama' => 'Ulujadi', 'lat' => -0.8521, 'lng' => 119.8241, 'risiko' => 'Sedang', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Sedang', 'kerentanan' => 'Sedang', 'kapasitas' => 'Baik'],
            ['id' => 7, 'nama' => 'Mantikulore', 'lat' => -0.8712, 'lng' => 119.9142, 'risiko' => 'Rendah', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Rendah', 'kerentanan' => 'Rendah', 'kapasitas' => 'Baik'],
            ['id' => 8, 'nama' => 'Tawaeli', 'lat' => -0.7231, 'lng' => 119.8921, 'risiko' => 'Rendah', 'kesiapsiagaan' => 'Baik', 'ancaman' => 'Rendah', 'kerentanan' => 'Rendah', 'kapasitas' => 'Baik'],
        ];

        return view('dashboard.index', compact('wilayah'));
    }

    public function petaRisiko()
    {
        return $this->index();
    }

    public function gempa()
    {
        $gempa_list = [
            ['waktu' => '08 Sep 2026, 14:12 WITA', 'magnitudo' => '3.2', 'kedalaman' => '10 km', 'lokasi' => '12 km Timur Laut Palu', 'potensi' => 'Tidak Berpotensi Tsunami', 'sumber' => 'BMKG'],
            ['waktu' => '07 Sep 2026, 08:34 WITA', 'magnitudo' => '2.8', 'kedalaman' => '12 km', 'lokasi' => '8 km Barat Daya Sigi', 'potensi' => 'Tidak Berpotensi Tsunami', 'sumber' => 'BMKG'],
            ['waktu' => '05 Sep 2026, 21:05 WITA', 'magnitudo' => '3.5', 'kedalaman' => '9 km', 'lokasi' => 'Teluk Palu Segmen Utara', 'potensi' => 'Tidak Berpotensi Tsunami', 'sumber' => 'BMKG'],
        ];
        return view('dashboard.gempa', compact('gempa_list'));
    }

    public function mukaLaut()
    {
        $data_laut = [
            ['waktu' => '12:00', 'tinggi' => 1.18, 'status' => 'Normal'],
            ['waktu' => '13:00', 'tinggi' => 1.25, 'status' => 'Normal'],
            ['waktu' => '14:00', 'tinggi' => 1.34, 'status' => 'Normal'],
            ['waktu' => '15:00', 'tinggi' => 1.29, 'status' => 'Normal'],
            ['waktu' => '16:00', 'tinggi' => 1.21, 'status' => 'Normal'],
        ];
        return view('dashboard.laut', compact('data_laut'));
    }

    public function kesiapsiagaan()
    {
        return view('dashboard.kesiapsiagaan');
    }

    public function analisis()
    {
        return view('dashboard.analisis');
    }

    public function peringatan()
    {
        return view('dashboard.peringatan');
    }

    public function kejadian()
    {
        return view('dashboard.kejadian');
    }

    public function monitoringRisiko()
    {
        return $this->index();
    }
}