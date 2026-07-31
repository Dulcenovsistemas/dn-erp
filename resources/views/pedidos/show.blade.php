@extends('layouts.admin.app')

@section('title', 'Pedido '.$pedido->folio)

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Encabezado --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

        <div class="flex justify-between items-start">

            <div>

                <h1 class="text-2xl font-bold">
                    Pedido {{ $pedido->folio }}
                </h1>

                <p class="text-gray-500 mt-1">
                    Información general del pedido
                </p>

            </div>

            <span class="px-3 py-1 rounded-full text-sm
                @if($pedido->estatus=='borrador')
                    bg-gray-200 text-gray-700
                @elseif($pedido->estatus=='enviado')
                    bg-blue-100 text-blue-700
                @elseif($pedido->estatus=='preparacion')
                    bg-yellow-100 text-yellow-700
                @elseif($pedido->estatus=='entregado')
                    bg-green-100 text-green-700
                @else
                    bg-red-100 text-red-700
                @endif">

                {{ ucfirst($pedido->estatus) }}

            </span>

        </div>

    </div>

    {{-- Datos generales --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

        <div class="grid grid-cols-4 gap-6">

            <div>

                <label class="text-sm text-gray-500">
                    Zona
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->zona->nombre }}
                </div>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Usuario
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->usuario->name }}
                </div>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Fecha pedido
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->fecha_pedido->format('d/m/Y') }}
                </div>

            </div>

            <div>

                <label class="text-sm text-gray-500">
                    Fecha entrega
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->fecha_entrega->format('d/m/Y') }}
                </div>

            </div>

        </div>

        @if($pedido->observaciones)

            <div class="mt-6">

                <label class="text-sm text-gray-500">
                    Observaciones
                </label>

                <div class="mt-1">
                    {{ $pedido->observaciones }}
                </div>

            </div>

        @endif

    </div>

    @php

        $dias = $pedido->detalles->groupBy('fecha');

    @endphp

    @php
    $dias = $pedido->detalles
        ->sortBy('fecha')
        ->groupBy('fecha');
@endphp

@foreach($dias as $fecha => $detalles)

<div class="bg-white rounded-xl shadow-sm p-6 mb-6">

    <h2 class="text-xl font-bold mb-6">
        {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l d \d\e F') }}
    </h2>

    @php

        $categorias = $detalles->groupBy(function ($detalle) {
            return $detalle->producto->categoria->nombre;
        });

    @endphp

    @foreach($categorias as $nombreCategoria => $itemsCategoria)

        <div class="mb-8 border rounded-lg overflow-hidden">

            <div class="bg-pink-300 px-4 py-2 font-bold">
                {{ strtoupper($nombreCategoria) }}
            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="text-left p-3">
                            Producto
                        </th>

                        <th class="text-center p-3">
                            Variante
                        </th>

                        <th class="text-center p-3">
                            Cantidad
                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach(
                    $itemsCategoria
                        ->groupBy('producto_id')
                    as $productoId => $itemsProducto
                )

                    @foreach($itemsProducto as $detalle)

                        <tr class="border-t">

                            <td class="p-3">

                                {{ $detalle->producto->nombre }}

                            </td>

                            <td class="text-center">

                                {{ $detalle->variante->nombre }}

                            </td>

                            <td class="text-center font-semibold">

                                {{ $detalle->cantidad }}

                            </td>

                        </tr>

                    @endforeach

                @endforeach

                </tbody>

            </table>

        </div>

    @endforeach

</div>

@endforeach

    <div class="flex justify-end">

        <a href="{{ route('admin.pedidos.index') }}"
           class="px-5 py-2 bg-gray-900 text-white rounded-lg">

            Regresar

        </a>

    </div>

</div>

@endsection