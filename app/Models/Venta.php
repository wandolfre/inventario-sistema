<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Add this $fillable property, or add to it if it already exists
    protected $fillable = [
        'usuario_id',
        'product_id',
        'cantidad',
        'precio_unitario',
        'total',
        // Add any other fields you want to be mass assignable here
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }


    // ... rest of your model code
}
