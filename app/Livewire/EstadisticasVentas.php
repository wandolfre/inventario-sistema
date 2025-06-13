<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venta;
use Carbon\Carbon;

class EstadisticasVentas extends Component
{
    public $labels = [];
    public $data = [];

    public function mount()
    {
        $this->generarEstadisticasMensuales();
    }

    public function generarEstadisticasMensuales()
    {
        $ventas = Venta::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $this->labels = $ventas->pluck('fecha')->toArray();
        $this->data = $ventas->pluck('total')->toArray();
    }

    public function render()
    {
        return view('livewire.estadisticas-ventas');
    }
}

