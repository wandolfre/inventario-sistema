{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div>
    <h2 class="text-xl font-bold mb-4">Inventario de Productos</h2>

    @if (session()->has('mensaje'))
        <div class="bg-green-200 text-green-800 px-4 py-2 mb-4 rounded">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- FORM SECTION - Only show to admins --}}
    @if(auth()->user()->role === 'admin')
        <form wire:submit.prevent="guardarProducto" class="bg-white shadow p-4 rounded mb-6">
            <h3 class="text-lg font-semibold mb-4">
                {{ $editando ? 'Editar Producto' : 'Agregar nuevo producto' }}
            </h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1">Nombre</label>
                    <input wire:model="nombre" type="text" class="w-full border p-2 rounded" />
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1">Código</label>
                    <input wire:model="codigo" type="text" class="w-full border p-2 rounded" />
                    @error('codigo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block mb-1">Descripción</label>
                    <textarea wire:model="descripcion" class="w-full border p-2 rounded"></textarea>
                </div>

                <div>
                    <label class="block mb-1">Cantidad</label>
                    <input wire:model="cantidad" type="number" class="w-full border p-2 rounded" />
                    @error('cantidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1">Precio</label>
                    <input wire:model="precio" type="number" step="0.01" class="w-full border p-2 rounded" />
                    @error('precio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            @if($editando)
                <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Guardar Cambios
                </button>
                <button type="button" wire:click="cancelarEdicion" class="mt-4 bg-gray-400 text-white px-4 py-2 rounded ml-2 hover:bg-gray-500">
                    Cancelar
                </button>
            @else
                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Producto
                </button>
            @endif
        </form>
    @endif

    {{-- SEARCH SECTION --}}
    <div class="mb-4">
        <input type="text" wire:model="buscar" placeholder="Buscar por nombre o código"
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300" />
    </div>

    {{-- PRODUCTS TABLE --}}
    <div class="bg-white shadow rounded">
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td class="border px-4 py-2">{{ $producto->codigo }}</td>
                        <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                        <td class="border px-4 py-2">{{ $producto->descripcion }}</td>
                        <td class="border px-4 py-2">{{ $producto->cantidad }}</td>
                        <td class="border px-4 py-2">Q{{ number_format($producto->precio, 2) }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="verDetalles({{ $producto->id }})"
                                class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 mr-2">
                                Ver detalles
                            </button>
                            
                            @if(auth()->user()->role === 'admin')
                                <button wire:click="editarProducto({{ $producto->id }})"
                                    class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 mr-2">
                                    Editar
                                </button>
                                <button wire:click="eliminarProducto({{ $producto->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- PAGINATION --}}
        <div class="p-4">
            {{ $productos->links() }}
        </div>
    </div>

    {{-- PRODUCT DETAILS MODAL --}}
    @if($mostrarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-xl font-bold mb-4">Detalles del producto</h2>
            
                <div class="space-y-2">
                    <p><strong>Nombre:</strong> {{ $productoSeleccionado['nombre'] }}</p>
                    <p><strong>Código:</strong> {{ $productoSeleccionado['codigo'] }}</p>
                    <p><strong>Precio:</strong> Q {{ number_format($productoSeleccionado['precio'], 2) }}</p>
                    <p><strong>Cantidad:</strong> {{ $productoSeleccionado['cantidad'] }}</p>
                    <p><strong>Descripción:</strong> {{ $productoSeleccionado['descripcion'] ?? 'Sin descripción' }}</p>
                </div>

                <div class="mt-6 text-right">
                    <button wire:click="cerrarModal"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>