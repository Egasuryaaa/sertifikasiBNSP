<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanan')->insert([
            ['kode' => 'REG', 'nama' => 'Reguler', 'tarif_per_kg' => 9000, 'min_kg' => 1, 'asuransi_persen' => 0.2, 'asuransi_min_nilai' => 1000000, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'EXP', 'nama' => 'Express', 'tarif_per_kg' => 15000, 'min_kg' => 1, 'asuransi_persen' => 0.2, 'asuransi_min_nilai' => 1000000, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'KAR', 'nama' => 'Kargo', 'tarif_per_kg' => 6000, 'min_kg' => 10, 'asuransi_persen' => 0.2, 'asuransi_min_nilai' => 1000000, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SMD', 'nama' => 'Same Day', 'tarif_per_kg' => 25000, 'min_kg' => 1, 'asuransi_persen' => 0.2, 'asuransi_min_nilai' => 1000000, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}