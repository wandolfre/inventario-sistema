    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Registrar Venta</h2>

    @if (session()->has('mensaje'))
        <div class="p-2 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('mensaje') }}
        </div>
    @endif

    @foreach ($lineas as $index => $linea)
        <div class="flex items-center gap-2 mb-2">
            <select wire:model="lineas.{{ $index }}.producto_id" class="p-2 border rounded w-1/2">
                <option value="">-- Selecciona producto --</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} - Q{{ $producto->precio }}</option>
                @endforeach
            </select>

            <input type="number" min="1" wire:model="lineas.{{ $index }}.cantidad" class="p-2 border rounded w-24" />

            <button wire:click="eliminarLinea({{ $index }})" class="px-2 py-1 text-white bg-red-500 rounded">X</button>
        </div>
    @endforeach

    <button wire:click="nuevaLinea" class="px-4 py-2 text-white bg-blue-600 rounded mb-4">Agregar producto</button>

    <div class="mb-4">
        <strong>Total: </strong> Q{{ number_format($total, 2) }}
    </div>

    <button wire:click="guardarVenta" class="px-4 py-2 text-white bg-green-600 rounded">Guardar Venta</button>
</div>
