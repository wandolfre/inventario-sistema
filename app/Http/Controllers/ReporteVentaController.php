<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use PDF;


class ReporteVentaController extends Controller
{
    public function exportarPDF(Request $request)
    {
        $ventas = Venta::with('usuario')
            ->when($request->fechaInicio, fn($q) => $q->whereDate('created_at', '>=', $request->fechaInicio))
            ->when($request->fechaFin, fn($q) => $q->whereDate('created_at', '<=', $request->fechaFin))
            ->when($request->usuarioId, fn($q) => $q->where('usuario_id', $request->usuarioId))
            ->get();

        $pdf = PDF::loadView('reportes.ventas-pdf', compact('ventas'));
        return $pdf->download('reporte_ventas.pdf');
    }
    //
}
