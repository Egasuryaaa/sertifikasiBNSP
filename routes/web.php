<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIK ====================
Route::get('/', [TrackingController::class, 'index'])->name('home');
Route::get('/lacak', [TrackingController::class, 'cari'])->name('tracking.cari');
Route::get('/tarif', [TarifController::class, 'index'])->name('tarif.index');
Route::post('/tarif/hitung', [TarifController::class, 'hitung'])->name('tarif.hitung');

// ==================== AUTH ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==================== TERAUTENTIKASI ====================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('resi', ResiController::class);
    Route::get('/resi/{resi}/label', [LabelController::class, 'cetak'])->name('resi.label');
});

Route::get('/debug-nplus1-fixed', function () {
    // DENGAN eager loading — hanya 2 query
    $resi = App\Models\Resi::with('pelanggan')->limit(10)->get();

    foreach ($resi as $r) {
        echo $r->pelanggan->nama . '
';
    }

    return 'Lihat Debugbar — hanya 2 query!';
});

Route::get('/debug-nplus1', function () {
    // TANPA eager loading — akan jadi N+1
    $resi = App\Models\Resi::limit(10)->get();

    foreach ($resi as $r) {
        echo $r->pelanggan->nama . '
';  // Setiap iterasi query ke DB
    }

    // Cek jumlah query di Debugbar
    return 'Lihat Debugbar di bawah — perhatikan jumlah query';
});

Route::get('/test-sentry', function () {
    throw new \Exception('Test error ke Sentry dari SiLacak');
});

Route::get('/monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])
    ->name('monitoring');