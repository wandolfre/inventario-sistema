    {{-- Care about people's approval and you will be their prisoner. --}}
<div class="p-4 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Ventas del mes</h2>
    <canvas id="ventasChart"></canvas>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        const labels = @json($labels);
        const data = @json($data);

        const ctx = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventas Q',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>



<div>
    <h2 class="text-2xl font-bold mb-4">Estadísticas de Ventas</h2>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Gráfico 1: Ventas por Día --}}
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Ventas por Día (últimos 30 días)</h3>
        <canvas id="ventasPorDia"></canvas>
    </div>

    {{-- Gráfico 2: Productos Más Vendidos --}}
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Top 5 Productos Más Vendidos</h3>
        <canvas id="productosTop"></canvas>
    </div>

    {{-- Gráfico 3: Ventas por Vendedor --}}
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-2">Ventas por Vendedor</h3>
        <canvas id="ventasPorVendedor"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ventas por día
            new Chart(document.getElementById('ventasPorDia'), {
                type: 'line',
                data: {
                    labels: @json($ventasPorDia->pluck('fecha')),
                    datasets: [{
                        label: 'Total en $',
                        data: @json($ventasPorDia->pluck('total')),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: true,
                    }]
                }
            });

            // Productos más vendidos
            new Chart(document.getElementById('productosTop'), {
                type: 'bar',
                data: {
                    labels: @json($productosTop->pluck('nombre')),
                    datasets: [{
                        label: 'Cantidad Vendida',
                        data: @json($productosTop->pluck('total')),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                }
            });

            // Ventas por vendedor
            new Chart(document.getElementById('ventasPorVendedor'), {
                type: 'pie',
                data: {
                    labels: @json($ventasPorVendedor->pluck('vendedor')),
                    datasets: [{
                        label: 'Total en $',
                        data: @json($ventasPorVendedor->pluck('total')),
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF']
                    }]
                }
            });
        });
    </script>
</div>


