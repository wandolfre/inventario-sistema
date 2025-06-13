<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Venta;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function exportExcel($rango)
    {
        return Excel::download(new VentasExport($rango), "ventas_{$rango}.xlsx");
    }

    public function exportPdf($rango)
    {
        $query = Venta::query();

        if ($rango == 'hoy') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($rango == 'semana') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($rango == 'mes') {
            $query->whereMonth('created_at', Carbon::now()->month);
        }

        $ventas = $query->get();

        $pdf = PDF::loadView('reportes.pdf', compact('ventas', 'rango'));

        return $pdf->download("ventas_{$rango}.pdf");
    }
}