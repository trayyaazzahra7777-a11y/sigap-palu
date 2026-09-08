<?php

namespace App\Http\Controllers;

use App\Models\Simulasi;
use App\Models\Wilayah;
use App\Services\RiskAnalysisService;
use App\Services\SimulationEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected RiskAnalysisService $riskService,
        protected SimulationEngineService $simService
    ) {}

    public function index(Request $request)
    {
        $wilayahList = Wilayah::all();
        $selectedWilayahId = $request->query('wilayah_id', $wilayahList->first()?->id_wilayah ?? 1);
        $selectedWilayah = Wilayah::find($selectedWilayahId) ?? $wilayahList->first();

        $priorityAreas = $this->riskService->getPriorityAreas();
        $selectedAreaAnalysis = collect($priorityAreas)->firstWhere('id', $selectedWilayah->id_wilayah) ?? [
            'id' => $selectedWilayah->id_wilayah,
            'nama_wilayah' => $selectedWilayah->nama_wilayah,
            'skor_risiko' => 70.0,
            'tingkat_risiko' => 'Tinggi',
            'skor_kesiapsiagaan' => 60.0,
            'tingkat_kesiapsiagaan' => 'Sedang',
            'faktor_utama' => 'Dekat dengan retakan aktif Sesar Palu-Koro.',
        ];

        $userSimulations = Simulasi::where('id_user', Auth::id())
            ->latest() // Otomatis akan menggunakan kolom 'created_at' sesuai standar PRD
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'wilayahList',
            'selectedWilayah',
            'selectedAreaAnalysis',
            'userSimulations'
        ));
    }

    public function simulasiForm()
    {
        $wilayahList = Wilayah::all();
        $recentSimulations = Simulasi::where('id_user', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return view('user.simulasi', compact('wilayahList', 'recentSimulations'));
    }

    public function runSimulasi(Request $request)
    {
        $validated = $request->validate([
            'jenis_simulasi' => 'required|in:gempa,tsunami,likuefaksi',
            'nama_skenario' => 'nullable|string|max:100',
            'magnitudo' => 'nullable|numeric|min:4.0|max:9.5',
            'kedalaman' => 'nullable|numeric|min:2|max:300',
            'pga_g' => 'nullable|numeric|min:0.05|max:1.5',
        ]);

        $jenis = $validated['jenis_simulasi'];
        $result = null;

        if ($jenis === 'gempa') {
            $result = $this->simService->runEarthquakeScenario([
                'nama_skenario' => $validated['nama_skenario'] ?? 'Simulasi Gempa Mandiri',
                'magnitudo' => $validated['magnitudo'] ?? 7.4,
                'kedalaman' => $validated['kedalaman'] ?? 10.0,
                'latitude' => -0.89,
                'longitude' => 119.85,
            ]);
        } elseif ($jenis === 'tsunami') {
            $result = $this->simService->runTsunamiScenario([
                'nama_skenario' => $validated['nama_skenario'] ?? 'Simulasi Tsunami Mandiri',
                'magnitudo' => $validated['magnitudo'] ?? 7.5,
                'tipe_pemicu' => 'Kombinasi Sesar & Longsoran Dasar Laut Teluk Palu',
                'lokasi_pemicu' => 'Teluk Palu',
            ]);
        } else {
            $result = $this->simService->runLiquefactionScenario([
                'nama_skenario' => $validated['nama_skenario'] ?? 'Simulasi Kerentanan Likuifaksi',
                'pga_g' => $validated['pga_g'] ?? 0.35,
            ]);
        }

        $wilayahList = Wilayah::all();
        $recentSimulations = Simulasi::where('id_user', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return view('user.simulasi', [
            'wilayahList' => $wilayahList,
            'recentSimulations' => $recentSimulations,
            'simulationResult' => $result,
        ]);
    }

    /**
     * Menghapus riwayat simulasi milik user yang sedang login.
     */
    public function destroyRiwayat($id)
    {
        Simulasi::hapusMilikUser($id, Auth::id());

        return back()->with('success', 'Riwayat simulasi berhasil dihapus.');
    }

    public function unduhKajian(Request $request)
    {
        $priorityAreas = $this->riskService->getPriorityAreas();
        $user = Auth::user();
        $filename = 'kajian_risiko_warga_'.date('Ymd_His').'.xls';

        return response()->streamDownload(function () use ($priorityAreas, $user) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    body { font-family: "Segoe UI", Arial, sans-serif; }
                    table { border-collapse: collapse; width: 100%; }
                    .header { background-color: #047857; color: #FFFFFF; font-size: 13pt; font-weight: bold; padding: 10px; }
                    th { background-color: #1e293b; color: #FFFFFF; padding: 6px; font-size: 9pt; border: 1px solid #94a3b8; }
                    td { border: 1px solid #cbd5e1; padding: 5px; font-size: 8.5pt; }
                </style>
            </head>
            <body>
                <table>
                    <tr><td colspan="7" class="header">SIGAP-PALU: LAPORAN KAJIAN RISIKO LINGKUNGAN MANDIRI</td></tr>
                    <tr><td colspan="2"><b>Nama Pengguna:</b></td><td colspan="5">'.e($user->name).' ('.e($user->email).')</td></tr>
                    <tr><td colspan="2"><b>Waktu Unduh:</b></td><td colspan="5">'.date('d-m-Y H:i:s').' WITA</td></tr>
                    <tr><td colspan="7"></td></tr>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Kecamatan</th>
                            <th>Skor Risiko</th>
                            <th>Tingkat Risiko</th>
                            <th>Kesiapsiagaan</th>
                            <th>Faktor Utama</th>
                            <th>Rekomendasi Warga</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($priorityAreas as $i => $item) {
                $rank = $i + 1;
                echo "<tr>
                    <td align='center'>#{$rank}</td>
                    <td><b>{$item['nama_wilayah']}</b></td>
                    <td align='center'>{$item['skor_risiko']}</td>
                    <td align='center'>{$item['tingkat_risiko']}</td>
                    <td align='center'>{$item['skor_kesiapsiagaan']}</td>
                    <td>{$item['faktor_utama']}</td>
                    <td>Ketahui jalur evakuasi menuju TES terdekat dan siapkan Tas Siaga Bencana.</td>
                </tr>";
            }
            echo '</tbody></table></body></html>';
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}