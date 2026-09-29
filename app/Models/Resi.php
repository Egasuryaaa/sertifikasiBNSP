<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Resi extends Model
{
    use HasFactory;

    protected $table = 'resi';
    protected $fillable = [
        'nomor_resi', 'pelanggan_id', 'cabang_asal_id', 'cabang_tujuan_id',
        'layanan_id', 'user_id', 'nama_penerima', 'telepon_penerima', 'alamat_penerima',
        'berat_aktual', 'panjang', 'lebar', 'tinggi', 'berat_tagih', 'nilai_barang',
        'biaya_dasar', 'diskon', 'asuransi', 'total_biaya', 'status', 'catatan'
    ];
    protected $casts = [
        'berat_aktual' => 'decimal:2',
        'berat_tagih' => 'decimal:2',
        'total_biaya' => 'decimal:2',
    ];

    public function pelanggan(): BelongsTo { return $this->belongsTo(Pelanggan::class); }
    public function cabangAsal(): BelongsTo { return $this->belongsTo(Cabang::class, 'cabang_asal_id'); }
    public function cabangTujuan(): BelongsTo { return $this->belongsTo(Cabang::class, 'cabang_tujuan_id'); }
    public function layanan(): BelongsTo { return $this->belongsTo(Layanan::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function trackingLog(): HasMany { return $this->hasMany(TrackingLog::class); }

    public static function buatNomorResi(): string
    {
        $prefix = 'SLC-' . now()->format('Ymd') . '-';
        $last = static::where('nomor_resi', 'like', $prefix . '%')
            ->orderByDesc('nomor_resi')
            ->first();
        $seq = $last ? ((int) Str::afterLast($last->nomor_resi, '-')) + 1 : 1;
        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    public function scopeCari($query, ?string $q)
    {
        return $query->when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nomor_resi', 'like', "%{$q}%")
                    ->orWhere('nama_penerima', 'like', "%{$q}%")
                    ->orWhere('telepon_penerima', 'like', "%{$q}%");
            });
        });
    }

    public function scopeStatus($query, ?string $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }
}