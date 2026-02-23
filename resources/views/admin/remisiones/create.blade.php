@extends('layouts.admin.app')

@section('title', 'Nueva orden de venta')

@section('content')

<div class="max-w-xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">
            Nueva Remision
        </h1>
        <p class="text-sm text-gray-500">
            Selecciona la sucursal 
        </p>
    </div>

    <form method="POST" action="{{ route('admin.remisiones.store') }}">
        @csrf

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            {{-- Sucursal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Sucursal
                </label>
                <select name="sucursal_id"
                        required
                        class="w-full rounded-lg border-gray-300">
                    <option value="">Selecciona una sucursal</option>

                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">
                            {{ $sucursal->nombre }} – {{ $sucursal->ciudad }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nota opcional --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nota (opcional)
                </label>
                <textarea name="notas"
                          rows="3"
                          class="w-full rounded-lg border-gray-300"
                          placeholder="Referencia, cliente, observaciones..."></textarea>
            </div>

        </div>

        {{-- Acciones --}}
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 text-sm rounded-lg border text-gray-700 bg-white">
                Cancelar
            </a>

            <button type="submit"
                    class="px-5 py-2 text-sm rounded-lg bg-gray-900 text-white">
                Crear orden
            </button>
        </div>
    </form>

</div>

@endsection
