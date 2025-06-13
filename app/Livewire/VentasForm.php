<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;

class VentasForm extends Component
{
    public $busqueda = '';
    public $productos = [];
    public $carrito = [];
    public $total = 0;

    public function updatedBusqueda()
    {
        $this->productos = Producto::where('nombre', 'like', '%' . $this->busqueda . '%')->take(5)->get();
    }

    public function agregarProducto($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $this->carrito[] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
            ];
            $this->calcularTotal();
        }
        $this->busqueda = '';
        $this->productos = [];
    }

    public function actualizarCantidad($index, $cantidad)
    {
        $this->carrito[$index]['cantidad'] = $cantidad;
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = collect($this->carrito)->sum(function($item) {
            return $item['precio'] * $item['cantidad'];
        });
    }

    public function eliminarProducto($index)
    {
        unset($this->carrito[$index]);
        $this->carrito = array_values($this->carrito);
        $this->calcularTotal();
    }

    public function guardarVenta()
    {
        $venta = Venta::create([
            'usuario_id' => auth()->id(),
            'total' => $this->total,
        ]);

        foreach ($this->carrito as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
            ]);
        }

        session()->flash('message', '¡Venta guardada con éxito!');
        $this->carrito = [];
        $this->total = 0;
    }

    public function render()
    {
        return view('livewire.ventas-form');
    }
}

