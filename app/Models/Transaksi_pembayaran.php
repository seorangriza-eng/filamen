<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi_pembayaran extends Model
{
    protected $fillable = [
        'id',
        'transaksi_id',
        'user_id',
        'jumlah_bayar',
        'is_lunas',
        'metode'
    ];

    protected $casts = [
        'jumlah_bayar' => 'integer',
    ];

    public function transaksi(): BelongsTo {
        return $this->belongsTo(Transaksi::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
