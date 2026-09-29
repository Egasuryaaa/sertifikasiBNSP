<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'email', 'telepon', 'alamat', 'is_member'];
    protected $casts = ['is_member' => 'boolean'];

    public function resi(): HasMany
    {
        return $this->hasMany(Resi::class);
    }

    public function scopeMember($query)
    {
        return $query->where('is_member', true);
    }

    public function scopeCari($query, ?string $q)
    {
        return $query->when($q, fn($query) =>
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('telepon', 'like', "%{$q}%")
        );
    }
}