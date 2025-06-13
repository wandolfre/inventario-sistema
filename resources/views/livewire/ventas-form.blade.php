    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
<div class="p-4 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Registrar Venta</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <input type="text" wire:model="busqueda" placeholder="Buscar producto..."
           class="w-full p-2 border border-gray-300 rounded mb-2">

    @if ($productos)
        <ul class="mb-2 border border-gray-200 rounded">
            @foreach ($productos as $producto)
                <li wire:click="agregarProducto({{ $producto->id }})"
                    class="p-2 hover:bg-blue-100 cursor-pointer">{{ $producto->nombre }} (Q{{ $producto->precio }})</li>
            @endforeach
        </ul>
    @endif

    <table class="w-full text-left border-t mt-4">
        <thead>
            <tr>
                <th class="py-2">Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carrito as $index => $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item['nombre'] }}</td>
                    <td><input type="number" min="1" wire:change="actualizarCantidad({{ $index }}, $event.target.value)"
                               value="{{ $item['cantidad'] }}" class="w-16 p-1 border rounded"></td>
                    <td>Q{{ $item['precio'] }}</td>
                    <td>Q{{ $item['precio'] * $item['cantidad'] }}</td>
                    <td><button wire:click="eliminarProducto({{ $index }})" class="text-red-600">X</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 font-bold text-xl">Total: Q{{ $total }}</div>

    <button wire:click="guardarVenta"
            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar Venta</button>
</div>

