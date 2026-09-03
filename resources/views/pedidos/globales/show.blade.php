@extends('layouts.admin.app')

@section('content')

@php
    $resumenPorCategoria = $resumen->groupBy('categoria');
@endphp

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Encabezado --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    PEDIDOS GLOBALES
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Consolidado de producción por zona
                </p>
            </div>

            <div class="text-right">

                <p class="text-sm text-slate-500">
                    Semana del pedido
                </p>

                <p class="text-lg font-semibold text-slate-800">
                    {{ $inicioSemana->format('d/m/Y') }}
                    -
                    {{ $finSemana->format('d/m/Y') }}
                </p>

            </div>

        </div>

    </div>


    {{-- Tabla global --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-100 border-b">

                    <tr>

                        <th class="text-left px-4 py-3 font-semibold text-slate-700">
                            Producto
                        </th>

                        <th class="text-left px-4 py-3 font-semibold text-slate-700">
                            Variante
                        </th>

                        @foreach($zonas as $zona)

                            <th class="text-center px-4 py-3 font-semibold text-slate-700 whitespace-nowrap">
                                {{ $zona->nombre }}
                            </th>

                        @endforeach

                        <th class="text-center px-4 py-3 font-semibold text-slate-800">
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($resumenPorCategoria as $categoria => $filas)

                        {{-- Encabezado de categoría --}}
                        <tr class="bg-slate-800">

                            <td
                                colspan="{{ 3 + $zonas->count() }}"
                                class="px-4 py-3 font-bold text-white uppercase tracking-wide"
                            >
                                {{ $categoria }}
                            </td>

                        </tr>


                        {{-- Productos de la categoría --}}
                        @foreach($filas as $fila)

                            <tr class="border-b hover:bg-slate-50">

                                <td class="px-4 py-3 font-medium text-slate-800">
                                    {{ $fila['producto'] }}
                                </td>

                                <td class="px-4 py-3 text-slate-600">
                                    {{ $fila['variante'] }}
                                </td>


                                @foreach($zonas as $zona)

                                    <td class="px-4 py-3 text-center">

                                        {{ $fila['zonas'][$zona->id] ?? 0 }}

                                    </td>

                                @endforeach


                                <td class="px-4 py-3 text-center font-bold text-slate-800">

                                    {{ $fila['total'] }}

                                </td>

                            </tr>

                        @endforeach


                        {{-- Subtotal de categoría --}}
                        <tr class="bg-slate-50 border-b-2 border-slate-300">

                            <td
                                colspan="2"
                                class="px-4 py-3 font-semibold text-slate-700 text-right"
                            >
                                SUBTOTAL {{ strtoupper($categoria) }}
                            </td>


                            @foreach($zonas as $zona)

                                <td class="px-4 py-3 text-center font-bold text-slate-700">

                                    {{ $filas->sum(fn ($fila) => $fila['zonas'][$zona->id] ?? 0) }}

                                </td>

                            @endforeach


                            <td class="px-4 py-3 text-center font-bold text-slate-900">

                                {{ $filas->sum('total') }}

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="{{ 3 + $zonas->count() }}"
                                class="px-6 py-12 text-center text-slate-500"
                            >

                                <div class="text-lg font-medium">
                                    No hay pedidos para esta semana.
                                </div>

                                <div class="text-sm mt-1">
                                    Los pedidos enviados aparecerán aquí automáticamente.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>


                {{-- Total general --}}
                @if($resumen->isNotEmpty())

                    <tfoot class="bg-slate-100 border-t-2">

                        <tr>

                            <td
                                colspan="2"
                                class="px-4 py-3 font-bold text-slate-800"
                            >
                                TOTAL GENERAL
                            </td>


                            @foreach($zonas as $zona)

                                <td class="px-4 py-3 text-center font-bold text-slate-800">

                                    {{ $resumen->sum(fn ($fila) => $fila['zonas'][$zona->id] ?? 0) }}

                                </td>

                            @endforeach


                            <td class="px-4 py-3 text-center font-bold text-slate-900">

                                {{ $resumen->sum('total') }}

                            </td>

                        </tr>

                    </tfoot>

                @endif

            </table>

        </div>

    </div>

</div>

@endsection

