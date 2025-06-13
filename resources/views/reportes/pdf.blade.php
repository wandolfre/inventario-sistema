<h2>Reporte de ventas - {{ ucfirst($rango) }}</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->user_id }}</td>
            <td>{{ $venta->product_id }}</td>
            <td>{{ $venta->cantidad }}</td>
            <td>Q {{ $venta->precio_unitario }}</td>
            <td>Q {{ $venta->total }}</td>
            <td>{{ $venta->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
