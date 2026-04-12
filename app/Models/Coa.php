<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coa extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'normal_balance',
        'is_active'
    ];

    protected $casts = [ 
        'is_active' => 'boolean'
    ];

    public function details():HasMany{
        return $this->hasMany(Jurnal_detail::class);
    }

}
