<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'nama',
        'nomer_wa',
        'rating',
        'cabang_id'
    ];

    protected $casts = [
        'rating' => 'float'
    ];

    public function cabang():BelongsTo{
        return $this->belongsTo(Cabang::class);
    }

    public function transaksi():HasMany{
        return $this->hasMany(Transaksi::class);
    }
}
