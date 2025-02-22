<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    //proteção de campos
    protected  $guarded = ['id', 'timestamps'];

    //Relacionamentos
    public function biblioteca(): BelongsTo
    {
        return $this->belongsTo(Biblioteca::class);
    }
}
