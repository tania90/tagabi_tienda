<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
    'cliente_id',
    'fecha',
    'total',
];
    public function cliente()
{
    return $this->belongsTo(Cliente::class);
}

public function detalleVentas()
{
    return $this->hasMany(DetalleVenta::class);
}
}
