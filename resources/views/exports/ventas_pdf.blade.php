<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
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
                    <td>Q{{ $venta->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
