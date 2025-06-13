<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Exports\VentasExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportVentasController extends Controller
{
    public function exportExcel(Request $request)
    {
        return (new VentasExport($request->all()))->download('ventas.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Venta::with(['usuario', 'detalles.producto']);

        if ($request->fechaInicio && $request->fechaFin) {
            $query->whereBetween('created_at', [$request->fechaInicio, $request->fechaFin]);
        }

        if ($request->usuario_id) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $ventas = $query->get();

        $pdf = Pdf::loadView('pdf.ventas', compact('ventas'));
        return $pdf->download('ventas.pdf');
    }
}

