<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Services\OngkirService;
use Illuminate\Http\Request;

/**
 * TarifController — fitur kalkulator ongkir publik.
 *
 * Menyediakan form dan hasil perhitungan ongkos kirim
 * tanpa perlu login, untuk keperluan estimasi biaya pengguna.
 */
class TarifController extends Controller
{
    /**
     * Injeksi OngkirService melalui constructor.
     *
     * @param OngkirService $ongkirService Service penghitung ongkos kirim.
     */
    public function __construct(private OngkirService $ongkirService) {}

    /**
     * Tampilkan halaman kalkulator tarif beserta daftar layanan aktif.
     *
     * @return \Illuminate\View\View View tarif.index dengan data layanan.
     */
    public function index()
    {
        $layanan = Layanan::aktif()->orderBy('tarif_per_kg')->get();
        return view('tarif.index', compact('layanan'));
    }

    /**
     * Proses kalkulasi tarif dan tampilkan hasil estimasi ongkir.
     *
     * @param  Request               $request Data form: layanan_id, berat_aktual, dimensi, nilai_barang, is_member.
     * @return \Illuminate\View\View          View tarif.hasil dengan rincian biaya.
     */
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