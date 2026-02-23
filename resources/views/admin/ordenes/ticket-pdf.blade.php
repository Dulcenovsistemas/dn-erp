<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orden {{ $orden->folio }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border-bottom: 1px solid #ccc; padding: 5px; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <h2>DULCE NOVIEMBRE</h2>
    <p>Comprobante interno de orden</p>
</div>

<p><strong>Folio:</strong> {{ $orden->folio }}</p>
<p><strong>Sucursal:</strong> {{ $orden->sucursal->nombre }}</p>
<p><strong>Fecha:</strong> {{ $orden->fecha->format('d/m/Y H:i') }}</p>
<p><strong>Estado:</strong> {{ ucfirst($orden->estado) }}</p>

<h4>Productos</h4>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cant.</th>
            <th class="text-right">Precio</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orden->detalles as $detalle)
        <tr>
            <td>
                {{ $detalle->productoVariante->producto->nombre }}
                <br>
                <small>{{ $detalle->productoVariante->nombre }}</small>
            </td>
            <td>{{ $detalle->cantidad }}</td>
            <td class="text-right">${{ number_format($detalle->precio_unitario, 2) }}</td>
            <td class="text-right">${{ number_format($detalle->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($orden->mermas->count())
<h4>Mermas</h4>
<table>
    @foreach($orden->mermas as $merma)
    <tr>
        <td>{{ $merma->productoVariante->producto->nombre }}</td>
        <td>{{ $merma->cantidad }}</td>
        <td class="text-right">
            - ${{ number_format($merma->cantidad * $merma->monto, 2) }}
        </td>
    </tr>
    @endforeach
</table>
@endif

@if($orden->gastos->count())
<h4>Gastos</h4>
<table>
    @foreach($orden->gastos as $gasto)
    <tr>
        <td>{{ $gasto->concepto }}</td>
        <td class="text-right">
            - ${{ number_format($gasto->monto, 2) }}
        </td>
    </tr>
    @endforeach
</table>
@endif

<hr>

<table>
    <tr>
        <td>Subtotal:</td>
        <td class="text-right">${{ number_format($orden->subtotal, 2) }}</td>
    </tr>
    <tr>
        <td>Descuento:</td>
        <td class="text-right">- ${{ number_format($orden->descuento, 2) }}</td>
    </tr>
    <tr>
        <td>Total mermas:</td>
        <td class="text-right">- ${{ number_format($orden->total_mermas, 2) }}</td>
    </tr>
    <tr>
        <td>Total gastos:</td>
        <td class="text-right">- ${{ number_format($orden->total_gastos, 2) }}</td>
    </tr>
    <tr class="bold">
        <td>Total final:</td>
        <td class="text-right">${{ number_format($orden->total, 2) }}</td>
    </tr>
</table>

</body>
</html>
