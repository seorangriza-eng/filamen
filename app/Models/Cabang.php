<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'nomer_wa'
    ];

    public function customer():HasMany{
        return $this->hasMany(Customer::class);
    }
}
