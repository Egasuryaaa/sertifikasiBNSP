<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Services\LabelService;

class LabelController extends Controller
{
    public function __construct(private LabelService $labelService) {}

    public function cetak(Resi $resi)
    {
        return $this->labelService->cetakLabel($resi);
    }
}