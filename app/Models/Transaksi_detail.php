<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi_detail extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'produk' => 'string',
        'quantity' => 'integer',
        'harga' => 'integer'
    ];

    protected function transaksi():BelongsTo{
        return $this->belongsTo(Transaksi::class);
    }

    protected function produk():BelongsTo{
        return $this->belongsTo(Produk::class);
    }
}