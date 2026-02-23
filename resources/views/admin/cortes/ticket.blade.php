@extends('layouts.admin.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-8">

    <div class="text-center border-b pb-4 mb-6">
        <h2 class="text-2xl font-bold">CORTE DE CAJA</h2>
        <p class="text-sm text-gray-600">
            {{ $orden->folio }}
        </p>
        <p class="text-sm text-gray-600">
            {{ $orden->fecha }}
        </p>
    </div>

    {{-- RESUMEN ORDEN --}}
    <div class="mb-6 text-sm">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>${{ number_format($orden->subtotal, 2) }}</span>
        </div>

        <div class="flex justify-between text-red-600">
            <span>Descuento:</span>
            <span>- ${{ number_format($orden->descuento, 2) }}</span>
        </div>

        <div class="flex justify-between text-red-600">
            <span>Mermas:</span>
            <span>- ${{ number_format($orden->total_mermas, 2) }}</span>
        </div>

        <div class="flex justify-between text-red-600">
            <span>Gastos:</span>
            <span>- ${{ number_format($orden->total_gastos, 2) }}</span>
        </div>

        <div class="flex justify-between font-bold border-t mt-2 pt-2">
            <span>Total Venta:</span>
            <span>${{ number_format($orden->total, 2) }}</span>
        </div>
    </div>

    {{-- PAGOS --}}
    @php
        $efectivo = $orden->pagos->where('metodo','efectivo')->sum('monto');
        $tarjeta  = $orden->pagos->where('metodo','tarjeta')->sum('monto');
        $recibido = $efectivo + $tarjeta;
        $diferencia = round($recibido - $orden->total, 2);
    @endphp

    <div class="mb-6 text-sm border-t pt-4">

        <div class="flex justify-between text-green-600">
            <span>Efectivo:</span>
            <span>${{ number_format($efectivo, 2) }}</span>
        </div>

        <div class="flex justify-between text-blue-600">
            <span>Tarjeta:</span>
            <span>${{ number_format($tarjeta, 2) }}</span>
        </div>

        <div class="flex justify-between font-semibold mt-2">
            <span>Total Recibido:</span>
            <span>${{ number_format($recibido, 2) }}</span>
        </div>

        <div class="flex justify-between font-bold text-lg mt-4
            @if($diferencia > 0) text-green-600
            @elseif($diferencia < 0) text-red-600
            @else text-gray-700
            @endif">

            <span>
                @if($diferencia > 0)
                    Sobrante:
                @elseif($diferencia < 0)
                    Faltante:
                @else
                    Corte exacto:
                @endif
            </span>

            <span>
                ${{ number_format(abs($diferencia), 2) }}
            </span>

        </div>

    </div>

</div>

@endsection
