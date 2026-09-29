<?php

namespace App\Services;

use App\Models\Resi;
use Barryvdh\DomPDF\Facade\Pdf;

class LabelService
{
    public function cetakLabel(Resi $resi)
    {
        $resi->load(['pelanggan', 'cabangAsal', 'cabangTujuan', 'layanan']);
        $pdf = Pdf::loadView('label.resi', compact('resi'))
            ->setPaper([0, 0, 283.46, 425.20], 'portrait');
        return $pdf->download("label-{$resi->nomor_resi}.pdf");
    }
}