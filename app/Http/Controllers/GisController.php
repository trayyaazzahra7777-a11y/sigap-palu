<?php

namespace App\Http\Controllers;

use App\Models\DataGempa;
use App\Models\DataMukaLaut;
use App\Models\KejadianBencana;
use App\Models\Wilayah;
use App\Services\RiskAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class GisController extends Controller
{
    public function __construct(protected RiskAnalysisService $riskService) {}

    /**
     * Menyediakan data GeoJSON statis dari public/data/geojson/
     */
    public function getGeoJson(string $layerName): JsonResponse
    {
        // Sanitasi nama file untuk mencegah path traversal
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $layerName);
        $filePath = public_path("data/geojson/{$safeName}.geojson");

        if (! File::exists($filePath)) {
            return response()->json(['error' => 'Layer GeoJSON tidak ditemukan'], 404);
        }

        $rawContent = File::get($filePath);
        $cleanContent = preg_replace('/^\xEF\xBB\xBF/', '', $rawContent);
        $jsonContent = json_decode($cleanContent, true);

        return response()->json($jsonContent);
    }

    /**
     * Mengembalikan data gabungan marker geospasial real-time:
     * Gempa BMKG, Stasiun Pasut Teluk Palu, dan Kejadian Terverifikasi.
     */
    public function getSpatialMarkers(): JsonResponse
    {
        $gempa = DataGempa::terbaru()->limit(15)->get();
        $mukaLaut = DataMukaLaut::terbaru()->limit(5)->get();
        $kejadian = KejadianBencana::with(['wilayah', 'jenisBencana'])
            ->where('status', 'diverifikasi')
            ->latest('tanggal_waktu')
            ->get();
        $wilayahRisiko = $this->riskService->getPriorityAreas();

        return response()->json([
            'gempa' => $gempa,
            'muka_laut' => $mukaLaut,
            'kejadian' => $kejadian,
            'wilayah_risiko' => $wilayahRisiko,
        ]);
    }

    /**
     * Mengembalikan profil risiko spesifik wilayah beserta penjelasan indikatornya.
     */
    public function getRegionProfile(int $idWilayah): JsonResponse
    {
        $profile = $this->riskService->calculateRegionProfile($idWilayah);

        return response()->json($profile);
    }
}
