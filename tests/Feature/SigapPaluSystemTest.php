<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SigapPaluSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SIGAP-PALU');
        $response->assertSee('Sesar Palu-Koro');
    }

    public function test_public_monitoring_page_renders_with_sources(): void
    {
        $response = $this->get('/monitoring');
        $response->assertStatus(200);
        $response->assertSee('Monitoring Seismisitas');
        $response->assertSee('BMKG');
    }

    public function test_public_webgis_peta_risiko_renders(): void
    {
        $response = $this->get('/peta-risiko');
        $response->assertStatus(200);
        $response->assertSee('WebGIS Analisis Risiko Bencana');
        $response->assertSee('gis-full-map');
    }

    public function test_public_sejarah_bencana_page_renders(): void
    {
        $response = $this->get('/sejarah');
        $response->assertStatus(200);
        $response->assertSee('28 September 2018');
        $response->assertSee('Mw 7.4');
    }

    public function test_public_edukasi_page_renders(): void
    {
        $response = $this->get('/edukasi');
        $response->assertStatus(200);
        $response->assertSee('Pusat Edukasi & Pengetahuan Kebencanaan');
        $response->assertSee('Likuifaksi');
    }

    public function test_public_mitigasi_page_renders(): void
    {
        $response = $this->get('/mitigasi');
        $response->assertStatus(200);
        $response->assertSee('Tas Siaga Bencana');
        $response->assertSee('Titik Evakuasi Akhir');
    }

    public function test_public_tentang_klh_page_renders(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
        $response->assertSee('10 Komponen Inti Kajian Lingkungan Hidup');
        $response->assertSee('Risiko = (Ancaman × Kerentanan) / Kapasitas');
    }

    public function test_unduh_rekap_spreadsheet_returns_stream(): void
    {
        $response = $this->get('/unduh-rekap');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
    }

    public function test_api_geojson_and_spatial_markers(): void
    {
        $resGeo = $this->get('/api/geojson/batas_kecamatan_palu');
        $resGeo->assertStatus(200);
        $resGeo->assertJsonStructure(['type', 'features']);

        $resMarkers = $this->get('/api/spatial-markers');
        $resMarkers->assertStatus(200);
    }

    public function test_role_access_control(): void
    {
        // 1. Guest redirected to login
        $this->get('/user/dashboard')->assertRedirect('/login');
        $this->get('/operator/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');

        // 2. Warga user
        $warga = User::where('role', 'user')->first();
        $this->actingAs($warga)->get('/user/dashboard')->assertStatus(200);
        $this->actingAs($warga)->get('/admin/dashboard')->assertRedirect('/user/dashboard');

        // 3. Operator
        $operator = User::where('role', 'operator')->first();
        $this->actingAs($operator)->get('/operator/dashboard')->assertStatus(200);
        $this->actingAs($operator)->get('/admin/dashboard')->assertRedirect('/operator/dashboard');

        // 4. Admin
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
    }

    public function test_user_can_run_simulations_with_disclaimer(): void
    {
        $warga = User::where('role', 'user')->first();

        // Simulasi Gempa
        $responseGempa = $this->actingAs($warga)->post('/user/simulasi', [
            'jenis_simulasi' => 'gempa',
            'nama_skenario' => 'Uji Gempa Mw 7.4',
            'magnitudo' => 7.4,
            'kedalaman' => 10,
        ]);
        $responseGempa->assertStatus(200);
        $responseGempa->assertSee('MODE SIMULASI — BUKAN PERINGATAN RESMI');
        $responseGempa->assertSee('Estimasi Sebaran Intensitas MMI per Kecamatan');

        // Simulasi Tsunami
        $responseTsunami = $this->actingAs($warga)->post('/user/simulasi', [
            'jenis_simulasi' => 'tsunami',
            'nama_skenario' => 'Uji Tsunami Teluk Palu',
            'magnitudo' => 7.5,
        ]);
        $responseTsunami->assertStatus(200);
        $responseTsunami->assertSee('MODE SIMULASI — BUKAN PERINGATAN RESMI');
        $responseTsunami->assertSee('Estimasi Waktu Tiba & Limpasan Pesisir');

        // Simulasi Likuifaksi
        $responseLik = $this->actingAs($warga)->post('/user/simulasi', [
            'jenis_simulasi' => 'likuefaksi',
            'nama_skenario' => 'Uji Likuifaksi Petobo Balaroa',
            'pga_g' => 0.40,
        ]);
        $responseLik->assertStatus(200);
        $responseLik->assertSee('MODE SIMULASI — BUKAN PERINGATAN RESMI');
        $responseLik->assertSee('Evaluasi Kerentanan Lapisan Tanah');
    }

    public function test_operator_can_broadcast_warning(): void
    {
        $operator = User::where('role', 'operator')->first();

        $response = $this->actingAs($operator)->post('/operator/peringatan', [
            'jenis_peringatan' => 'Peringatan Gempa Susulan',
            'tingkat' => 'siaga',
            'pesan' => 'Tetap berada di tempat evakuasi sementara dan jauhi tebing.',
        ]);

        $response->assertRedirect('/operator/peringatan');
        $this->assertDatabaseHas('peringatan', [
            'jenis_peringatan' => 'Peringatan Gempa Susulan',
            'tingkat' => 'siaga',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_update_indicator_weight(): void
    {
        $admin = User::where('role', 'admin')->first();
        $ind = Indikator::first();

        $response = $this->actingAs($admin)->post("/admin/indikator/{$ind->id_indikator}", [
            'bobot' => 45.0,
            'deskripsi' => 'Pembobotan evaluasi KLH diperbarui.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('indikator', [
            'id_indikator' => $ind->id_indikator,
            'bobot' => 45.0,
        ]);
    }
}
