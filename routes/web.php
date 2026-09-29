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

// ==================== DEBUG EAGER LOADING ====================

// ❌ TANPA eager loading → N+1 Problem (1 + 10 + 10 + 10 + 10 = 41 queries)
Route::get('/debug-nplus1', function () {
    $resi = App\Models\Resi::limit(10)->get();

    $output = "<h2 style='font-family:monospace'>❌ TANPA Eager Loading — N+1 Problem</h2>";
    $output .= "<p style='font-family:monospace;color:red'>Cek tab <b>Queries</b> di Debugbar — akan ada banyak query!</p><hr>";
    $output .= "<table border='1' cellpadding='6' style='font-family:monospace;font-size:13px;border-collapse:collapse'>";
    $output .= "<tr style='background:#fee'><th>#</th><th>Nomor Resi</th><th>Pelanggan</th><th>Cabang Asal</th><th>Cabang Tujuan</th><th>Layanan</th><th>Status</th></tr>";

    foreach ($resi as $i => $r) {
        // Setiap akses relasi = 1 query baru (N+1!)
        $output .= "<tr>";
        $output .= "<td>" . ($i + 1) . "</td>";
        $output .= "<td>{$r->nomor_resi}</td>";
        $output .= "<td>{$r->pelanggan->nama}</td>";       // query ke-2..11
        $output .= "<td>{$r->cabangAsal->kota}</td>";      // query ke-12..21
        $output .= "<td>{$r->cabangTujuan->kota}</td>";    // query ke-22..31
        $output .= "<td>{$r->layanan->nama}</td>";         // query ke-32..41
        $output .= "<td>{$r->status}</td>";
        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "<p style='font-family:monospace;color:red;margin-top:10px'>⚠️ Total query: <b>1 + (10×4) = 41 queries!</b></p>";
    return $output;
});

// ✅ DENGAN eager loading → hanya 5 query (1 resi + 4 relasi)
Route::get('/debug-nplus1-fixed', function () {
    $resi = App\Models\Resi::with([
        'pelanggan',
        'cabangAsal',
        'cabangTujuan',
        'layanan',
    ])->limit(10)->get();

    $output = "<h2 style='font-family:monospace'>✅ DENGAN Eager Loading — Efisien!</h2>";
    $output .= "<p style='font-family:monospace;color:green'>Cek tab <b>Queries</b> di Debugbar — hanya <b>5 query</b>!</p><hr>";
    $output .= "<table border='1' cellpadding='6' style='font-family:monospace;font-size:13px;border-collapse:collapse'>";
    $output .= "<tr style='background:#efe'><th>#</th><th>Nomor Resi</th><th>Pelanggan</th><th>Cabang Asal</th><th>Cabang Tujuan</th><th>Layanan</th><th>Berat Tagih</th><th>Total Biaya</th><th>Status</th></tr>";

    foreach ($resi as $i => $r) {
        // Semua relasi sudah di-load sekaligus, 0 query tambahan!
        $output .= "<tr>";
        $output .= "<td>" . ($i + 1) . "</td>";
        $output .= "<td>{$r->nomor_resi}</td>";
        $output .= "<td>{$r->pelanggan->nama}</td>";
        $output .= "<td>{$r->cabangAsal->kota}</td>";
        $output .= "<td>{$r->cabangTujuan->kota}</td>";
        $output .= "<td>{$r->layanan->nama}</td>";
        $output .= "<td>{$r->berat_tagih} kg</td>";
        $output .= "<td>Rp " . number_format($r->total_biaya, 0, ',', '.') . "</td>";
        $output .= "<td>{$r->status}</td>";
        $output .= "</tr>";
    }

    $output .= "</table>";
    $output .= "<p style='font-family:monospace;color:green;margin-top:10px'>✅ Total query: <b>5 saja</b> (1 resi + 1 pelanggan + 1 cabang_asal + 1 cabang_tujuan + 1 layanan)</p>";
    $output .= "<p style='font-family:monospace'>👉 Bandingkan dengan <a href='/debug-nplus1'>/debug-nplus1</a> yang N+1!</p>";
    return $output;
});

Route::get('/test-sentry', function () {
    throw new \Exception('Test error ke Sentry dari SiLacak');
});

Route::get('/monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])
    ->name('monitoring');