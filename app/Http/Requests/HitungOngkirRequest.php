<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HitungOngkirRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'layanan_id' => 'required|exists:layanan,id',
            'berat_aktual' => 'required|numeric|min:0.1',
            'panjang' => 'nullable|numeric|min:0',
            'lebar' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'nilai_barang' => 'required|numeric|min:0',
            'is_member' => 'boolean',
        ];
    }
}