<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Auth;

class Crear extends Component
{
    public $productos = [];
    public $carrito = [];
    public $producto_id;
    public $cantidad = 1;

    public function mount()
    {
        $this->productos = Producto::all();
    }

    public function agregarProducto()
    {
        $producto = Producto::find($this->producto_id);

        if (!$producto || $this->cantidad <= 0 || $producto->stock < $this->cantidad) {
            session()->flash('error', 'Producto no válido o sin stock suficiente');
            return;
        }

        $this->carrito[] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => $this->cantidad,
            'subtotal' => $producto->precio * $this->cantidad,
        ];

        $this->producto_id = null;
        $this->cantidad = 1;
    }

    public function quitarProducto($index)
    {
        unset($this->carrito[$index]);
        $this->carrito = array_values($this->carrito); // Reindexa
    }

    public function guardarVenta()
    {
        if (empty($this->carrito)) {
            session()->flash('error', 'No hay productos en el carrito');
            return;
        }

        $total = array_sum(array_column($this->carrito, 'subtotal'));

        $venta = Venta::create([
            'usuario_id' => Auth::id(),
            'total' => $total,
        ]);

        foreach ($this->carrito as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
            ]);

            // Restar stock
            $producto = Producto::find($item['id']);
            $producto->stock -= $item['cantidad'];
            $producto->save();
        }

        $this->carrito = [];

        session()->flash('success', 'Venta registrada exitosamente');
    }

    public function render()
    {
        return view('livewire.ventas.crear');
    }
}

