    {{-- The whole world belongs to you. --}}
<div class="p-4 space-y-4">
    <h2 class="text-xl font-bold">Historial de Ventas</h2>

    <div class="flex flex-wrap gap-4">
        <div>
            <label>Fecha Inicio:</label>
            <input type="date" wire:model="fechaInicio" class="border p-1 rounded">
        </div>
        <div>
            <label>Fecha Fin:</label>
            <input type="date" wire:model="fechaFin" class="border p-1 rounded">
        </div>
        <div>
            <label>Producto:</label>
            <select wire:model="producto_id" class="border p-1 rounded">
                <option value="">Todos</option>
                @foreach ($productos as $prod)
                    <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Vendedor:</label>
            <select wire:model="usuario_id" class="border p-1 rounded">
                <option value="">Todos</option>
                @foreach ($usuarios as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table-auto w-full mt-4 text-sm">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="px-2 py-1">Fecha</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Productos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr class="border-b">
                    <td class="px-2 py-1">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->usuario->name }}</td>
                    <td>${{ $venta->total }}</td>
                    <td>
                        <ul class="list-disc pl-4">
                            @foreach ($venta->detalles as $detalle)
                                @if (!$producto_id || $detalle->producto_id == $producto_id)
                                    <li>{{ $detalle->producto->nombre }} (x{{ $detalle->cantidad }})</li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $ventas->links() }}
    </div>
    <x-app-layout>
    <div class="p-4">
        @livewire('historial-ventas')
    </div>
    </x-app-layout>
</div>

