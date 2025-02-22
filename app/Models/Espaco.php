<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Espaco extends Model
{

    //proteção de campos
    protected  $guarded = ['id', 'timestamps'];

    //Converte automaticamente JSON e array
    protected $casts = [
        'redes_sociais' => 'array',
        'servicos_prestados' => 'array',
    ];
    
    public function biblioteca(): BelongsTo
    {
        return $this->belongsTo(Biblioteca::class);
    }
}
