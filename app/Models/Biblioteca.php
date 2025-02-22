<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biblioteca extends Model
{
    protected  $guarded = ['id', 'timestamps'];

    public function macroregiao(): BelongsTo
    {
        return $this->belongsTo(Macroregiao::class);
    }
}
