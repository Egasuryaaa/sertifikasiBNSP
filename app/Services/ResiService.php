<?php

namespace App\Services;

use App\Models\Resi;
use App\Models\Layanan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;

/**
 * ResiService — lapisan bisnis untuk pembuatan dan pengelolaan resi pengiriman.
 *
 * Service ini mengorkestrasi kalkulasi ongkir, pembuatan nomor resi,
 * pencatatan log tracking awal, dan structured logging ke Laravel Log.
 */
class ResiService
{
    /**
     * Buat instance baru ResiService dengan injeksi OngkirService.
     *
     * @param OngkirService $ongkirService Service penghitung ongkos kirim.
     */
    public function __construct(private OngkirService $ongkirService)
    {
    }

    /**
     * Proses pembuatan resi baru secara lengkap.
     *
     * Alur kerja:
     * 1. Hitung berat tagih (aktual vs volumetrik)
     * 2. Hitung biaya dasar, diskon member, dan asuransi
     * 3. Simpan data resi ke database
     * 4. Buat entri tracking log awal (status: pending)
     * 5. Tulis structured log ke Laravel Log
     *
     * @param  array<string, mixed> $data    Data tervalidasi dari SimpanResiRequest.
     * @param  int                  $userId  ID user (admin/kurir) yang membuat resi.
     * @return Resi                          Instance Resi yang baru saja dibuat.
     */
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