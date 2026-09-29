<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\Pelanggan;
use App\Models\Cabang;
use App\Models\Layanan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_resi' => Resi::count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_cabang' => Cabang::count(),
            'total_pendapatan' => Resi::sum('total_biaya') ?? 0,
            'resi_hari_ini' => Resi::whereDate('created_at', today())->count(),
            'resi_transit' => Resi::where('status', 'transit')->count(),
        ];

        $perLayanan = Layanan::withCount('resi')->orderByDesc('resi_count')->get();
        $perStatus = Resi::selectRaw('status, COUNT(*) as jumlah')->groupBy('status')->get();
        $terbaru = Resi::with(['pelanggan', 'layanan'])->orderByDesc('created_at')->limit(5)->get();

        return view('dashboard', compact('stats', 'perLayanan', 'perStatus', 'terbaru'));
    }
}