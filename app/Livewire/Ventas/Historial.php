<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;

    public $fechaInicio;
    public $fechaFin;
    public $producto_id;
    public $usuario_id;

    public function render()
    {
        $query = Venta::with(['usuario', 'detalles.producto']);

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);
        }

        if ($this->usuario_id) {
            $query->where('usuario_id', $this->usuario_id);
        }

        $ventas = $query->latest()->paginate(10);

        $productos = Producto::all();
        $usuarios = User::all();

        return view('livewire.ventas.historial', compact('ventas', 'productos', 'usuarios'));
    }
}
