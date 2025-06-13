<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->role === 'admin')
                        <h1>Bienvenido Administrador</h1>
                        <ul>
                            <li><a href="{{ route('productos') }}" class="text-blue-600 hover:underline">Administrar Productos</a></li>
                            <li><a href="/reportes" class="text-blue-600 hover:underline">Ver Reportes</a></li> {{-- This link still points to a separate page, if you keep it --}}
                        </ul>
                    @else
                        <h1>Bienvenido Vendedor</h1>
                        <ul>
                            <li><a href="{{ route('productos') }}" class="text-blue-600 hover:underline">Ver Inventario</a></li>
                        </ul>
                    @endif

                    {{-- Add @livewire('reportes') here to display the reports on the dashboard --}}
                    <h2 class="mt-8 text-lg font-semibold">Reportes Rápidos:</h2>
                    @livewire('reportes')
                    @livewire('estadisticas-ventas')
                    @livewire('crear-venta')
                    @livewire('historial-ventas')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
