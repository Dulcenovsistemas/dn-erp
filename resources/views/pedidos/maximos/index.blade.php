@extends('layouts.admin.app')

@section('title', 'Pedidos máximos')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pedidos máximos
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Configura la cantidad máxima de piezas que puede generar cada zona.
            </p>
        </div>

    </div>


    {{-- Zonas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @foreach($zonas as $zona)

            @php
                $maximoZona = $pedidosMaximos
                    ->firstWhere('zona_id', $zona->id);
            @endphp

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Encabezado --}}
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">

                    <h2 class="font-semibold text-gray-800">
                        {{ $zona->nombre }}
                    </h2>

                </div>


                {{-- Contenido --}}
                <div class="p-5">

                    <p class="text-sm text-gray-500 mb-1">
                        Máximo de piezas
                    </p>

                    <div class="flex items-end justify-between">

                        <div>

                            @if($maximoZona)

                                <span class="text-3xl font-bold text-gray-800">
                                    {{ number_format($maximoZona->maximo) }}
                                </span>

                                <span class="text-sm text-gray-500 ml-1">
                                    piezas
                                </span>

                            @else

                                <span class="text-gray-400">
                                    Sin configurar
                                </span>

                            @endif

                        </div>


                        {{-- Botón --}}
                        <button
                            type="button"
                            onclick="abrirModal(
                                {{ $zona->id }},
                                '{{ addslashes($zona->nombre) }}',
                                {{ $maximoZona?->maximo ?? 0 }}
                            )"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition"
                        >
                            {{ $maximoZona ? 'Editar' : 'Configurar' }}
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL --}}
{{-- ========================================================= --}}

<div
    id="modalMaximo"
    class="fixed inset-0 z-50 hidden"
>

    {{-- Fondo --}}
    <div
        class="absolute inset-0 bg-black/40"
        onclick="cerrarModal()"
    ></div>


    {{-- Contenedor --}}
    <div class="relative flex items-center justify-center min-h-screen px-4">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden">

            {{-- Encabezado --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">

                <div>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Máximo de pedidos
                    </h2>

                    <p
                        id="modalZonaNombre"
                        class="text-sm text-gray-500 mt-1"
                    ></p>

                </div>

                <button
                    type="button"
                    onclick="cerrarModal()"
                    class="text-gray-400 hover:text-gray-600 text-xl"
                >
                    &times;
                </button>

            </div>


            {{-- Formulario --}}
            <form
                id="formMaximo"
                method="POST"
                action="{{ route('admin.pedidos.maximos.store') }}"
            >

                @csrf

                <input
                    type="hidden"
                    name="zona_id"
                    id="modalZonaId"
                >


                <div class="p-6">

                    <label
                        for="maximo"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Máximo de piezas
                    </label>

                    <input
                        type="number"
                        name="maximo"
                        id="modalMaximoInput"
                        min="0"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Ej. 150"
                    >

                    <p class="text-xs text-gray-500 mt-2">
                        Esta cantidad representa el máximo total de piezas que
                        puede generar la zona.
                    </p>

                </div>


                {{-- Botones --}}
                <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-200">

                    <button
                        type="button"
                        onclick="cerrarModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700"
                    >
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

function abrirModal(zonaId, zonaNombre, maximo)
{
    document.getElementById('modalZonaId').value = zonaId;

    document.getElementById('modalZonaNombre').textContent =
        zonaNombre;

    document.getElementById('modalMaximoInput').value =
        maximo;

    document.getElementById('modalMaximo').classList.remove('hidden');

    setTimeout(() => {
        document.getElementById('modalMaximoInput').focus();
    }, 100);
}


function cerrarModal()
{
    document.getElementById('modalMaximo').classList.add('hidden');
}

</script>

@endsection