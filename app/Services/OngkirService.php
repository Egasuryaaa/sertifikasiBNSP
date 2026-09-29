<?php

namespace App\Services;

use App\Models\Layanan;

/**
 * OngkirService — kalkulasi berat tagih dan biaya ongkos kirim.
 *
 * Mengimplementasikan logika:
 * - Berat volumetrik: (P × L × T) / 6000
 * - Berat tagih: max(berat aktual, berat volumetrik), dibulatkan ke atas
 * - Diskon 10% untuk pelanggan member
 * - Asuransi 0.2% jika nilai barang melebihi batas minimum layanan
 */
class OngkirService
{
    /**
     * Hitung berat tagih berdasarkan berat aktual dan dimensi volumetrik.
     *
     * Formula volumetrik: (P × L × T) / 6000.
     * Berat tagih = ceiling(max(berat_aktual, berat_volumetrik)).
     *
     * @param  float      $beratAktual Berat fisik paket dalam kilogram.
     * @param  float|null $p           Panjang paket dalam sentimeter (opsional).
     * @param  float|null $l           Lebar paket dalam sentimeter (opsional).
     * @param  float|null $t           Tinggi paket dalam sentimeter (opsional).
     * @return float                   Berat tagih yang sudah dibulatkan ke atas (kg).
     */
    public function hitungBeratTagih(float $beratAktual, ?float $p = null, ?float $l = null, ?float $t = null): float
    {
        $beratVolumetrik = 0;
        if ($p && $l && $t) {
            $beratVolumetrik = ($p * $l * $t) / 6000;
        }
        $beratMaks = max($beratAktual, $beratVolumetrik);
        return (float) ceil($beratMaks);
    }

    /**
     * Hitung rincian biaya pengiriman berdasarkan layanan dan berat tagih.
     *
     * @param  Layanan $layanan      Objek layanan pengiriman yang dipilih.
     * @param  float   $beratTagih  Berat tagih hasil dari hitungBeratTagih().
     * @param  float   $nilaiBarang Nilai deklarasi isi paket dalam Rupiah.
     * @param  bool    $isMember    True jika pelanggan adalah member (diskon 10%).
     * @return array{berat_tagih_final: float, biaya_dasar: float, diskon: float, asuransi: float, total_biaya: float}
     */
    public function hitung(Layanan $layanan, float $beratTagih, float $nilaiBarang, bool $isMember): array
    {
        $beratFinal = max($beratTagih, (float) $layanan->min_kg);
        $biayaDasar = $beratFinal * (float) $layanan->tarif_per_kg;
        $diskon = $isMember ? $biayaDasar * 0.10 : 0;

        $asuransi = 0;
        if ($nilaiBarang > (float) $layanan->asuransi_min_nilai) {
            $asuransi = $nilaiBarang * ((float) $layanan->asuransi_persen / 100);
        }

        $total = $biayaDasar - $diskon + $asuransi;

        return [
            'berat_tagih_final' => $beratFinal,
            'biaya_dasar' => round($biayaDasar, 2),
            'diskon' => round($diskon, 2),
            'asuransi' => round($asuransi, 2),
            'total_biaya' => round($total, 2),
        ];
    }
}