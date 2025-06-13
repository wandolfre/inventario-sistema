<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Auth;

class RealizarVenta extends Component
{
    public $busqueda = '';
    public $productosFiltrados = [];
    public $carrito = [];
    public $total = 0;

    public function updatedBusqueda()
    {
        $this->productosFiltrados = Producto::where('nombre', 'like', "%{$this->busqueda}%")
            ->orWhere('codigo', 'like', "%{$this->busqueda}%")
            ->take(5)
            ->get();
    }

    public function agregarProducto($productoId)
    {
        $producto = Producto::find($productoId);
        if (!$producto) return;

        if (isset($this->carrito[$productoId])) {
            $this->carrito[$productoId]['cantidad']++;
        } else {
            $this->carrito[$productoId] = [
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1
            ];
        }

        $this->actualizarTotal();
    }

    public function quitarProducto($productoId)
    {
        unset($this->carrito[$productoId]);
        $this->actualizarTotal();
    }

    public function actualizarTotal()
    {
        $this->total = collect($this->carrito)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });
    }

    public function registrarVenta()
    {
        $venta = Venta::create([
            'usuario_id' => Auth::id(),
            'total' => $this->total
        ]);

        foreach ($this->carrito as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio']
            ]);
        }

        $this->reset(['carrito', 'total', 'busqueda', 'productosFiltrados']);
        session()->flash('mensaje', 'Venta registrada correctamente.');
    }

    public function render()
    {
        return view('livewire.realizar-venta');
    }
}

