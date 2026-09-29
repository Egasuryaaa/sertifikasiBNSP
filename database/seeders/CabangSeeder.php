<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cabang')->insert([
            ['kode' => 'JKT', 'nama' => 'Cabang Jakarta', 'kota' => 'Jakarta', 'alamat' => 'Jl. Sudirman No. 1', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'BDG', 'nama' => 'Cabang Bandung', 'kota' => 'Bandung', 'alamat' => 'Jl. Asia Afrika No. 2', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SBY', 'nama' => 'Cabang Surabaya', 'kota' => 'Surabaya', 'alamat' => 'Jl. Tunjungan No. 3', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'MDN', 'nama' => 'Cabang Medan', 'kota' => 'Medan', 'alamat' => 'Jl. Gatot Subroto No. 4', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'MKS', 'nama' => 'Cabang Makassar', 'kota' => 'Makassar', 'alamat' => 'Jl. Pettarani No. 5', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}