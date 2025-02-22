<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Macroregiao extends Model
{
    protected  $guarded = ['id', 'timestamps'];

    public function bibliotecas(): HasMany
    {
        return $this->hasMany(Biblioteca::class);
    }

}
