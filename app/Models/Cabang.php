<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';
    protected $fillable = ['kode', 'nama', 'kota', 'alamat'];

    public function resiAsal(): HasMany
    {
        return $this->hasMany(Resi::class, 'cabang_asal_id');
    }

    public function resiTujuan(): HasMany
    {
        return $this->hasMany(Resi::class, 'cabang_tujuan_id');
    }

    public function scopeCari($query, ?string $q)
    {
        return $query->when($q, fn($query) =>
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('kota', 'like', "%{$q}%")
                  ->orWhere('kode', 'like', "%{$q}%")
        );
    }
}