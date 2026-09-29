<?php

namespace App\Services;

use App\Models\Resi;
use App\Models\Layanan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;

class ResiService
{
    public function __construct(private OngkirService $ongkirService)
    {
    }

    public function buatResi(array $data, int $userId): Resi
    {
        $layanan = Layanan::findOrFail($data['layanan_id']);
        $pelanggan = Pelanggan::findOrFail($data['pelanggan_id']);

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
            $pelanggan->is_member
        );

        $resi = Resi::create(array_merge($data, $hasil, [
            'nomor_resi' => Resi::buatNomorResi(),
            'user_id' => $userId,
            'berat_tagih' => $beratTagih,
        ]));

        $resi->trackingLog()->create([
            'user_id' => $userId,
            'status' => 'pending',
            'lokasi' => $resi->cabangAsal->kota,
            'keterangan' => 'Resi dibuat',
        ]);

        // 📝 LOG TERSTRUKTUR
        Log::info('resi.dibuat', [
            'nomor_resi' => $resi->nomor_resi,
            'pelanggan_id' => $pelanggan->id,
            'pelanggan_nama' => $pelanggan->nama,
            'layanan' => $layanan->nama,
            'berat_aktual' => $data['berat_aktual'],
            'berat_tagih' => $beratTagih,
            'biaya_dasar' => $hasil['biaya_dasar'],
            'diskon' => $hasil['diskon'],
            'asuransi' => $hasil['asuransi'],
            'total_biaya' => $hasil['total_biaya'],
            'user_id' => $userId,
            'user_email' => auth()->user()?->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'waktu' => now()->toIso8601String(),
        ]);

        return $resi;
    }
}