<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Models\Wilayah;
use Illuminate\Support\Collection;

class RiskAnalysisService
{
    /**
     * Menghitung profil risiko dan kesiapsiagaan untuk suatu wilayah berdasarkan indikator lingkungan.
     */
    public function calculateRegionProfile(int $idWilayah): array
    {
        $wilayah = Wilayah::findOrFail($idWilayah);

        // Ambil monitoring gempa bumi aktif terbaru
        $monitoring = Monitoring::with(['monitoringIndikator.indikator'])
            ->where('id_wilayah', $idWilayah)
            ->whereHas('jenisBencana', function ($q) {
                $q->where('nama_bencana', 'Gempa Bumi');
            })
            ->latest('tanggal')
            ->first();

        if (! $monitoring || $monitoring->monitoringIndikator->isEmpty()) {
            return [
                'wilayah' => $wilayah,
                'skor_ancaman' => 50.0,
                'skor_kerentanan' => 50.0,
                'skor_kapasitas' => 50.0,
                'skor_kesiapsiagaan' => 50.0,
                'skor_risiko' => 50.0,
                'tingkat_risiko' => 'Sedang',
                'tingkat_kesiapsiagaan' => 'Cukup',
                'alasan_risiko' => ['Data indikator spesifik wilayah belum diisi lengkap.'],
                'rekomendasi' => 'Lakukan survei lapangan dan verifikasi indikator lingkungan.',
            ];
        }

        // Dekomposisi nilai berdasarkan 4 pilar KLH
        $indikators = $monitoring->monitoringIndikator;

        $ancamanSum = 0.0;
        $ancamanWeight = 0.0;
        $kerentananSum = 0.0;
        $kerentananWeight = 0.0;
        $kapasitasSum = 0.0;
        $kapasitasWeight = 0.0;
        $kesiapsiagaanSum = 0.0;
        $kesiapsiagaanWeight = 0.0;

        $highRiskFactors = [];

        foreach ($indikators as $item) {
            $ind = $item->indikator;
            if (! $ind) {
                continue;
            }

            $val = (float) $item->nilai;
            $w = (float) $ind->bobot;

            switch ($ind->kategori) {
                case 'ancaman':
                    $ancamanSum += ($val * $w);
                    $ancamanWeight += $w;
                    if ($val >= 75) {
                        $highRiskFactors[] = "Tingkat Ancaman: {$ind->nama_indikator} tercatat tinggi ({$val} {$ind->satuan}).";
                    }
                    break;
                case 'kerentanan':
                    $kerentananSum += ($val * $w);
                    $kerentananWeight += $w;
                    if ($val >= 75) {
                        $highRiskFactors[] = "Kerentanan Lingkungan: {$ind->nama_indikator} mencapai ({$val} {$ind->satuan}).";
                    }
                    break;
                case 'kapasitas':
                    $kapasitasSum += ($val * $w);
                    $kapasitasWeight += $w;
                    if ($val < 50) {
                        $highRiskFactors[] = "Kapasitas Terbatas: {$ind->nama_indikator} masih rendah ({$val} {$ind->satuan}).";
                    }
                    break;
                case 'kesiapsiagaan':
                    $kesiapsiagaanSum += ($val * $w);
                    $kesiapsiagaanWeight += $w;
                    break;
            }
        }

        $skorAncaman = $ancamanWeight > 0 ? round($ancamanSum / $ancamanWeight, 1) : 50.0;
        $skorKerentanan = $kerentananWeight > 0 ? round($kerentananSum / $kerentananWeight, 1) : 50.0;
        $skorKapasitas = $kapasitasWeight > 0 ? round($kapasitasSum / $kapasitasWeight, 1) : 50.0;
        $skorKesiapsiagaan = $kesiapsiagaanWeight > 0 ? round($kesiapsiagaanSum / $kesiapsiagaanWeight, 1) : 50.0;

        // Formula Baku Indeks Risiko KLH:
        // Risiko = (Ancaman * Kerentanan) / Kapasitas
        // Normalisasi ke skala 0 - 100
        $rawRisk = ($skorAncaman * $skorKerentanan) / max($skorKapasitas, 10.0);
        $skorRisiko = round(min(100.0, max(0.0, $rawRisk * 0.8)), 1);

        $tingkatRisiko = $this->categorizeRisk($skorRisiko);
        $tingkatKesiapsiagaan = $this->categorizePreparedness($skorKesiapsiagaan);

        if (empty($highRiskFactors)) {
            $highRiskFactors[] = 'Wilayah ini berada pada parameter lingkungan rata-rata stabil berdasarkan data indikator saat ini.';
        }

        return [
            'wilayah' => $wilayah,
            'monitoring' => $monitoring,
            'skor_ancaman' => $skorAncaman,
            'skor_kerentanan' => $skorKerentanan,
            'skor_kapasitas' => $skorKapasitas,
            'skor_kesiapsiagaan' => $skorKesiapsiagaan,
            'skor_risiko' => $skorRisiko,
            'tingkat_risiko' => $tingkatRisiko,
            'tingkat_kesiapsiagaan' => $tingkatKesiapsiagaan,
            'alasan_risiko' => $highRiskFactors,
            'formula_digunakan' => 'Risiko = (Indeks Ancaman × Indeks Kerentanan) / Indeks Kapasitas',
        ];
    }

