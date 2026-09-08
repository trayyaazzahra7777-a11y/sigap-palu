<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| A. PUBLIC ROUTES (Dapat diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'landing'])->name('landing');
Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('public.monitoring');
Route::get('/peta-risiko', [DashboardController::class, 'petaRisiko'])->name('public.peta');
Route::get('/sejarah', [DashboardController::class, 'sejarah'])->name('public.sejarah');
Route::get('/edukasi', [DashboardController::class, 'edukasi'])->name('public.edukasi');
Route::get('/edukasi/{topic}', [DashboardController::class, 'edukasi'])->name('public.edukasi.detail');
Route::get('/mitigasi', [DashboardController::class, 'mitigasi'])->name('public.mitigasi');
Route::get('/tentang', [DashboardController::class, 'tentang'])->name('public.tentang');
Route::get('/unduh-rekap', [DashboardController::class, 'unduhRekap'])->name('unduh.rekap');

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/geojson/{layer}', [GisController::class, 'getGeoJson'])->name('geojson');
    Route::get('/spatial-markers', [GisController::class, 'getSpatialMarkers'])->name('spatial-markers');
    Route::get('/region-profile/{id}', [GisController::class, 'getRegionProfile'])->name('region-profile');
});

/*
|--------------------------------------------------------------------------
| B. AUTHENTICATION ROUTES (Sistem Login & Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| C. PROTECTED ROUTES (Wajib Login & Berlaku Middleware Anti-Back)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'no-back'])->group(function () {

    // 1. ROUTE USER (Masyarakat & Peneliti)
    Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::get('/simulasi', [UserController::class, 'simulasiForm'])->name('simulasi');
        Route::post('/simulasi', [UserController::class, 'runSimulasi'])->name('simulasi.run');
        Route::get('/unduh-kajian', [UserController::class, 'unduhKajian'])->name('unduh-kajian');
        Route::delete('/simulasi/riwayat/{id}', [UserController::class, 'destroyRiwayat'])->name('simulasi.hapus');
    });

    // 2. ROUTE OPERATOR (Petugas Posko)
    Route::middleware(['role:operator'])->prefix('operator')->name('operator.')->group(function () {
        Route::get('/dashboard', [OperatorController::class, 'index'])->name('dashboard');
        Route::get('/peringatan', [OperatorController::class, 'peringatanIndex'])->name('peringatan');
        Route::post('/peringatan', [OperatorController::class, 'peringatanStore'])->name('peringatan.store');
        Route::post('/peringatan/{id}/selesai', [OperatorController::class, 'peringatanSelesai'])->name('peringatan.selesai');
        Route::get('/kejadian', [OperatorController::class, 'kejadianIndex'])->name('kejadian');
        Route::post('/kejadian', [OperatorController::class, 'kejadianStore'])->name('kejadian.store');
        Route::post('/kejadian/{id}/status', [OperatorController::class, 'kejadianUpdateStatus'])->name('kejadian.status');
        Route::get('/muka-laut', [OperatorController::class, 'mukaLautIndex'])->name('muka-laut');
        Route::post('/muka-laut', [OperatorController::class, 'mukaLautStore'])->name('muka-laut.store');
    });

   // 3. ROUTE ADMIN (Administrator Sistem)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
        Route::post('/users/{id}/role', [AdminController::class, 'usersUpdateRole'])->name('users.role');
        Route::get('/indikator', [AdminController::class, 'indikatorIndex'])->name('indikator');
        Route::post('/indikator/{id}', [AdminController::class, 'indikatorUpdate'])->name('indikator.update');
        Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs');
        Route::get('/logs/export', [AdminController::class, 'exportLogs'])->name('logs.export'); // Tambahan Ekspor CSV
        Route::delete('/logs/clear', [AdminController::class, 'clearLogs'])->name('logs.clear'); // Tambahan Bersihkan Log
        Route::post('/sync-bmkg', [AdminController::class, 'syncBmkgManual'])->name('sync-bmkg');
    });
    
    Route::get('/logout-paksa', function () {
        Auth::logout();
        return redirect('/login');
    });

});