<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi_detail extends Model
{
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'quantity',
        'harga',
        'total_belanja'        
    ];

    protected $casts = [
        'quantity' => 'integer',
        'harga' => 'integer',
        'total_belanja' => 'integer'
    ];

    protected function transaksi():BelongsTo{
        return $this->belongsTo(Transaksi::class);
    }

    protected function produk():BelongsTo{
        return $this->belongsTo(Produk::class);
    }
}