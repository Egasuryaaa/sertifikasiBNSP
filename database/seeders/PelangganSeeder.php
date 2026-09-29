<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Pelanggan::create([
                'nama' => 'Pelanggan ' . $i,
                'email' => 'pelanggan' . $i . '@silacak.test',
                'telepon' => '08' . str_pad($i, 10, '0', STR_PAD_LEFT),
                'alamat' => 'Jl. Contoh No. ' . $i,
                'is_member' => ($i % 3 == 0),
            ]);
        }
    }
}