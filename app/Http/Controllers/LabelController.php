<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Services\LabelService;

/**
 * LabelController — menangani pencetakan label resi dalam format PDF.
 */
class LabelController extends Controller
{
    /**
     * Injeksi LabelService melalui constructor.
     *
     * @param LabelService $labelService Service untuk generate label PDF.
     */
    public function __construct(private LabelService $labelService) {}

    /**
     * Generate dan unduh label resi dalam format PDF.
     *
     * @param  Resi                                           $resi  Instance resi dari Route Model Binding.
     * @return \Symfony\Component\HttpFoundation\Response            File PDF siap unduh.
     */
    public function cetak(Resi $resi)
    {
        return $this->labelService->cetakLabel($resi);
    }
}