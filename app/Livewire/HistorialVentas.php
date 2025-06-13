<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venta;
use App\Models\User;
use App\Models\Producto;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class HistorialVentas extends Component
{
    use WithPagination;

    public $fecha_inicio;
    public $fecha_fin;
    public $usuario_id;
    public $producto_id;

    public $usuarios;
    public $productos;

    public function mount()
    {
        $this->usuarios = User::all();
        $this->productos = Producto::all();
    }

    public function render()
    {
        $ventas = Venta::with(['detalles', 'usuario'])
            ->when($this->fecha_inicio, function ($query) {
                $query->whereDate('created_at', '>=', $this->fecha_inicio);
            })
            ->when($this->fecha_fin, function ($query) {
                $query->whereDate('created_at', '<=', $this->fecha_fin);
            })
            ->when($this->usuario_id, function ($query) {
                $query->where('user_id', $this->usuario_id);
            })
            ->when($this->producto_id, function ($query) {
                $query->whereHas('detalles', function ($q) {
                    $q->where('producto_id', $this->producto_id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(10);

        return view('livewire.historial-ventas', [
            'ventas' => $ventas,
            'usuarios' => User::all(),
            'productos' => Producto::all(),
        ]);
    }
}
