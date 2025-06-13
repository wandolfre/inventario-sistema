<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;

class CrearVenta extends Component
{
    public $productos;
    public $lineas = [];
    public $total = 0;

    public function mount()
    {
        $this->productos = Producto::all();
        $this->nuevaLinea();
    }

    public function nuevaLinea()
    {
        $this->lineas[] = ['producto_id' => '', 'cantidad' => 1];
    }

    public function eliminarLinea($index)
    {
        unset($this->lineas[$index]);
        $this->lineas = array_values($this->lineas);
        $this->calcularTotal();
    }

    public function updatedLineas()
    {
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = 0;
        foreach ($this->lineas as $linea) {
            $producto = Producto::find($linea['producto_id']);
            if ($producto && isset($linea['cantidad'])) {
                $this->total += $producto->precio * $linea['cantidad'];
            }
        }
    }

    public function guardarVenta()
    {
        $venta = Venta::create([
            'user_id' => Auth::id(),
            'total' => $this->total
        ]);

        foreach ($this->lineas as $linea) {
            $producto = Producto::find($linea['producto_id']);
            if ($producto) {
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $linea['cantidad'],
                    'precio_unitario' => $producto->precio
                ]);

                // Disminuir inventario
                $producto->stock -= $linea['cantidad'];
                $producto->save();
            }
        }

        session()->flash('mensaje', 'Venta registrada exitosamente');
        $this->lineas = [];
        $this->total = 0;
        $this->nuevaLinea();
    }

    public function render()
    {
        return view('livewire.crear-venta');
    }
}

