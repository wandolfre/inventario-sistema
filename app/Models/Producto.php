<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'cantidad',
        'precio',
    ];

    public function hayStock($cantidad = 1)
    {
        return $this->cantidad >= $cantidad;
    }

    public function reducirStock($cantidad)
    {
        $this->cantidad -= $cantidad;
        $this->save();
    }
}

