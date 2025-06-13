<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;

class Estadisticas extends Component
{
    public $labels = [];
    public $cantidades = [];

    public function mount()
    {
        $productos = Producto::orderBy('nombre')->get();
        $this->labels = $productos->pluck('nombre');
        $this->cantidades = $productos->pluck('cantidad');
    }

    public function render()
    {
        return view('livewire.estadisticas', [
            'fechaInicio' => '2024-01-01', // o la variable que estés usando realmente
            'fechaFin' => '2024-12-31',
            'usuario_id' => auth()->id()
        ])->layout('layouts.app');
    
    }
    
}
