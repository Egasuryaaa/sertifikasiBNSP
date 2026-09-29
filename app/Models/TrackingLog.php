<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingLog extends Model
{
    use HasFactory;

    protected $table = 'tracking_log';
    protected $fillable = ['resi_id', 'user_id', 'status', 'lokasi', 'keterangan'];

    public function resi(): BelongsTo
    {
        return $this->belongsTo(Resi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}