<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\LogData;
use App\Models\SumberData;
use App\Models\User;
use App\Services\BmkgIntegrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index()
    {
        $userCounts = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'operator' => User::where('role', 'operator')->count(),
            'user' => User::where('role', 'user')->count(),
        ];

        $recentLogs = LogData::terbaru()->limit(8)->get();
        $sumberList = SumberData::all();
        $totalIndikator = Indikator::count();

        return view('admin.dashboard', compact('userCounts', 'recentLogs', 'sumberList', 'totalIndikator'));
    }

    public function usersIndex()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,operator,user',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users')->with('success', 'Akun pengguna baru berhasil didaftarkan!');
    }

    public function usersUpdateRole($id, Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,operator,user',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', "Hak akses peran pengguna {$user->name} berhasil diubah menjadi: {$validated['role']}.");
    }

    public function indikatorIndex()
    {
        $indikatorList = Indikator::all()->groupBy('kategori');

        return view('admin.indikator', compact('indikatorList'));
    }

    public function indikatorUpdate($id, Request $request)
    {
        $validated = $request->validate([
            'bobot' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $indikator = Indikator::findOrFail($id);
        $indikator->update([
            'bobot' => $validated['bobot'],
            'deskripsi' => $validated['deskripsi'] ?? $indikator->deskripsi,
        ]);

        return redirect()->back()->with('success', "Bobot indikator '{$indikator->nama_indikator}' berhasil diperbarui.");
    }

    public function logsIndex()
    {
        $logs = LogData::terbaru()->paginate(20);

        return view('admin.logs', compact('logs'));
    }

    public function syncBmkgManual(BmkgIntegrationService $bmkgService)
    {
        $result = $bmkgService->syncAllSources();
        // Menyesuaikan dengan array kembalian dari BmkgIntegrationService ('new')
        $totalNew = $result['new'] ?? $result['total_new_earthquakes'] ?? 0;

        return redirect()->back()->with('success', "Sinkronisasi BMKG berhasil dijalankan! ({$totalNew} kejadian gempa radius Palu diproses).");
    }

    public function clearLogs()
    {
        // Menghapus seluruh catatan log sistem atau memberikan batasan tanggal tertentu
        LogData::truncate(); // Membersihkan seluruh tabel log data

        return redirect()->back()->with('success', 'Riwayat audit trail dan log sistem berhasil dibersihkan.');
    }

    public function exportLogs(Request $request): StreamedResponse
    {
        $fileName = 'audit-trail-sigap-palu-' . date('Y-m-d') . '.csv';
        
        $logs = LogData::with('user')->orderBy('waktu_update', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Waktu Catat', 'Pengguna / Pemicu', 'Sumber Data', 'Jenis Data', 'Keterangan Aktivitas', 'Status Koneksi']);

            foreach ($logs as $index => $log) {
                fputcsv($file, [
                    $index + 1,
                    $log->waktu_update ? $log->waktu_update->format('Y-m-d H:i:s') : '-',
                    $log->user->name ?? 'System Bot (Automated)',
                    $log->sumber,
                    $log->jenis_data,
                    $log->keterangan,
                    ucfirst($log->status_koneksi)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}