    /**
     * Menghitung ranking wilayah prioritas penanganan di Kota Palu.
     */
    public function getPriorityAreas(): Collection
    {
        $allWilayah = Wilayah::all();
        $ranking = collect();

        foreach ($allWilayah as $w) {
            $profile = $this->calculateRegionProfile($w->id_wilayah);
            // Indeks prioritas: Risiko tinggi + Kesiapsiagaan rendah = Prioritas paling utama
            $urgensiScore = round(($profile['skor_risiko'] * 1.2) - ($profile['skor_kesiapsiagaan'] * 0.4), 1);

            $ranking->push([
                'id' => $w->id_wilayah,
                'id_wilayah' => $w->id_wilayah,
                'nama_wilayah' => $w->nama_wilayah,
                'kecamatan' => $w->kecamatan,
                'latitude' => $w->latitude,
                'longitude' => $w->longitude,
                'skor_risiko' => $profile['skor_risiko'],
                'tingkat_risiko' => $profile['tingkat_risiko'],
                'skor_kesiapsiagaan' => $profile['skor_kesiapsiagaan'],
                'tingkat_kesiapsiagaan' => $profile['tingkat_kesiapsiagaan'],
                'urgensi_score' => $urgensiScore,
                'faktor_utama' => $profile['alasan_risiko'][0] ?? 'Parameter umum',
            ]);
        }

        return $ranking->sortByDesc('urgensi_score')->values();
    }

    /**
     * Hitung agregasi tingkat risiko kota secara keseluruhan.
     */
    public function getCityWideMetrics(): array
    {
        $priorityAreas = $this->getPriorityAreas();

        $avgRisk = $priorityAreas->avg('skor_risiko') ?? 0;
        $avgPreparedness = $priorityAreas->avg('skor_kesiapsiagaan') ?? 0;

        $tinggiCount = $priorityAreas->where('tingkat_risiko', 'Tinggi')->count();
        $sedangCount = $priorityAreas->where('tingkat_risiko', 'Sedang')->count();
        $rendahCount = $priorityAreas->where('tingkat_risiko', 'Rendah')->count();

        return [
            'skor_risiko_kota' => round($avgRisk, 1),
            'tingkat_risiko_kota' => $this->categorizeRisk($avgRisk),
            'skor_kesiapsiagaan_kota' => round($avgPreparedness, 1),
            'tingkat_kesiapsiagaan_kota' => $this->categorizePreparedness($avgPreparedness),
            'distribusi_risiko' => [
                'Tinggi' => $tinggiCount,
                'Sedang' => $sedangCount,
                'Rendah' => $rendahCount,
            ],
            'total_wilayah' => $priorityAreas->count(),
        ];
    }

    public function categorizeRisk(float $score): string
    {
        if ($score >= 65.0) {
            return 'Tinggi';
        }
        if ($score >= 40.0) {
            return 'Sedang';
        }

        return 'Rendah';
    }

    public function categorizePreparedness(float $score): string
    {
        if ($score >= 80.0) {
            return 'Sangat Baik';
        }
        if ($score >= 65.0) {
            return 'Baik';
        }
        if ($score >= 50.0) {
            return 'Cukup';
        }

        return 'Kurang';
    }
}
