<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckRole;

// 1. Landing Page Publik
Route::get('/', [DashboardController::class, 'landing'])->name('landing');

// 2. Autentikasi Publik
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Area Sistem Terproteksi (Admin, Operator, User)
Route::middleware(['auth'])->group(function () {
    // Rute yang dapat diakses oleh SEMUA ROLE (User, Operator, Admin)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/portal', [DashboardController::class, 'index'])->name('portal'); // Kompatibilitas redirect lama
    Route::get('/peta-risiko', [DashboardController::class, 'petaRisiko'])->name('peta.risiko');
    Route::get('/monitoring-gempa', [DashboardController::class, 'gempa'])->name('monitoring.gempa');
    Route::get('/monitoring-laut', [DashboardController::class, 'mukaLaut'])->name('monitoring.laut');
    Route::get('/kesiapsiagaan', [DashboardController::class, 'kesiapsiagaan'])->name('kesiapsiagaan');
    Route::get('/analisis', [DashboardController::class, 'analisis'])->name('analisis');
    Route::get('/peringatan', [DashboardController::class, 'peringatan'])->name('peringatan');
    Route::get('/kejadian-bencana', [DashboardController::class, 'kejadian'])->name('kejadian');
    Route::get('/monitoring-risiko', [DashboardController::class, 'monitoringRisiko'])->name('monitoring.index');
    Route::get('/monitoring-risiko/{id}', [DashboardController::class, 'detailMonitoring'])->name('monitoring.show');

    // Khusus OPERATOR & ADMIN
    Route::middleware([CheckRole::class . ':operator,admin'])->group(function () {
        Route::get('/indikator', [DashboardController::class, 'indikator'])->name('indikator.index');
    });

    // Khusus ADMIN
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::get('/manajemen-pengguna', [DashboardController::class, 'pengguna'])->name('admin.pengguna');
        Route::get('/log-data', [DashboardController::class, 'logData'])->name('admin.log');
    });
});