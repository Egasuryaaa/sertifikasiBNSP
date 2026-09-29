<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanResiRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'cabang_asal_id' => 'required|exists:cabang,id',
            'cabang_tujuan_id' => 'required|exists:cabang,id|different:cabang_asal_id',
            'layanan_id' => 'required|exists:layanan,id',
            'nama_penerima' => 'required|string|max:100',
            'telepon_penerima' => 'required|string|max:20',
            'alamat_penerima' => 'required|string|max:500',
            'berat_aktual' => 'required|numeric|min:0.1|max:1000',
            'panjang' => 'nullable|numeric|min:0',
            'lebar' => 'nullable|numeric|min:0',
            'tinggi' => 'nullable|numeric|min:0',
            'nilai_barang' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'cabang_tujuan_id.different' => 'Cabang tujuan harus berbeda dari cabang asal.',
            'berat_aktual.min' => 'Berat minimal 0,1 kg.',
        ];
    }
}