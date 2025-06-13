<?php

use Illuminate\Support\Facades\Route;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Livewire\Productos; 
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ReporteVentaController;
use App\Http\Controllers\EstadisticaController;
use App\Livewire\Estadisticas;
use App\Http\Controllers\ExportVentasController;


Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    Route::view('profile', 'profile')->name('profile');

    // Ruta para Livewire Productos protegida con auth
    // Route::get('/productos', Productos::class)->name('productos');
    Route::get('/productos', Productos::class)->name('productos');

    // Rutas con middleware role para administrador y vendedor
    Route::get('/admin', function () {
        return "Bienvenido, administrador";
    })->middleware('role:admin');

    Route::get('/vendedor', function () {
        return "Bienvenido, vendedor";
    })->middleware('role:vendedor');
    Route::get('/reportes/excel/{rango}', [ReporteController::class, 'exportExcel']);
    Route::get('/reportes/pdf/{rango}', [ReporteController::class, 'exportPdf']);
    Route::get('/ventas/exportar/pdf', function () {
        $ventas = Venta::with(['detalles.producto', 'usuario'])->latest()->get();
    
        $pdf = Pdf::loadView('exports.ventas_pdf', ['ventas' => $ventas]);
        return $pdf->download('reporte_ventas.pdf');
    });
    Route::get('/ventas/exportar/excel', function () {
        $ventas = Venta::with(['detalles.producto', 'usuario'])->latest()->get();
        return Excel::download(new VentasExport($ventas), 'reporte_ventas.xlsx');
    })->name('exportar.excel');
    Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas');
    Route::get('/ventas', function () {
        return view('ventas');
    })->middleware('auth');
    Route::get('/historial', function () {
        return view('historial');
    })->middleware('auth');
    Route::get('/exportar-ventas-excel', function(Request $request) {
        return Excel::download(new VentasExport($request->all()), 'ventas.xlsx');
    })->middleware('auth');

    Route::get('/exportar-ventas-pdf', [ReporteVentaController::class, 'exportarPDF'])->middleware('auth');

    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->middleware('auth');
    Route::get('/api/ventas-por-dia', [EstadisticaController::class, 'ventasPorDia'])->middleware('auth');
    Route::get('/estadisticas', Estadisticas::class)->name('estadisticas')->middleware(['auth']);

    Route::get('/ventas/export/excel', [ExportVentasController::class, 'exportExcel'])->name('ventas.excel');
    Route::get('/ventas/export/pdf', [ExportVentasController::class, 'exportPdf'])->name('ventas.pdf');

    Route::get('/estadisticas', function () {
        return view('admin.estadisticas');
    })->middleware('auth');
    Route::get('/ventas/registrar', function () {
        return view('ventas.registrar');
    })->middleware('auth');
    Route::get('/ventas/historial', function () {
        return view('ventas.historial');
    })->middleware('auth');


});

require __DIR__.'/auth.php';
