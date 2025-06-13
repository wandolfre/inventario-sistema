    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Reportes de Ventas</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded">
            <h3 class="text-lg font-semibold">Hoy</h3>
            <p class="text-2xl font-bold text-blue-700">Q {{ number_format($ventasHoy, 2) }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <h3 class="text-lg font-semibold">Esta Semana</h3>
            <p class="text-2xl font-bold text-green-700">Q {{ number_format($ventasSemana, 2) }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded">
            <h3 class="text-lg font-semibold">Este Mes</h3>
            <p class="text-2xl font-bold text-yellow-700">Q {{ number_format($ventasMes, 2) }}</p>
        </div>
    </div>

    {{-- Más adelante: botones para exportar PDF o Excel --}}
</div>
