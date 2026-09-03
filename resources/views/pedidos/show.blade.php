@extends('layouts.admin.app')

@section('title', 'Pedido '.$pedido->folio)

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

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


            {{-- Estatus --}}
            <span class="px-3 py-1 rounded-full text-sm

                @if($pedido->estatus == 'borrador')
                    bg-gray-200 text-gray-700

                @elseif($pedido->estatus == 'enviado')
                    bg-blue-100 text-blue-700

                @elseif($pedido->estatus == 'preparacion')
                    bg-yellow-100 text-yellow-700

                @elseif($pedido->estatus == 'entregado')
                    bg-green-100 text-green-700

                @else
                    bg-red-100 text-red-700
                @endif
            ">

                {{ ucfirst($pedido->estatus) }}

            </span>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- DATOS GENERALES --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

        <div class="grid grid-cols-4 gap-6">


            {{-- Zona --}}
            <div>

                <label class="text-sm text-gray-500">
                    Zona
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->zona->nombre }}
                </div>

            </div>


            {{-- Usuario --}}
            <div>

                <label class="text-sm text-gray-500">
                    Usuario
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->usuario->name }}
                </div>

            </div>


            {{-- Fecha pedido --}}
            <div>

                <label class="text-sm text-gray-500">
                    Fecha pedido
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->fecha_pedido->format('d/m/Y') }}
                </div>

            </div>


            {{-- Fecha entrega --}}
            <div>

                <label class="text-sm text-gray-500">
                    Fecha entrega
                </label>

                <div class="font-semibold mt-1">
                    {{ $pedido->fecha_entrega->format('d/m/Y') }}
                </div>

            </div>

        </div>


        {{-- Observaciones --}}
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


    {{-- ========================================================= --}}
    {{-- PREPARAR LOS DÍAS --}}
    {{-- ========================================================= --}}

    @php

        $dias = $pedido->detalles
            ->sortBy('fecha')
            ->groupBy('fecha')
            ->values();

        $primerDia = 0;

    @endphp


    {{-- ========================================================= --}}
    {{-- PEDIDO POR DÍAS --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">


        {{-- ===================================================== --}}
        {{-- PESTAÑAS --}}
        {{-- ===================================================== --}}

        <div class="border-b border-gray-200 mb-6">

            <div class="flex gap-1 overflow-x-auto">

                @foreach($dias as $indice => $detalles)

                    @php

                        $fecha = $detalles->first()->fecha;

                        $fechaCarbon = \Carbon\Carbon::parse($fecha);

                    @endphp


                    <button
                        type="button"
                        onclick="mostrarDia({{ $indice }})"
                        id="tab-{{ $indice }}"

                        class="tab-dia px-5 py-3 text-sm font-semibold whitespace-nowrap border-b-2 transition

                            {{ $indice === $primerDia

                                ? 'border-pink-500 text-pink-600'

                                : 'border-transparent text-gray-500 hover:text-gray-700'

                            }}
                        "
                    >

                        {{ $fechaCarbon->translatedFormat('D d') }}

                    </button>

                @endforeach

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- CONTENIDO DE CADA DÍA --}}
        {{-- ===================================================== --}}

        @foreach($dias as $indice => $detalles)

            @php

                $fecha = $detalles->first()->fecha;

                $fechaCarbon = \Carbon\Carbon::parse($fecha);


                $categorias = $detalles
                    ->groupBy(function ($detalle) {

                        return $detalle->producto->categoria->nombre;

                    });


                // Total de piezas del día
                $totalDia = $detalles->sum('cantidad');

            @endphp


            <div
                id="dia-{{ $indice }}"
                class="contenido-dia {{ $indice !== $primerDia ? 'hidden' : '' }}"
            >


                {{-- ================================================= --}}
                {{-- ENCABEZADO DEL DÍA --}}
                {{-- ================================================= --}}

                <div class="flex justify-between items-center mb-6">

                    <div>

                        <h2 class="text-xl font-bold text-gray-800">

                            {{ $fechaCarbon->translatedFormat('l d \d\e F') }}

                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Pedido correspondiente a este día
                        </p>

                    </div>


                    {{-- Total del día --}}
                    <div class="text-right">

                        <p class="text-sm text-gray-500">
                            Total del día
                        </p>

                        <p class="text-2xl font-bold text-pink-600">
                            {{ $totalDia }}
                        </p>

                        <p class="text-xs text-gray-400">
                            piezas
                        </p>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CATEGORÍAS --}}
                {{-- ================================================= --}}

                @foreach($categorias as $nombreCategoria => $itemsCategoria)


                    <div class="mb-8 border rounded-lg overflow-hidden">


                        {{-- Nombre categoría --}}
                        <div class="bg-pink-300 px-4 py-2 font-bold">

                            {{ strtoupper($nombreCategoria) }}

                        </div>


                        {{-- Tabla --}}
                        <div class="overflow-x-auto">

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


                                    @foreach($itemsCategoria as $detalle)

                                        <tr class="border-t">


                                            {{-- Producto --}}
                                            <td class="p-3 font-medium">

                                                {{ $detalle->producto->nombre }}

                                            </td>


                                            {{-- Variante --}}
                                            <td class="text-center p-3">

                                                {{ $detalle->variante->nombre }}

                                            </td>


                                            {{-- Cantidad --}}
                                            <td class="text-center p-3 font-semibold">

                                                {{ $detalle->cantidad }}

                                            </td>


                                        </tr>

                                    @endforeach


                                </tbody>

                            </table>

                        </div>

                    </div>


                @endforeach


            </div>

        @endforeach


    </div>


    {{-- ========================================================= --}}
    {{-- BOTÓN REGRESAR --}}
    {{-- ========================================================= --}}

    <div class="flex justify-end">

        <a
            href="{{ route('admin.pedidos.index') }}"
            class="px-5 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition"
        >

            Regresar

        </a>

    </div>


</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT DE LAS PESTAÑAS --}}
{{-- ============================================================= --}}

<script>

    function mostrarDia(indice) {

        /*
        |--------------------------------------------------------------------------
        | Ocultar todos los días
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.contenido-dia')
            .forEach(function(elemento) {

                elemento.classList.add('hidden');

            });


        /*
        |--------------------------------------------------------------------------
        | Mostrar el día seleccionado
        |--------------------------------------------------------------------------
        */

        const contenido = document.getElementById('dia-' + indice);

        if (contenido) {

            contenido.classList.remove('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Restaurar estilo de todas las pestañas
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.tab-dia')
            .forEach(function(tab) {

                tab.classList.remove(
                    'border-pink-500',
                    'text-pink-600'
                );

                tab.classList.add(
                    'border-transparent',
                    'text-gray-500'
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Activar pestaña seleccionada
        |--------------------------------------------------------------------------
        */

        const tabActivo = document.getElementById('tab-' + indice);

        if (tabActivo) {

            tabActivo.classList.remove(
                'border-transparent',
                'text-gray-500'
            );

            tabActivo.classList.add(
                'border-pink-500',
                'text-pink-600'
            );

        }

    }

</script>

@endsection