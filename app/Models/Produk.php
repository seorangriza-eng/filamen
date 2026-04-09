<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
