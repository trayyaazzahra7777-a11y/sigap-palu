<?php

namespace App\Http\Controllers;

use App\Models\DataGempa;
use App\Models\DataMukaLaut;
use App\Models\Peringatan;
use App\Models\SumberData;
use App\Models\Wilayah;
use App\Services\RiskAnalysisService;

class DashboardController extends Controller
{
    public function __construct(protected RiskAnalysisService $riskService) {}

    /**
     * Beranda Publik SIGAP-PALU
     */
    public function landing()
    {
        // 1. Data Seismisitas Aktual (BMKG)
        $gempaTerbaru = DataGempa::terbaru()->first();
        $gempaList = DataGempa::terbaru()->limit(5)->get();

        // 2. Data Pasang Surut / Muka Laut Teluk Palu
        $mukaLautTerbaru = DataMukaLaut::terbaru()->first();
        $mukaLautList = DataMukaLaut::terbaru()->limit(7)->get();

        // 3. Peringatan Dini Aktif
        $peringatanAktif = Peringatan::with('wilayah')
            ->aktif()
            ->latest('waktu_mulai')
            ->get();

        // 4. Metrik Risiko Kota Dihitung Dinamis dari Database
        $cityMetrics = $this->riskService->getCityWideMetrics();

        // 5. Wilayah Prioritas
        $priorityAreas = $this->riskService->getPriorityAreas();

        // 6. Status Sumber Data
        $sumberData = SumberData::all();

        return view('landing', compact(
            'gempaTerbaru',
            'gempaList',
            'mukaLautTerbaru',
            'mukaLautList',
            'peringatanAktif',
            'cityMetrics',
            'priorityAreas',
            'sumberData'
        ));
    }

    /**
     * Halaman Monitoring Publik
     */
    public function monitoring()
    {
        $gempaList = DataGempa::terbaru()->paginate(10);
        $mukaLautList = DataMukaLaut::terbaru()->paginate(10);
        $peringatanList = Peringatan::with('wilayah')->latest('waktu_mulai')->get();
        $sumberData = SumberData::all();
        $cityMetrics = $this->riskService->getCityWideMetrics();

        return view('public.monitoring', compact(
            'gempaList',
            'mukaLautList',
            'peringatanList',
            'sumberData',
            'cityMetrics'
        ));
    }

    /**
     * Halaman Peta Risiko Interaktif Terbuka
     */
    public function petaRisiko()
    {
        $wilayahList = Wilayah::all();
        $priorityAreas = $this->riskService->getPriorityAreas();
        $gempaTerbaru = DataGempa::terbaru()->limit(10)->get();

        return view('public.peta-risiko', compact('wilayahList', 'priorityAreas', 'gempaTerbaru'));
    }

    /**
     * Halaman Sejarah Bencana 28 September 2018
     */
    public function sejarah()
    {
        return view('public.sejarah');
    }

    /**
     * Halaman Pusat Edukasi Kebencanaan
     */
    public function edukasi(?string $topic = null)
    {
        return view('public.edukasi', compact('topic'));
    }

    /**
     * Halaman Mitigasi & Kesiapsiagaan
     */
    public function mitigasi()
    {
        return view('public.mitigasi');
    }

    /**
     * Halaman Tentang Sistem & Kajian Lingkungan Hidup
     */
    public function tentang()
    {
        return view('public.tentang');
    }

    /**
     * Export / Download Rekap Data Kesiapsiagaan Wilayah
     */
    public function unduhRekap()
    {
        $priorityAreas = $this->riskService->getPriorityAreas();
        $filename = 'rekap_kesiapsiagaan_palu_'.date('Ymd_His').'.xls';

        return response()->streamDownload(function () use ($priorityAreas) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    body { font-family: "Segoe UI", Tahoma, Arial, sans-serif; }
                    table { border-collapse: collapse; width: 100%; }
                    .banner-title { background-color: #059669; color: #FFFFFF; font-size: 14pt; font-weight: bold; padding: 12px; }
                    .meta-row { font-size: 9pt; color: #475569; padding: 4px; }
                    th { background-color: #0f172a; color: #FFFFFF; font-size: 9.5pt; font-weight: bold; border: 1px solid #94a3b8; padding: 8px; text-align: center; }
                    td { border: 1px solid #cbd5e1; font-size: 9pt; padding: 6px 8px; vertical-align: middle; }
                    .center { text-align: center; }
                    .badge-tinggi { background-color: #fee2e2; color: #991b1b; font-weight: bold; text-align: center; }
                    .badge-sedang { background-color: #fef3c7; color: #92400e; font-weight: bold; text-align: center; }
                    .badge-rendah { background-color: #dcfce7; color: #166534; font-weight: bold; text-align: center; }
                </style>
            </head>
            <body>
                <table>
                    <tr>
                        <td colspan="9" class="banner-title">
                            SIGAP-PALU: REKAPITULASI PROFIL RISIKO & KESIAPSIAGAAN BENCANA WILAYAH
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="meta-row"><b>Waktu Unduh:</b></td>
                        <td colspan="7" class="meta-row">'.date('d-m-Y H:i:s').' WITA</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="meta-row"><b>Formula KLH:</b></td>
                        <td colspan="7" class="meta-row">Risiko = (Indeks Ancaman × Indeks Kerentanan) / Indeks Kapasitas</td>
                    </tr>
                    <tr><td colspan="9" style="border:none; height:8px;"></td></tr>
                    <thead>
                        <tr>
                            <th>Peringkat Prioritas</th>
                            <th>Kecamatan</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Skor Risiko (0-100)</th>
                            <th>Tingkat Risiko</th>
                            <th>Skor Kesiapsiagaan</th>
                            <th>Tingkat Kesiapsiagaan</th>
                            <th>Faktor Risiko Utama</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($priorityAreas as $idx => $item) {
                $rank = $idx + 1;
                $clsRisiko = match ($item['tingkat_risiko']) {
                    'Tinggi' => 'badge-tinggi',
                    'Sedang' => 'badge-sedang',
                    default => 'badge-rendah',
                };

                echo "<tr>
                    <td class='center'>#{$rank}</td>
                    <td><b>{$item['nama_wilayah']}</b></td>
                    <td class='center'>{$item['latitude']}</td>
                    <td class='center'>{$item['longitude']}</td>
                    <td class='center'>{$item['skor_risiko']}</td>
                    <td class='{$clsRisiko}'>{$item['tingkat_risiko']}</td>
                    <td class='center'>{$item['skor_kesiapsiagaan']}</td>
                    <td class='center'>{$item['tingkat_kesiapsiagaan']}</td>
                    <td>{$item['faktor_utama']}</td>
                </tr>";
            }

            echo '</tbody></table></body></html>';
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
