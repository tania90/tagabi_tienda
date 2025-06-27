<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
protected $fillable = [
    'cliente_id',
    'monto_acumulado',
    'monto_canjeado',
];

    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class);
    }
}
