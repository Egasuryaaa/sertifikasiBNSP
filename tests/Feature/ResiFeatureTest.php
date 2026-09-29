<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\Resi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResiFeatureTest extends TestCase
{
    use RefreshDatabase;  // ← Reset DB setiap test

    private function seedBasicData(): array
    {
        $user = User::factory()->create();
        $cabangAsal = Cabang::create(['kode' => 'JKT', 'nama' => 'Jakarta', 'kota' => 'Jakarta']);
        $cabangTujuan = Cabang::create(['kode' => 'BDG', 'nama' => 'Bandung', 'kota' => 'Bandung']);
        $pelanggan = Pelanggan::create([
            'nama' => 'PT Maju Jaya',
            'email' => 'maju@test.com',
            'telepon' => '081234567890',
            'is_member' => false,
        ]);
        $layanan = Layanan::create([
            'kode' => 'REG',
            'nama' => 'Reguler',
            'tarif_per_kg' => 9000,
            'min_kg' => 1,
            'asuransi_persen' => 0.2,
            'asuransi_min_nilai' => 1000000,
            'aktif' => true,
        ]);

        return compact('user', 'cabangAsal', 'cabangTujuan', 'pelanggan', 'layanan');
    }

    /** @test */
    public function user_bisa_membuat_resi_baru()
    {
        $data = $this->seedBasicData();

        $response = $this->actingAs($data['user'])->post('/resi', [
            'pelanggan_id' => $data['pelanggan']->id,
            'cabang_asal_id' => $data['cabangAsal']->id,
            'cabang_tujuan_id' => $data['cabangTujuan']->id,
            'layanan_id' => $data['layanan']->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon_penerima' => '089876543210',
            'alamat_penerima' => 'Jl. Merdeka No. 10, Bandung',
            'berat_aktual' => 1.3,
            'nilai_barang' => 0,
        ]);

        // Assert: redirect ke halaman show
        $response->assertRedirect();

        // Assert: data tersimpan di DB
        $this->assertDatabaseHas('resi', [
            'nama_penerima' => 'Budi Santoso',
            'berat_tagih' => 2,  // ← 1,3 kg dibulatkan ke atas
        ]);

        // Assert: nomor resi otomatis
        $resi = Resi::first();
        $this->assertStringStartsWith('SLC-', $resi->nomor_resi);
    }

    /** @test */
    public function resi_menolak_cabang_asal_dan_tujuan_yang_sama()
    {
        $data = $this->seedBasicData();

        $response = $this->actingAs($data['user'])->post('/resi', [
            'pelanggan_id' => $data['pelanggan']->id,
            'cabang_asal_id' => $data['cabangAsal']->id,
            'cabang_tujuan_id' => $data['cabangAsal']->id,  // ← sama!
            'layanan_id' => $data['layanan']->id,
            'nama_penerima' => 'Test',
            'telepon_penerima' => '08123',
            'alamat_penerima' => 'Test',
            'berat_aktual' => 2,
            'nilai_barang' => 0,
        ]);

        $response->assertSessionHasErrors('cabang_tujuan_id');
        $this->assertDatabaseCount('resi', 0);
    }

    /** @test */
    public function asuransi_dihitung_untuk_nilai_barang_diatas_1_juta()
    {
        $data = $this->seedBasicData();

        $this->actingAs($data['user'])->post('/resi', [
            'pelanggan_id' => $data['pelanggan']->id,
            'cabang_asal_id' => $data['cabangAsal']->id,
            'cabang_tujuan_id' => $data['cabangTujuan']->id,
            'layanan_id' => $data['layanan']->id,
            'nama_penerima' => 'Test',
            'telepon_penerima' => '08123',
            'alamat_penerima' => 'Test',
            'berat_aktual' => 2,
            'nilai_barang' => 2000000,  // ← 2 juta
        ]);

        $resi = Resi::first();
        $this->assertEquals(4000, $resi->asuransi);  // 0.2% × 2 juta
        $this->assertEquals(22000, $resi->total_biaya);  // (2 × 9000) + 4000
    }

    /** @test */
    public function tracking_log_dibuat_otomatis_saat_resi_baru()
    {
        $data = $this->seedBasicData();

        $this->actingAs($data['user'])->post('/resi', [
            'pelanggan_id' => $data['pelanggan']->id,
            'cabang_asal_id' => $data['cabangAsal']->id,
            'cabang_tujuan_id' => $data['cabangTujuan']->id,
            'layanan_id' => $data['layanan']->id,
            'nama_penerima' => 'Test',
            'telepon_penerima' => '08123',
            'alamat_penerima' => 'Test',
            'berat_aktual' => 2,
            'nilai_barang' => 0,
        ]);

        $this->assertDatabaseHas('tracking_log', [
            'status' => 'pending',
            'lokasi' => 'Jakarta',
        ]);
    }
}