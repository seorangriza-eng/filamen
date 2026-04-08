<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'tb_produks';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'spesial_treatment' => 'boolean'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
}
