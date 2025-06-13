<h1>Reporte de Ventas</h1>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $venta->usuario->name }}</td>
            <td>Q{{ $venta->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
