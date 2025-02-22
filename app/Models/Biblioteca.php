<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Biblioteca extends Model
{
    //proteção de campos
    protected  $guarded = ['id', 'timestamps'];

    //Relacionamentos
    public function macroregiao(): BelongsTo
    {
        return $this->belongsTo(Macroregiao::class);
    }

    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }
}
