{{-- In work, do what you enjoy. --}}
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Histórico de Ventas</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div>
            <label class="block mb-1">Desde</label>
            <input type="date" wire:model="fecha_inicio" class="w-full border p-2 rounded" />
        </div>
        <div>
            <label class="block mb-1">Hasta</label>
            <input type="date" wire:model="fecha_fin" class="w-full border p-2 rounded" />
        </div>
        <div>
            <label class="block mb-1">Usuario</label>
            <select wire:model="usuario_id" class="w-full border p-2 rounded">
                <option value="">Todos</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Producto</label>
            <select wire:model="producto_id" class="w-full border p-2 rounded">
                <option value="">Todos</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="flex gap-4 mb-4">
        <a href="{{ route('exportar.excel') }}" target="_blank"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-colors">
            📊 Exportar Excel
        </a>
        <a href="/ventas/exportar/pdf" target="_blank"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors">
            📄 Exportar PDF
        </a>
    </div>

    <!-- Add responsive wrapper for table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-full">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border font-semibold">Fecha</th>
                    <th class="p-2 border font-semibold">Usuario</th>
                    <th class="p-2 border font-semibold">Productos</th>
                    <th class="p-2 border font-semibold">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="p-2 border">
                            {{ $venta->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="p-2 border">
                            {{ $venta->usuario?->name ?? 'Usuario no disponible' }}
                        </td>
                        <td class="p-2 border">
                            <ul class="space-y-1">
                                @foreach ($venta->detalles as $detalle)
                                    <li class="text-sm">
                                        <span class="font-medium">{{ $detalle->producto?->nombre ?? 'Producto no disponible' }}</span>
                                        <span class="text-gray-600">(x{{ $detalle->cantidad }})</span> - 
                                        <span class="text-green-600 font-semibold">Q{{ number_format($detalle->precio_unitario, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-2 border font-bold text-lg text-green-700">
                            Q{{ number_format($venta->total, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No hay ventas encontradas</p>
                                <p class="text-sm">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ventas->links() }}
    </div>
    
    <div class="mb-4">
        <a href="{{ url('/exportar-ventas-excel') }}?fechaInicio={{ $fecha_inicio }}&fechaFin={{ $fecha_fin }}&usuarioId={{ $usuario_id }}" 
            class="bg-green-500 text-white px-4 py-2 rounded">📥 Exportar Excel</a>

        <a href="{{ url('/exportar-ventas-pdf') }}?fechaInicio={{ $fecha_inicio }}&fechaFin={{ $fecha_fin }}&usuarioId={{ $usuario_id }}" 
            class="bg-red-500 text-white px-4 py-2 rounded">📄 Exportar PDF</a>
    </div>

</div>