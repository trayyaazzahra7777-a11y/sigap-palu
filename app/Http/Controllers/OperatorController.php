<?php

namespace App\Http\Controllers;

use App\Models\DataGempa;
use App\Models\DataMukaLaut;
use App\Models\JenisBencana;
use App\Models\KejadianBencana;
use App\Models\Peringatan;
use App\Models\SumberData;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $peringatanAktif = Peringatan::with('wilayah')->aktif()->latest('waktu_mulai')->get();
        $gempaTerbaru = DataGempa::terbaru()->limit(5)->get();
        $mukaLautTerbaru = DataMukaLaut::terbaru()->limit(5)->get();
        $kejadianList = KejadianBencana::with(['wilayah', 'jenisBencana'])->latest('tanggal_waktu')->limit(5)->get();

        $stats = [
            'peringatan_aktif' => $peringatanAktif->count(),
            'gempa_terekam' => DataGempa::count(),
            'pantau_muka_laut' => DataMukaLaut::count(),
            'total_kejadian' => KejadianBencana::count(),
        ];

        return view('operator.dashboard', compact(
            'peringatanAktif',
            'gempaTerbaru',
            'mukaLautTerbaru',
            'kejadianList',
            'stats'
        ));
    }

    public function peringatanIndex()
    {
        $peringatanList = Peringatan::with('wilayah')->latest('waktu_mulai')->paginate(15);
        $wilayahList = Wilayah::all();

        return view('operator.peringatan', compact('peringatanList', 'wilayahList'));
    }

    public function peringatanStore(Request $request)
    {
        $validated = $request->validate([
            'id_wilayah' => 'nullable|exists:wilayah,id_wilayah',
            'jenis_peringatan' => 'required|string|max:50',
            'tingkat' => 'required|in:informasi,waspada,siaga,peringatan',
            'pesan' => 'required|string|max:1000',
        ]);

        Peringatan::create([
            'id_wilayah' => ! empty($validated['id_wilayah']) ? $validated['id_wilayah'] : null,
            'jenis_peringatan' => $validated['jenis_peringatan'],
            'tingkat' => $validated['tingkat'],
            'pesan' => $validated['pesan'],
            'waktu_mulai' => now(),
            'status' => 'aktif',
        ]);

        return redirect()->route('operator.peringatan')->with('success', 'Siaran peringatan dini berhasil dipublikasikan ke sistem!');
    }

    public function peringatanSelesai($id)
    {
        $peringatan = Peringatan::findOrFail($id);
        $peringatan->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);

        return redirect()->back()->with('success', 'Status peringatan telah diperbarui menjadi Selesai.');
    }

    public function kejadianIndex()
    {
        $kejadianList = KejadianBencana::with(['wilayah', 'jenisBencana', 'dokumentasiKejadian'])
            ->latest('tanggal_waktu')
            ->paginate(15);
        $wilayahList = Wilayah::all();
        $jenisBencanaList = JenisBencana::all();

        return view('operator.kejadian', compact('kejadianList', 'wilayahList', 'jenisBencanaList'));
    }

    public function kejadianStore(Request $request)
    {
        $validated = $request->validate([
            'id_wilayah' => 'required|exists:wilayah,id_wilayah',
            'id_bencana' => 'required|exists:jenis_bencana,id_bencana',
            'lokasi' => 'required|string|max:200',
            'keterangan' => 'required|string',
            'dampak' => 'nullable|string',
        ]);

        KejadianBencana::create([
            'id_wilayah' => $validated['id_wilayah'],
            'id_bencana' => $validated['id_bencana'],
            'tanggal_waktu' => now(),
            'lokasi' => $validated['lokasi'],
            'keterangan' => $validated['keterangan'],
            'dampak' => $validated['dampak'] ?? 'Dalam pendataan tim posko.',
            'status' => 'tercatat',
        ]);

        return redirect()->route('operator.kejadian')->with('success', 'Laporan kejadian bencana berhasil dicatat di posko.');
    }

    public function kejadianUpdateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:tercatat,diverifikasi,ditangani,selesai',
        ]);

        $kejadian = KejadianBencana::findOrFail($id);
        $kejadian->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', "Status kejadian berhasil diubah menjadi: {$validated['status']}.");
    }

    public function mukaLautIndex()
    {
        $mukaLautList = DataMukaLaut::with('sumberData')->latest('tanggal_waktu')->paginate(15);
        $sumberList = SumberData::all();

        return view('operator.muka-laut', compact('mukaLautList', 'sumberList'));
    }

    public function mukaLautStore(Request $request)
    {
        $validated = $request->validate([
            'stasiun' => 'required|string|max:100',
            'tinggi_muka_laut' => 'required|numeric',
            'satuan' => 'required|string|max:10',
            'status' => 'required|in:normal,siaga,waspada,awas',
        ]);

        $sumberBig = SumberData::where('nama_sumber', 'LIKE', '%BIG%')->first();

        DataMukaLaut::create([
            'id_sumber' => $sumberBig?->id_sumber ?? 2,
            'stasiun' => $validated['stasiun'],
            'tanggal_waktu' => now(),
            'tinggi_muka_laut' => $validated['tinggi_muka_laut'],
            'satuan' => $validated['satuan'],
            'jenis_data' => 'observasi_posko',
            'sumber' => 'Operator Posko SIGAP-PALU',
            'status' => $validated['status'],
        ]);

        return redirect()->route('operator.muka-laut')->with('success', 'Data pemantauan pasang surut muka laut berhasil disimpan!');
    }
}
