<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Services\OngkirService;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function __construct(private OngkirService $ongkirService) {}

    public function index()
    {
        $layanan = Layanan::aktif()->orderBy('tarif_per_kg')->get();
        return view('tarif.index', compact('layanan'));
    }

    public function hitung(Request $request)
    {
        $data = $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'berat_aktual' => 'required|numeric|min:0.1',
            'panjang' => 'nullable|numeric|min:0',
            'lebar' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'nilai_barang' => 'required|numeric|min:0',
            'is_member' => 'boolean',
        ]);

        $layanan = Layanan::findOrFail($data['layanan_id']);
        $beratTagih = $this->ongkirService->hitungBeratTagih(
            $data['berat_aktual'],
            $data['panjang'] ?? null,
            $data['lebar'] ?? null,
            $data['tinggi'] ?? null
        );

        $hasil = $this->ongkirService->hitung(
            $layanan,
            $beratTagih,
            $data['nilai_barang'],
            $request->boolean('is_member')
        );

        return view('tarif.hasil', compact('layanan', 'beratTagih', 'hasil', 'data'));
    }
}