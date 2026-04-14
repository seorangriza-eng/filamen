<?php

namespace App\Models;

use App\Enums\ProgressTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $fillable = [
        'invoice',
        'customer_id',
        'cabang_id',
        'user_id',
        'total',
        'progress',
        'deadline',
        'spesial_treatment',
        'is_lunas'
    ];

    protected $casts = [
        'progress' => ProgressTransaksi::class,
        'spesial_treatment' => 'boolean',
        'is_lunas' => 'boolean'
    ];

    public function details():HasMany{
        return $this->hasMany(Transaksi_detail::class);
    }

    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    public function cabang():BelongsTo{
        return $this->belongsTo(Cabang::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function produk():BelongsTo{
        return $this->belongsTo(Produk::class);
    }

    public function bayar():HasMany{
        return $this->hasMany(Transaksi_pembayaran::class);
    }
}
