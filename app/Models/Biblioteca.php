<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Biblioteca extends Model
{
    //proteção de campos
    protected  $guarded = ['id', 'timestamps'];

    //Converte automaticamente JSON e array
    protected $casts = [
        'redes_sociais' => 'array',
        'servicos_prestados' => 'array',
    ];

    //Relacionamentos
    public function macroregiao(): BelongsTo
    {
        return $this->belongsTo(Macroregiao::class);
    }

    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }

    public function espaco(): HasOne
    {
        return $this->hasOne(Espaco::class);
    }
}
