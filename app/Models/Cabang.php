<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Cabang — merepresentasikan kantor cabang SiLacak Express.
 *
 * @property int    $id
 * @property string $kode   Kode unik cabang (misal: JKT, BDG, SBY).
 * @property string $nama   Nama lengkap cabang.
 * @property string $kota   Nama kota lokasi cabang.
 * @property string $alamat Alamat fisik kantor cabang.
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Resi> $resiAsal
 * @property-read \Illuminate\Database\Eloquent\Collection<Resi> $resiTujuan
 */
class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';
    protected $fillable = ['kode', 'nama', 'kota', 'alamat'];

    /**
     * Semua resi yang berasal (dikirim) dari cabang ini.
     *
     * @return HasMany<Resi>
     */
    public function resiAsal(): HasMany
    {
        return $this->hasMany(Resi::class, 'cabang_asal_id');
    }

    /**
     * Semua resi yang ditujukan ke cabang ini.
     *
     * @return HasMany<Resi>
     */
    public function resiTujuan(): HasMany
    {
        return $this->hasMany(Resi::class, 'cabang_tujuan_id');
    }

    /**
     * Scope pencarian cabang berdasarkan nama, kota, atau kode.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null                           $q    Kata kunci pencarian.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCari($query, ?string $q)
    {
        return $query->when($q, fn($query) =>
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('kota', 'like', "%{$q}%")
                  ->orWhere('kode', 'like', "%{$q}%")
        );
    }
}