<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Layanan — merepresentasikan jenis layanan pengiriman yang tersedia.
 *
 * @property int    $id
 * @property string $kode              Kode singkat layanan (REG, EXP, KAR, SMD).
 * @property string $nama              Nama tampilan layanan.
 * @property float  $tarif_per_kg      Harga per kilogram dalam Rupiah.
 * @property float  $min_kg            Berat minimum yang dikenakan tarif.
 * @property float  $asuransi_persen   Persentase asuransi dari nilai barang.
 * @property float  $asuransi_min_nilai Nilai barang minimum yang dikenakan asuransi.
 * @property bool   $aktif             Status keaktifan layanan.
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Resi> $resi
 */
class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $fillable = [
        'kode', 'nama', 'tarif_per_kg', 'min_kg',
        'asuransi_persen', 'asuransi_min_nilai', 'aktif'
    ];
    protected $casts = [
        'aktif' => 'boolean',
        'tarif_per_kg' => 'decimal:2',
    ];

    /**
     * Semua resi yang menggunakan layanan ini.
     *
     * @return HasMany<Resi>
     */
    public function resi(): HasMany
    {
        return $this->hasMany(Resi::class);
    }

    /**
     * Scope filter hanya layanan yang sedang aktif.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}