<?php

namespace App\Services;

use App\Models\DataGempa;
use App\Models\LogData;
use App\Models\SumberData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BmkgIntegrationService
{
    // Titik pusat koordinat Kota Palu (Tugu Nol Palu)
    public const PALU_LAT = -0.8972;

    public const PALU_LNG = 119.8707;

    public const MAX_RADIUS_KM = 450; // Radius pemantauan tektonik Palu-Koro

    /**
     * Melakukan sinkronisasi data gempa dari endpoint terbuka resmi BMKG.
     */
    public function syncEarthquakes(): array
    {
        $sumber = SumberData::where('nama_sumber', 'like', '%BMKG%')->first();
        $idSumber = $sumber ? $sumber->id_sumber : 1;

        $newRecords = 0;
        $updatedRecords = 0;
        $errors = [];

        try {
            // 1. Ambil data gempa terbaru (autogempa)
            $autoGempaUrl = 'https://data.bmkg.go.id/DataMKG/TEKTONIK/autogempa.json';
            $responseAuto = Http::timeout(6)->get($autoGempaUrl);

            if ($responseAuto->successful()) {
                $dataAuto = $responseAuto->json('Infogempa.gempa');
                if ($dataAuto) {
                    $res = $this->processRecord($dataAuto, $idSumber);
                    if ($res === 'new') {
                        $newRecords++;
                    }
                    if ($res === 'updated') {
                        $updatedRecords++;
                    }
                }
            }

            // 2. Ambil 15 daftar gempa terkini M 5.0+
            $terkiniUrl = 'https://data.bmkg.go.id/DataMKG/TEKTONIK/gempaterkini.json';
            $responseTerkini = Http::timeout(6)->get($terkiniUrl);

            if ($responseTerkini->successful()) {
                $listGempa = $responseTerkini->json('Infogempa.gempa') ?? [];
                foreach ($listGempa as $gempa) {
                    $res = $this->processRecord($gempa, $idSumber);
                    if ($res === 'new') {
                        $newRecords++;
                    }
                    if ($res === 'updated') {
                        $updatedRecords++;
                    }
                }
            }

            // 3. Ambil daftar gempa dirasakan
            $dirasakanUrl = 'https://data.bmkg.go.id/DataMKG/TEKTONIK/gempadirasakan.json';
            $responseDirasakan = Http::timeout(6)->get($dirasakanUrl);

            if ($responseDirasakan->successful()) {
                $listDirasakan = $responseDirasakan->json('Infogempa.gempa') ?? [];
                foreach ($listDirasakan as $gempa) {
                    $res = $this->processRecord($gempa, $idSumber);
                    if ($res === 'new') {
                        $newRecords++;
                    }
                    if ($res === 'updated') {
                        $updatedRecords++;
                    }
                }
            }

            // Catat log sukses
            if ($sumber) {
                $sumber->update([
                    'status' => 'aktif',
                    'last_update' => now(),
                ]);
            }

            LogData::create([
                'id_user' => auth()->id() ?? null,
                'sumber' => 'BMKG',
                'jenis_data' => 'Data Gempa Tektonik',
                'waktu_update' => now(),
                'status_koneksi' => 'terhubung',
                'keterangan' => "Sinkronisasi BMKG berhasil. {$newRecords} data baru, {$updatedRecords} diperbarui.",
            ]);

            return [
                'success' => true,
                'message' => "Sinkronisasi data BMKG berhasil. {$newRecords} data baru ditambahkan, {$updatedRecords} diperbarui.",
                'new' => $newRecords,
                'updated' => $updatedRecords,
            ];

        } catch (Exception $e) {
            Log::error('BMKG Sync Error: '.$e->getMessage());

            if ($sumber) {
                $sumber->update([
                    'status' => 'gagal',
                ]);
            }

            LogData::create([
                'id_user' => auth()->id() ?? null,
                'sumber' => 'BMKG',
                'jenis_data' => 'Data Gempa Tektonik',
                'waktu_update' => now(),
                'status_koneksi' => 'gagal',
                'keterangan' => 'Gagal terhubung ke server BMKG: '.$e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal terhubung ke server BMKG: '.$e->getMessage(),
                'new' => 0,
                'updated' => 0,
            ];
        }
    }

    /**
     * Memproses satu record gempa BMKG dan menyimpannya jika valid.
     */
    protected function processRecord(array $item, int $idSumber): string
    {
        // Parsing koordinat (Format BMKG: "-0.89,119.85" atau Point)
        $coordStr = $item['Coordinates'] ?? null;
        $lat = 0.0;
        $lng = 0.0;

        if ($coordStr && str_contains($coordStr, ',')) {
            $parts = explode(',', $coordStr);
            $lat = (float) trim($parts[0]);
            $lng = (float) trim($parts[1]);
        } elseif (isset($item['Lintang'], $item['Bujur'])) {
            // BMKG kadang menggunakan "0.89 LS" dan "119.85 BT"
            $lat = $this->parseDmsCoordinate($item['Lintang'], 'lat');
            $lng = $this->parseDmsCoordinate($item['Bujur'], 'lng');
        }

        // Hitung jarak ke Kota Palu (Haversine)
        $jarakKePalu = $this->calculateDistanceKm(self::PALU_LAT, self::PALU_LNG, $lat, $lng);

        // Hanya simpan gempa yang relevan dalam jangkauan regional Sulawesi / Palu-Koro
        // Atau jika koordinat jatuh di Sulawesi Tengah (-2.5 s/d +0.5, 119.0 s/d 121.5)
        $isRegionalPalu = ($jarakKePalu <= self::MAX_RADIUS_KM) ||
            ($lat >= -2.5 && $lat <= 0.5 && $lng >= 119.0 && $lng <= 121.5);

        if (! $isRegionalPalu) {
            return 'skipped';
        }

        // Parsing waktu gempa
        $dateTimeStr = $item['DateTime'] ?? null;
        $waktu = null;
        if ($dateTimeStr) {
            $waktu = Carbon::parse($dateTimeStr);
        } elseif (isset($item['Tanggal'], $item['Jam'])) {
            $waktu = Carbon::createFromFormat('d M Y H:i:s T', $item['Tanggal'].' '.$item['Jam'], 'Asia/Makassar');
        } else {
            $waktu = now();
        }

        // Kedalaman parsing "10 km" -> 10.0
        $kedalamanStr = $item['Kedalaman'] ?? '10 km';
        $kedalaman = (float) preg_replace('/[^0-9.]/', '', $kedalamanStr);

        $magnitudo = (float) ($item['Magnitude'] ?? $item['Magnitudo'] ?? 0.0);
        $wilayah = $item['Wilayah'] ?? 'Sulawesi Tengah';
        $potensi = $item['Potensi'] ?? 'Tidak Berpotensi Tsunami';
        $dirasakan = $item['Dirasakan'] ?? null;

        // Unique Event ID
        $eventId = 'BMKG-'.$waktu->format('YmdHis').'-'.round(abs($lat) * 100).'-'.round(abs($lng) * 100);

        $existing = DataGempa::where('event_id', $eventId)->first();

        if ($existing) {
            $existing->update([
                'magnitudo' => $magnitudo,
                'kedalaman' => $kedalaman,
                'potensi_tsunami' => $potensi,
                'dirasakan' => $dirasakan,
                'status_data' => 'terverifikasi',
            ]);

            return 'updated';
        }

        DataGempa::create([
            'event_id' => $eventId,
            'id_sumber' => $idSumber,
            'tanggal_waktu' => $waktu,
            'magnitudo' => $magnitudo,
            'kedalaman' => $kedalaman,
            'latitude' => $lat,
            'longitude' => $lng,
            'wilayah' => $wilayah,
            'potensi_tsunami' => $potensi,
            'dirasakan' => $dirasakan,
            'sumber' => 'BMKG',
            'status_data' => 'terverifikasi',
        ]);

        return 'new';
    }

    /**
     * Hitung jarak dua titik koordinat bumi dalam satuan kilometer (Haversine formula).
     */
    public function calculateDistanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371.0; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Parsing string koordinat BMKG e.g. "0.89 LS" / "119.85 BT"
     */
    protected function parseDmsCoordinate(string $str, string $type): float
    {
        $val = (float) preg_replace('/[^0-9.]/', '', $str);
        if ($type === 'lat' && (str_contains($str, 'LS') || str_contains($str, 'S'))) {
            return -$val;
        }
        if ($type === 'lng' && (str_contains($str, 'BB') || str_contains($str, 'W'))) {
            return -$val;
        }

        return $val;
    }

    /**
     * Alias wrapper untuk sinkronisasi seluruh sumber BMKG.
     */
    public function syncAllSources(): array
    {
        return $this->syncEarthquakes();
    }

}
