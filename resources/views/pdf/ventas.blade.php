<h2>Reporte de Ventas</h2>
<table width="100%" border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Total</th>
            <th>Productos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $venta->usuario->name }}</td>
                <td>${{ $venta->total }}</td>
                <td>
                    @foreach ($venta->detalles as $detalle)
                        {{ $detalle->producto->nombre }} (x{{ $detalle->cantidad }})<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
