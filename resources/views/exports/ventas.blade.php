<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Productos</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $venta->usuario->name }}</td>
                <td>
                    @foreach ($venta->detalles as $detalle)
                        {{ $detalle->producto->nombre }} (x{{ $detalle->cantidad }}), 
                    @endforeach
                </td>
                <td>{{ $venta->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
