<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model TrackingLog — merepresentasikan satu entri riwayat perubahan status resi.
 *
 * Setiap baris adalah snapshot status pada waktu tertentu,
 * digunakan untuk menampilkan timeline perjalanan paket.
 *
 * @property int         $id
 * @property int         $resi_id
 * @property int         $user_id     Admin/kurir yang mencatat perubahan status.
 * @property string      $status      Status saat entri ini dicatat.
 * @property string      $lokasi      Nama kota/lokasi saat status dicatat.
 * @property string|null $keterangan  Catatan tambahan opsional.
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read Resi $resi
 * @property-read User $user
 */
class TrackingLog extends Model
{
    use HasFactory;

    protected $table = 'tracking_log';
    protected $fillable = ['resi_id', 'user_id', 'status', 'lokasi', 'keterangan'];

    /**
     * Resi yang memiliki log ini.
     *
     * @return BelongsTo<Resi, TrackingLog>
     */
    public function resi(): BelongsTo
    {
        return $this->belongsTo(Resi::class);
    }

    /**
     * User (admin/kurir) yang mencatat log ini.
     *
     * @return BelongsTo<User, TrackingLog>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}