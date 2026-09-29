<?php

namespace App\Services;

use App\Models\Resi;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * LabelService — generate label pengiriman resi dalam format PDF.
 *
 * Menggunakan DomPDF dengan ukuran kertas custom A6 (10×15 cm).
 */
class LabelService
{
    /**
     * Generate dan kembalikan response download PDF label resi.
     *
     * Memuat relasi pelanggan, cabangAsal, cabangTujuan, dan layanan
     * sebelum merender view label.resi ke dalam PDF ukuran A6.
     *
     * @param  Resi                                      $resi  Data resi yang akan dicetak labelnya.
     * @return \Symfony\Component\HttpFoundation\Response        Response download PDF dengan nama file label-{nomor_resi}.pdf.
     */
    public function cetakLabel(Resi $resi)
    {
        $resi->load(['pelanggan', 'cabangAsal', 'cabangTujuan', 'layanan']);
        $pdf = Pdf::loadView('label.resi', compact('resi'))
            ->setPaper([0, 0, 283.46, 425.20], 'portrait');
        return $pdf->download("label-{$resi->nomor_resi}.pdf");
    }
}