<?php

namespace App\Models;

use App\Enums\ProgressTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $fillable = [
        'invoie',
        'customer_id',
        'cabang_id',
        'total',
        'progress',
        'deadline',
        'spesial_treatment'
    ];

    protected $casts = [
        'progress' => ProgressTransaksi::class,
        'spesial_treatment' => 'boolean'
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
}
