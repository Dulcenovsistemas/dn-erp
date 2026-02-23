@extends('layouts.admin.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8">

    {{-- ENCABEZADO --}}
    <div class="text-center border-b pb-4 mb-6">
        <h2 class="text-2xl font-bold">DULCE NOVIEMBRE PASTELERIA</h2>
        <p class="text-sm text-gray-600">Comprobante interno de orden</p>
        <a href="{{ route('admin.ordenes.pdf', $orden) }}"
        class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
        Descargar PDF
        </a>

    </div>

    {{-- INFO GENERAL --}}
    <div class="grid grid-cols-2 gap-4 text-sm mb-6">
        <div>
            <p><strong>Folio:</strong> {{ $orden->folio }}</p>
            <p><strong>Sucursal:</strong> {{ $orden->sucursal->nombre }}</p>
            <p><strong>Fecha:</strong> {{ $orden->fecha->format('d/m/Y H:i') }}</p>
        </div>
        <div class="text-right">
            <p>
                <strong>Estado:</strong> 
                <span class="px-2 py-1 text-xs rounded 
                    {{ $orden->estado === 'finalizada' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($orden->estado) }}
                </span>
            </p>
        </div>
    </div>

    {{-- DETALLE PRODUCTOS --}}
    <h3 class="font-semibold mb-2 border-b pb-1">Productos</h3>

    <table class="w-full text-sm mb-6">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Producto</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->detalles as $detalle)
            <tr class="border-b">
                <td class="py-2">
                <div class="font-medium">
                    {{ $detalle->productoVariante->producto->nombre }}
                </div>

                @if($detalle->productoVariante->nombre)
                    <div class="text-xs text-gray-500">
                        {{ $detalle->productoVariante->nombre }}
                    </div>
                @endif
            </td>

                <td class="text-center">
                    {{ $detalle->cantidad }}
                </td>
                <td class="text-right">
                    ${{ number_format($detalle->precio_unitario, 2) }}
                </td>
                <td class="text-right">
                    ${{ number_format($detalle->total, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MERMAS --}}
    @if($orden->mermas->count())
    <h3 class="font-semibold mb-2 border-b pb-1">Mermas</h3>

    <table class="w-full text-sm mb-6">
        @foreach($orden->mermas as $merma)
        <tr class="border-b">
            <td class="py-2">
                {{ $merma->productoVariante->producto->nombre }}
            </td>
            <td class="text-center">
                {{ $merma->cantidad }}
            </td>
            <td class="text-right text-red-600">
                - ${{ number_format($merma->cantidad * $merma->monto, 2) }}
            </td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- GASTOS --}}
    @if($orden->gastos->count())
    <h3 class="font-semibold mb-2 border-b pb-1">Gastos</h3>

    <table class="w-full text-sm mb-6">
        @foreach($orden->gastos as $gasto)
        <tr class="border-b">
            <td class="py-2">
                {{ $gasto->concepto }}
            </td>
            <td class="text-right text-red-600">
                - ${{ number_format($gasto->monto, 2) }}
            </td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- TOTALES --}}
    <div class="border-t pt-4 text-sm">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>${{ number_format($orden->subtotal, 2) }}</span>
        </div>

        <div class="flex justify-between">
            <span>Descuento:</span>
            <span class="text-red-600">
                - ${{ number_format($orden->descuento, 2) }}
            </span>
        </div>

        <div class="flex justify-between">
            <span>Total mermas:</span>
            <span class="text-red-600">
                - ${{ number_format($orden->total_mermas, 2) }}
            </span>
        </div>

        <div class="flex justify-between">
            <span>Total gastos:</span>
            <span class="text-red-600">
                - ${{ number_format($orden->total_gastos, 2) }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-lg border-t mt-2 pt-2">
            <span>Total final:</span>
            <span>${{ number_format($orden->total, 2) }}</span>
        </div>
    </div>

</div>
@endsection
