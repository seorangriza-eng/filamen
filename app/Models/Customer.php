<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tb_customers';

    protected $fillable = [
        'nama',
        'nomer_wa',
        'rating',
        'cabang_id'
    ];

    protected $cast = [
        'rating' => "float"
    ];

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }    
}
