<?php

namespace App\Services;

use App\Models\Simulasi;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;

class SimulationEngineService
{
    public const WATER_DEPTH_BAY_M = 300.0; // Rata-rata kedalaman batimetri Teluk Palu (m)

    public const GRAVITY = 9.8; // m/s^2

    /**
     * Menjalankan Skenario Simulasi Gempa Bumi.
     */
    public function runEarthquakeScenario(array $params): array
    {
        $mag = (float) ($params['magnitudo'] ?? 7.0);
        $depth = (float) ($params['kedalaman'] ?? 10.0);
        $lat = (float) ($params['latitude'] ?? -0.89);
        $lng = (float) ($params['longitude'] ?? 119.85);
        $skenarioName = $params['nama_skenario'] ?? 'Skenario Gempa Sesar Palu-Koro M'.$mag;

        $wilayahList = Wilayah::all();
        $impacts = [];
        $maxMmi = 1.0;

        foreach ($wilayahList as $w) {
            $distKm = $this->calculateDistanceKm($lat, $lng, $w->latitude, $w->longitude);
            // Jarak hiposenter R = sqrt(D_epi^2 + Depth^2)
            $hypoDist = sqrt(($distKm * $distKm) + ($depth * $depth));

            // Formula Atenuasi Intensitas MMI Esteva & Joyner-Boore modifikasi regional
            // MMI = 1.5 * M - 3.25 * ln(R) + 4.5
            $rawMmi = 1.5 * $mag - 3.1 * log(max($hypoDist, 1.0)) + 3.8;
            $mmi = max(1.0, min(12.0, round($rawMmi, 1)));

            if ($mmi > $maxMmi) {
                $maxMmi = $mmi;
            }

            $impacts[] = [
                'id_wilayah' => $w->id_wilayah,
                'nama_wilayah' => $w->nama_wilayah,
                'jarak_km' => round($distKm, 1),
                'mmi' => $mmi,
                'skala_romawi' => $this->convertToRomanMmi((int) round($mmi)),
                'deskripsi_dampak' => $this->describeMmiImpact($mmi),
                'tingkat_bahaya' => $mmi >= 7.0 ? 'Tinggi' : ($mmi >= 5.0 ? 'Sedang' : 'Rendah'),
            ];
        }

        // Urutkan berdasarkan dampak MMI tertinggi
        usort($impacts, fn ($a, $b) => $b['mmi'] <=> $a['mmi']);

        $hasilRingkas = "Skenario Gempa M{$mag} Kedalaman {$depth} km menghasilkan estimasi intensitas puncak {$this->convertToRomanMmi((int) round($maxMmi))} MMI pada wilayah terdekat.";

        // Simpan riwayat simulasi ke tabel database simulasi
        $simulasiRecord = Simulasi::create([
            'id_user' => Auth::id() ?? 1,
            'jenis_simulasi' => 'gempa',
            'nama_skenario' => $skenarioName,
            'parameter' => array_merge($params, [
                'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            ]),
            'hasil_ringkas' => $hasilRingkas,
            'status' => 'selesai',
        ]);

        return [
            'simulasi_id' => $simulasiRecord->id_simulasi,
            'jenis' => 'gempa',
            'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            'nama_skenario' => $skenarioName,
            'parameter_input' => [
                'magnitudo' => $mag,
                'kedalaman_km' => $depth,
                'koordinat_episenter' => "{$lat}, {$lng}",
            ],
            'intensitas_puncak_mmi' => $this->convertToRomanMmi((int) round($maxMmi)),
            'hasil_per_wilayah' => $impacts,
            'hasil_ringkas' => $hasilRingkas,
        ];
    }

    /**
     * Menjalankan Skenario Simulasi Tsunami Teluk Palu.
     */
    public function runTsunamiScenario(array $params): array
    {
        $mag = (float) ($params['magnitudo'] ?? 7.5);
        $sourceType = $params['tipe_pemicu'] ?? 'Kombinasi Sesar & Longsoran Dasar Laut (Submarine Landslide)';
        $epicenterLoc = $params['lokasi_pemicu'] ?? 'Mulut Teluk Palu - Donggala';
        $skenarioName = $params['nama_skenario'] ?? 'Simulasi Skenario Tsunami Teluk Palu';

        // Kecepatan gelombang air dangkal v = sqrt(g * d)
        $waveSpeedMs = sqrt(self::GRAVITY * self::WATER_DEPTH_BAY_M); // ~54.2 m/s (~195 km/jam)
        $waveSpeedKmh = $waveSpeedMs * 3.6;

        // Titik pesisir kritis di Teluk Palu
        $coastalPoints = [
            ['nama' => 'Pesisir Palu Barat (Kampung Baru / Talise Barat)', 'jarak_km' => 18.0, 'kecamatan' => 'Palu Barat', 'amplifikasi' => 1.4],
            ['nama' => 'Pesisir Ulujadi (Pantoloan Selatan / Tipo)', 'jarak_km' => 12.0, 'kecamatan' => 'Ulujadi', 'amplifikasi' => 1.2],
            ['nama' => 'Pesisir Palu Timur (Pantai Talise)', 'jarak_km' => 20.0, 'kecamatan' => 'Palu Timur', 'amplifikasi' => 1.5],
            ['nama' => 'Pesisir Palu Utara (Taipa / Mamboro)', 'jarak_km' => 14.0, 'kecamatan' => 'Palu Utara', 'amplifikasi' => 1.3],
            ['nama' => 'Pesisir Tawaeli (Pelabuhan Pantoloan)', 'jarak_km' => 8.0, 'kecamatan' => 'Tawaeli', 'amplifikasi' => 1.1],
        ];

        $results = [];

        foreach ($coastalPoints as $pt) {
            // Waktu tempuh (ETA) dalam menit = (jarak / kecepatan) * 60
            $etaMinutes = ($pt['jarak_km'] / $waveSpeedKmh) * 60.0;
            // Faktor amplifikasi teluk menyempit (bay resonance & shallowing effect)
            $estimatedRunupMeters = round((0.8 * ($mag - 5.5)) * $pt['amplifikasi'], 1);
            $estimatedRunupMeters = max(1.0, min(15.0, $estimatedRunupMeters));

            $results[] = [
                'wilayah_pesisir' => $pt['nama'],
                'kecamatan' => $pt['kecamatan'],
                'jarak_dari_pemicu_km' => $pt['jarak_km'],
                'estimasi_waktu_tiba_menit' => round($etaMinutes, 1),
                'perkiraan_tinggi_runup_m' => $estimatedRunupMeters,
                'tingkat_ancaman' => $estimatedRunupMeters >= 3.0 ? 'Awas' : ($estimatedRunupMeters >= 1.0 ? 'Siaga' : 'Waspada'),
                'tindakan_mitigasi' => 'Segera evakuasi mandiri ke tempat berketinggian > 20 mdpl tanpa menunggu sirine resmi.',
            ];
        }

        $hasilRingkas = 'Skenario tsunami Teluk Palu memprediksi waktu tiba gelombang amat singkat (ETA 3-8 menit) dengan potensi ketinggian limpasan signifikan di pesisir Talise dan Ulujadi.';

        $simulasiRecord = Simulasi::create([
            'id_user' => Auth::id() ?? 1,
            'jenis_simulasi' => 'tsunami',
            'nama_skenario' => $skenarioName,
            'parameter' => array_merge($params, [
                'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            ]),
            'hasil_ringkas' => $hasilRingkas,
            'status' => 'selesai',
        ]);

        return [
            'simulasi_id' => $simulasiRecord->id_simulasi,
            'jenis' => 'tsunami',
            'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            'nama_skenario' => $skenarioName,
            'parameter_input' => [
                'magnitudo' => $mag,
                'tipe_pemicu' => $sourceType,
                'lokasi_pemicu' => $epicenterLoc,
                'kecepatan_rata_gelombang_kmh' => round($waveSpeedKmh, 1),
            ],
            'hasil_per_pesisir' => $results,
            'hasil_ringkas' => $hasilRingkas,
        ];
    }

    /**
     * Menjalankan Skenario Simulasi Likuifaksi.
     */
    public function runLiquefactionScenario(array $params): array
    {
        $pgaThreshold = (float) ($params['pga_g'] ?? 0.35); // Peak Ground Acceleration in g
        $groundwaterLevel = $params['muka_air_tanah'] ?? 'Dangkal (< 3 meter)';
        $skenarioName = $params['nama_skenario'] ?? 'Simulasi Kerentanan Likuifaksi Aluvial';

        $zoneVulnerability = [
            ['zona' => 'Petobo & Sekitarnya', 'kecamatan' => 'Palu Selatan', 'litologi' => 'Pasir Lepas Aluvial Jenuh Air', 'potensi' => 'Sangat Tinggi (Flow Liquefaction)', 'rekomendasi' => 'Zona Terlarang Pemukiman Padat (ZNT 4)'],
            ['zona' => 'Balaroa & Silae', 'kecamatan' => 'Palu Barat', 'litologi' => 'Endapan Koluvial & Pasir Halus', 'potensi' => 'Sangat Tinggi (Amblesan Lateral)', 'rekomendasi' => 'Rehabilitasi Lahan & Pembatasan Beban'],
            ['zona' => 'Tatanga & Palu Lembah', 'kecamatan' => 'Tatanga', 'litologi' => 'Lempung Pasiran Aluvial', 'potensi' => 'Tinggi (Lateral Spreading)', 'rekomendasi' => 'Struktur Pondasi Khusus Anti-Likuifaksi'],
            ['zona' => 'Pesisir Pantai Talise', 'kecamatan' => 'Palu Timur', 'litologi' => 'Pasir Pantai & Lumpur', 'potensi' => 'Sedang (Boiling Sand)', 'rekomendasi' => 'Drainase Terkontrol & Perkuatan Tanggul'],
            ['zona' => 'Mantikulore Perbukitan', 'kecamatan' => 'Mantikulore', 'litologi' => 'Batuan Dasar Metamorfik Keras', 'potensi' => 'Rendah / Tidak Rentan', 'rekomendasi' => 'Relokasi & Kawasan Pengembangan Pemukiman'],
        ];

        $hasilRingkas = "Skenario percepatan getaran tanah (PGA {$pgaThreshold}g) berpotensi memicu likuifaksi kritis pada zona aluvial berair tanah dangkal di Petobo, Balaroa, dan Tatanga.";

        $simulasiRecord = Simulasi::create([
            'id_user' => Auth::id() ?? 1,
            'jenis_simulasi' => 'likuefaksi',
            'nama_skenario' => $skenarioName,
            'parameter' => array_merge($params, [
                'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            ]),
            'hasil_ringkas' => $hasilRingkas,
            'status' => 'selesai',
        ]);

        return [
            'simulasi_id' => $simulasiRecord->id_simulasi,
            'jenis' => 'likuefaksi',
            'disclaimer' => 'MODE SIMULASI — BUKAN PERINGATAN RESMI',
            'nama_skenario' => $skenarioName,
            'parameter_input' => [
                'percepatan_tanah_pga' => "{$pgaThreshold} g",
                'kondisi_air_tanah' => $groundwaterLevel,
            ],
            'zona_analisis' => $zoneVulnerability,
            'hasil_ringkas' => $hasilRingkas,
        ];
    }

    private function calculateDistanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371.0;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    private function convertToRomanMmi(int $val): string
    {
        $map = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];

        return $map[$val] ?? (string) $val;
    }

    private function describeMmiImpact(float $mmi): string
    {
        if ($mmi >= 8.5) {
            return 'Kerusakan masif, struktur bangunan roboh, rekahan tanah lebar, ancaman likuifaksi tinggi.';
        }
        if ($mmi >= 7.0) {
            return 'Kerusakan berat pada bangunan sederhana, dinding retak atau runtuh, perabot terpelanting.';
        }
        if ($mmi >= 5.5) {
            return 'Getaran kuat dirasakan semua orang, plester dinding rontok, barang tergantung berayun keras.';
        }
        if ($mmi >= 4.0) {
            return 'Getaran dirasakan nyata di dalam rumah, jendela dan pintu berderit, mobil bergoyang ringan.';
        }

        return 'Getaran lemah, hanya dirasakan oleh sebagian orang yang sedang beristirahat.';
    }
}
