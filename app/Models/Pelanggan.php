<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Pelanggan — merepresentasikan pelanggan pengirim di SiLacak.
 *
 * @property int         $id
 * @property string      $nama
 * @property string      $email
 * @property string      $telepon
 * @property string      $alamat
 * @property bool        $is_member   True jika pelanggan terdaftar sebagai member (diskon 10%).
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Resi> $resi
 */
class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'email', 'telepon', 'alamat', 'is_member'];
    protected $casts = ['is_member' => 'boolean'];

    /**
     * Semua resi yang dikirim oleh pelanggan ini.
     *
     * @return HasMany<Resi>
     */
    public function resi(): HasMany
    {
        return $this->hasMany(Resi::class);
    }

    /**
     * Scope filter hanya pelanggan member.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMember($query)
    {
        return $query->where('is_member', true);
    }

    /**
     * Scope pencarian pelanggan berdasarkan nama, email, atau telepon.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null                           $q    Kata kunci pencarian.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCari($query, ?string $q)
    {
        return $query->when($q, fn($query) =>
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('telepon', 'like', "%{$q}%")
        );
    }
}