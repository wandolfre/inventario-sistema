@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Estadísticas</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Gráfico de barras -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Ventas últimos 7 días</h2>
            <canvas id="ventasChart"></canvas>
        </div>

        <!-- Gráfico de pastel -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Top 5 Productos Vendidos</h2>
            <canvas id="productosChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ventasCtx = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ventasCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ventas7dias->pluck('fecha')) !!},
            datasets: [{
                label: 'Total Ventas (Q)',
                data: {!! json_encode($ventas7dias->pluck('total')) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const productosCtx = document.getElementById('productosChart').getContext('2d');
    const productosChart = new Chart(productosCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($productosVendidos->pluck('producto.nombre')) !!},
            datasets: [{
                data: {!! json_encode($productosVendidos->pluck('total')) !!},
                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa'],
            }]
        }
    });
</script>
@endsection
