<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function resi(): HasMany
    {
        return $this->hasMany(Resi::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}