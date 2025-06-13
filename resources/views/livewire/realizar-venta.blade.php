    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Registrar Venta</h2>

    {{-- Mensaje de éxito --}}
    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- Buscar producto --}}
    <input wire:model="busqueda" type="text" placeholder="Buscar producto por nombre o código"
        class="w-full p-2 border rounded mb-4">

    {{-- Resultados de búsqueda --}}
    @if($busqueda && $productosFiltrados)
        <ul class="bg-white border rounded mb-4">
            @foreach($productosFiltrados as $producto)
                <li class="p-2 hover:bg-gray-100 cursor-pointer"
                    wire:click="agregarProducto({{ $producto->id }})">
                    {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Carrito --}}
    <h3 class="text-lg font-semibold mt-4 mb-2">Carrito de Venta</h3>
    <table class="w-full mb-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Producto</th>
                <th class="p-2">Cantidad</th>
                <th class="p-2">Precio</th>
                <th class="p-2">Subtotal</th>
                <th class="p-2">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carrito as $item)
                <tr>
                    <td class="p-2">{{ $item['nombre'] }}</td>
                    <td class="p-2">{{ $item['cantidad'] }}</td>
                    <td class="p-2">${{ number_format($item['precio'], 2) }}</td>
                    <td class="p-2">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                    <td class="p-2">
                        <button wire:click="quitarProducto({{ $item['producto_id'] }})"
                            class="text-red-600 font-bold">X</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right text-lg font-semibold mb-4">
        Total: ${{ number_format($total, 2) }}
    </div>

    <button wire:click="registrarVenta"
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Registrar Venta
    </button>
</div>
