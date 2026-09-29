<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use Illuminate\Http\Request;

/**
 * TrackingController — menangani fitur lacak resi publik (tanpa autentikasi).
 */
class TrackingController extends Controller
{
    /** @return \Illuminate\View\View Halaman utama form pencarian resi. */
    public function index()
    {
        return view('tracking.index');
    }

    /**
     * Cari resi berdasarkan nomor resi dan tampilkan hasilnya.
     *
     * Menggunakan eager loading untuk memuat relasi yang dibutuhkan tampilan hasil tracking,
     * termasuk log tracking yang diurutkan dari terbaru.
     *
     * @param  Request               $request Parameter query: nomor_resi (required).
     * @return \Illuminate\View\View          View tracking.hasil, atau kembali dengan error jika tidak ditemukan.
     */
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