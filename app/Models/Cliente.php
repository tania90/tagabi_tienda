<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'total_productos_comprados',
        'monto_acumulado'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

public function recompensas()
{
    return $this->hasMany(\App\Models\Recompensa::class);
}


    public function getNivelFidelizacionAttribute()
{
    $monto = $this->monto_acumulado;

    if ($monto > 500000) {
        return '🥇 Oro';
    } elseif ($monto > 150000) {
        return '🥈 Plata';
    } else {
        return '🥉 Bronce';
    }
}
}

