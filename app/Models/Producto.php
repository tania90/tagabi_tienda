<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'cantidad',
        'color',
        'precio_venta',
        'precio_costo',
        'imagen',
        'categoria_id',
        'tamano_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tamano()
    {
        return $this->belongsTo(Tamano::class);
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
