    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div class="p-4 space-y-4">
    <h2 class="text-xl font-bold">Registrar Nueva Venta</h2>

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded">{{ session('error') }}</div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="flex space-x-4">
        <select wire:model="producto_id" class="border p-2 rounded w-full">
            <option value="">Selecciona un producto</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">
                    {{ $producto->nombre }} - ${{ $producto->precio }} (Stock: {{ $producto->stock }})
                </option>
            @endforeach
        </select>

        <input type="number" wire:model="cantidad" min="1" class="border p-2 w-24 rounded" placeholder="Cantidad" />

        <button wire:click="agregarProducto" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Agregar
        </button>
    </div>

    @if (!empty($carrito))
        <table class="table-auto w-full mt-4">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-1">Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrito as $index => $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>${{ $item['precio'] }}</td>
                        <td>${{ $item['subtotal'] }}</td>
                        <td>
                            <button wire:click="quitarProducto({{ $index }})" class="text-red-600">Quitar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 font-bold text-lg">
            Total: ${{ array_sum(array_column($carrito, 'subtotal')) }}
        </div>

        <button wire:click="guardarVenta" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar Venta
        </button>
    @endif
</div>

