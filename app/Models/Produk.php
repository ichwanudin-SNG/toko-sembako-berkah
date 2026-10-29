<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori_id',
        'stok',
        'harga_beli',
        'harga_jual',
        'satuan',
        'gambar',
    ];

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            if (str_starts_with($this->gambar, 'http') || str_starts_with($this->gambar, 'images/')) {
                return asset($this->gambar);
            }
            return asset('storage/' . $this->gambar);
        }
        return asset('images/produk/default-sembako.svg');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }
}

