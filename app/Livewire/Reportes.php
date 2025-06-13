<?php

namespace App\Livewire;

use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class Reportes extends Component
{
    public $ventasHoy;
    public $ventasSemana;
    public $ventasMes;

    public function mount()
    {
        $this->ventasHoy = Venta::whereDate('created_at', Carbon::today())->sum('total');
        $this->ventasSemana = Venta::whereBetween('created_at', [
            Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()
        ])->sum('total');
        $this->ventasMes = Venta::whereMonth('created_at', Carbon::now()->month)->sum('total');
    }

    public function render()
    {
        return view('livewire.reportes');
    }
}