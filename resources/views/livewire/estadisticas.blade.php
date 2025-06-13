{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Inventario por producto</h2>

    {{-- Botones de exportación --}}
    <div class="flex gap-2 mb-4">
        <a href="{{ route('ventas.excel', ['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin, 'usuario_id' => $usuario_id]) }}" target="_blank"
           class="bg-green-600 text-white px-3 py-1 rounded">Exportar Excel</a>

        <a href="{{ route('ventas.pdf', ['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin, 'usuario_id' => $usuario_id]) }}" target="_blank"
           class="bg-red-600 text-white px-3 py-1 rounded">Exportar PDF</a>
    </div>

    {{-- Gráfico de barras --}}
    <canvas id="graficoInventario"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            const ctx = document.getElementById('graficoInventario').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Cantidad en inventario',
                        data: @json($cantidades),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
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
</div>

