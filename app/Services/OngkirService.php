<?php

namespace App\Services;

use App\Models\Layanan;

class OngkirService
{
    public function hitungBeratTagih(float $beratAktual, ?float $p = null, ?float $l = null, ?float $t = null): float
    {
        $beratVolumetrik = 0;
        if ($p && $l && $t) {
            $beratVolumetrik = ($p * $l * $t) / 6000;
        }
        $beratMaks = max($beratAktual, $beratVolumetrik);
        return (float) ceil($beratMaks);
    }

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