<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jurnal_detail extends Model
{
    protected $guarded = ['id'];

    protected $cast = [
        'debit' => 'numeric',
        'kredit' => 'numeric',
    ];

    public function jurnal():BelongsTo{
        return $this->belongsTo(Jurnal::class);
    }
    public function coa():BelongsTo{
        return $this->belongsTo(Coa::class);
    }
}
