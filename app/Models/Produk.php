<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'kategori_id',
        'deadline',
        'spesial_treatment'
    ];

    public function kategori():BelongsTo{
        return $this->belongsTo(Kategori::class);
    }

    public function details():HasMany{
        return $this->hasMany(Transaksi_detail::class);
    }

    public function transaksi():HasMany{
        return $this->hasMany(Transaksi::class);
    }
}
