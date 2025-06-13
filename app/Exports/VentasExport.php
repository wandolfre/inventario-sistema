<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VentasExport implements FromCollection, WithHeadings
{
    protected $filtros;
    
    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }
    
    public function collection()
    {
        // Start building the query with relationships and specific fields
        $query = Venta::with('usuario')->select('id', 'usuario_id', 'total', 'created_at');
        
        // Date filtering - handles both date ranges and single dates
        if (isset($this->filtros['fechaInicio']) && $this->filtros['fechaInicio']) {
            if (isset($this->filtros['fechaFin']) && $this->filtros['fechaFin']) {
                // If both dates provided, use date range
                $query->whereBetween('created_at', [
                    Carbon::parse($this->filtros['fechaInicio'])->startOfDay(),
                    Carbon::parse($this->filtros['fechaFin'])->endOfDay()
                ]);
            } else {
                // If only start date provided
                $query->whereDate('created_at', '>=', $this->filtros['fechaInicio']);
            }
        } elseif (isset($this->filtros['fechaFin']) && $this->filtros['fechaFin']) {
            // If only end date provided
            $query->whereDate('created_at', '<=', $this->filtros['fechaFin']);
        }
        
        // User filtering - handles both parameter name variations
        $usuarioId = $this->filtros['usuario_id'] ?? $this->filtros['usuarioId'] ?? null;
        if ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        }
        
        // Execute query and format data
        return $query->get()->map(function ($venta) {
            return [
                'ID' => $venta->id,
                'Fecha' => $venta->created_at->format('d/m/Y H:i'),
                'Vendedor' => $venta->usuario->name ?? 'Sin asignar',
                'Total' => number_format($venta->total, 2),
            ];
        });
    }
    
    public function headings(): array
    {
        return ['ID', 'Fecha', 'Vendedor', 'Total'];
    }
}