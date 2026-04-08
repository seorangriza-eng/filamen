<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'tb_cabang';

    protected $fillable = [
        'nama',
        'alamat'
    ];

    public function customer(){
        return $this->hasMany(Customer::class);
    }

}
