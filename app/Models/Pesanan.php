<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'no_pesanan',
        'user_id',
        'status',
        'total_harga',
        'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => '⏳ Menunggu',
            'diproses'   => '🔄 Diproses',
            'selesai'    => '✅ Selesai',
            'dibatalkan' => '❌ Dibatalkan',
            default      => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'badge-warning',
            'diproses'   => 'badge-info',
            'selesai'    => 'badge-success',
            'dibatalkan' => 'badge-danger',
            default      => 'badge-info',
        };
    }
}
