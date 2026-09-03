@extends('layouts.admin.app')

@section('title', 'Pedidos Globales')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Encabezado --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    PEDIDOS GLOBALES
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Reportes y consolidado semanal de producción
                </p>
            </div>

        </div>

    </div>


    {{-- Lista de semanas --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">

            <h2 class="text-lg font-semibold text-slate-800">
                Semanas de producción
            </h2>

        </div>

            {{-- Generar pedido global --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

        <div class="mb-4">

            <h2 class="text-lg font-semibold text-slate-800">
                Generar pedido global
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Selecciona el periodo para consolidar todos los pedidos.
            </p>

        </div>

        <form
            action="{{ route('admin.pedidos.globales.generar') }}"
            method="POST"
            class="flex flex-col md:flex-row md:items-end gap-4"
        >
            @csrf

            {{-- Fecha inicio --}}
            <div class="flex-1">

                <label
                    for="fecha_inicio"
                    class="block text-sm font-medium text-slate-700 mb-1"
                >
                    Fecha inicio
                </label>

                <input
                    type="date"
                    id="fecha_inicio"
                    name="fecha_inicio"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:border-slate-500 focus:ring-slate-500"
                >

            </div>


            {{-- Fecha fin --}}
            <div class="flex-1">

                <label
                    for="fecha_fin"
                    class="block text-sm font-medium text-slate-700 mb-1"
                >
                    Fecha fin
                </label>

                <input
                    type="date"
                    id="fecha_fin"
                    name="fecha_fin"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:border-slate-500 focus:ring-slate-500"
                >

            </div>


            {{-- Botón --}}
            <div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition"
                >
                    Generar pedido global
                </button>

            </div>

        </form>

    </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-100 border-b">

                    <tr>

                        <th class="text-left px-6 py-4 font-semibold text-slate-700">
                            Semana
                        </th>

                        <th class="text-center px-6 py-4 font-semibold text-slate-700">
                            Inicio
                        </th>

                        <th class="text-center px-6 py-4 font-semibold text-slate-700">
                            Fin
                        </th>

                        <th class="text-center px-6 py-4 font-semibold text-slate-700">
                            Estatus
                        </th>

                        <th class="text-right px-6 py-4 font-semibold text-slate-700">
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pedidosGlobales as $pedidoGlobal)

                        <tr class="border-b hover:bg-slate-50 transition">

                            {{-- Semana --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold text-slate-800">

                                    Semana de producción

                                </div>

                                <div class="text-xs text-slate-500 mt-1">

                                    {{ $pedidoGlobal->fecha_inicio->format('d/m/Y') }}
                                    -
                                    {{ $pedidoGlobal->fecha_fin->format('d/m/Y') }}

                                </div>

                            </td>


                            {{-- Inicio --}}
                            <td class="px-6 py-4 text-center">

                                {{ $pedidoGlobal->fecha_inicio->format('d/m/Y') }}

                            </td>


                            {{-- Fin --}}
                            <td class="px-6 py-4 text-center">

                                {{ $pedidoGlobal->fecha_fin->format('d/m/Y') }}

                            </td>


                            {{-- Estatus --}}
                            <td class="px-6 py-4 text-center">

                                @if($pedidoGlobal->estatus === 'abierto')

                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">

                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                        Abierto

                                    </span>

                                    @else

                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-700">

                                        <span class="w-2 h-2 rounded-full bg-gray-500"></span>

                                        Cerrado

                                    </span>

                                @endif

                            </td>


                            {{-- Acción --}}
                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('admin.pedidos.globales.show', $pedidoGlobal->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition"
                                >

                                    Ver reporte

                                    <span class="ml-2">
                                        →
                                    </span>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-lg font-medium text-slate-600">
                                    No hay reportes globales
                                </div>

                                <div class="text-sm text-slate-400 mt-1">
                                    Las semanas de producción aparecerán aquí.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection