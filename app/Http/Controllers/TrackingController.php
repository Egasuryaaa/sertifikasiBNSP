<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function cari(Request $request)
    {
        $request->validate(['nomor_resi' => 'required|string|max:30']);

        $resi = Resi::with(['pelanggan', 'cabangAsal', 'cabangTujuan', 'layanan',
                'trackingLog' => fn($q) => $q->orderByDesc('created_at')])
            ->where('nomor_resi', $request->nomor_resi)
            ->first();

        if (!$resi) {
            return back()->withErrors(['nomor_resi' => 'Nomor resi tidak ditemukan.'])->withInput();
        }

        return view('tracking.hasil', compact('resi'));
    }
}