<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamano extends Model {
    protected $fillable = ['nombre'];
    public function productos() {
        return $this->hasMany(Producto::class);
    }
}

