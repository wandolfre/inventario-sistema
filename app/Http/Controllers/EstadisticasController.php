<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Ventas de los últimos 7 días
        $ventasUltimos7Dias = Venta::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Productos más vendidos
        $productosVendidos = VentaDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total')
            )
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('producto')
            ->get();

        return view('estadisticas.index', [
            'ventas7dias' => $ventasUltimos7Dias,
            'productosVendidos' => $productosVendidos,
        ]);
    }
}