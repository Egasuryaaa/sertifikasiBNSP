<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Model Resi — merepresentasikan satu data pengiriman (resi) di SiLacak.
 *
 * @property int         $id
 * @property string      $nomor_resi          Nomor resi unik, format: SLC-YYYYMMDD-XXXX
 * @property int         $pelanggan_id
 * @property int         $cabang_asal_id
 * @property int         $cabang_tujuan_id
 * @property int         $layanan_id
 * @property int         $user_id             Admin/kurir yang membuat resi
 * @property string      $nama_penerima
 * @property string      $telepon_penerima
 * @property string      $alamat_penerima
 * @property float       $berat_aktual        Berat fisik paket (kg)
 * @property float|null  $panjang             Dimensi panjang (cm), nullable
 * @property float|null  $lebar               Dimensi lebar (cm), nullable
 * @property float|null  $tinggi              Dimensi tinggi (cm), nullable
 * @property float       $berat_tagih         Berat yang digunakan untuk penghitungan tarif
 * @property float       $nilai_barang        Nilai deklarasi isi paket (Rp)
 * @property float       $biaya_dasar         Biaya pokok sebelum diskon/asuransi
 * @property float       $diskon              Potongan harga (member 10%)
 * @property float       $asuransi            Biaya asuransi jika nilai_barang melebihi batas
 * @property float       $total_biaya         Total akhir yang dibayarkan
 * @property string      $status              Enum: pending|pickup|transit|delivery|terkirim|gagal
 * @property string|null $catatan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read Pelanggan   $pelanggan
 * @property-read Cabang      $cabangAsal
 * @property-read Cabang      $cabangTujuan
 * @property-read Layanan     $layanan
 * @property-read User        $user
 * @property-read \Illuminate\Database\Eloquent\Collection<TrackingLog> $trackingLog
 */
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

    /** @return BelongsTo<Pelanggan, Resi> Pelanggan pengirim paket. */
    public function pelanggan(): BelongsTo { return $this->belongsTo(Pelanggan::class); }

    /** @return BelongsTo<Cabang, Resi> Cabang tempat paket dikirimkan. */
    public function cabangAsal(): BelongsTo { return $this->belongsTo(Cabang::class, 'cabang_asal_id'); }

    /** @return BelongsTo<Cabang, Resi> Cabang tujuan pengiriman paket. */
    public function cabangTujuan(): BelongsTo { return $this->belongsTo(Cabang::class, 'cabang_tujuan_id'); }

    /** @return BelongsTo<Layanan, Resi> Layanan pengiriman yang dipilih. */
    public function layanan(): BelongsTo { return $this->belongsTo(Layanan::class); }

    /** @return BelongsTo<User, Resi> Admin/kurir yang membuat resi ini. */
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    /** @return HasMany<TrackingLog> Seluruh riwayat status pengiriman resi ini. */
    public function trackingLog(): HasMany { return $this->hasMany(TrackingLog::class); }

    /**
     * Generate nomor resi unik dengan format SLC-YYYYMMDD-XXXX.
     *
     * Nomor urut di-reset setiap hari dan diisi zero-padding 4 digit.
     * Contoh: SLC-20260929-0001
     *
     * @return string Nomor resi yang belum pernah digunakan.
     */
    public static function buatNomorResi(): string
    {
        $prefix = 'SLC-' . now()->format('Ymd') . '-';
        $last = static::where('nomor_resi', 'like', $prefix . '%')
            ->orderByDesc('nomor_resi')
            ->first();
        $seq = $last ? ((int) Str::afterLast($last->nomor_resi, '-')) + 1 : 1;
        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope pencarian resi berdasarkan nomor resi, nama penerima, atau telepon.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null                           $q     Kata kunci pencarian.
     * @return \Illuminate\Database\Eloquent\Builder
     */
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

    /**
     * Scope filter resi berdasarkan nilai kolom status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null                           $status Nilai status (pending, transit, dll.).
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, ?string $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }
}