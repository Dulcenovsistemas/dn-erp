@extends('layouts.admin.app')

@section('title', 'Productos por zona')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold">Productos por zona</h1>
        <p class="text-sm text-gray-500 mt-1">
            Selecciona los pasteles disponibles para cada zona.
        </p>
    </div>

    <a href="{{ route('admin.productos.index') }}"
       class="px-4 py-2 rounded-lg text-sm border bg-white hover:bg-gray-50">
        Volver a productos
    </a>
</div>

@if (session('success'))
    <div class="bg-green-50 text-green-700 rounded-lg p-3 mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

@if ($zonas->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-6 text-gray-500">
        No hay zonas registradas.
    </div>
@else

    <form method="GET"
          action="{{ route('admin.productos-zona.index') }}"
          class="bg-white rounded-xl shadow-sm p-5 mb-5">

        <label for="zona_id" class="block text-sm font-medium mb-2">
            Zona
        </label>

        <div class="flex flex-col sm:flex-row gap-3">
            <select
                id="zona_id"
                name="zona_id"
                class="w-full sm:max-w-md rounded-lg border-gray-300"
            >
                @foreach ($zonas as $zona)
                    <option
                        value="{{ $zona->id }}"
                        @selected($zonaSeleccionada?->id == $zona->id)
                    >
                        {{ $zona->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm bg-gray-900 text-white">
                Ver zona
            </button>
        </div>
    </form>

    @if ($zonaSeleccionada)
        <form method="POST"
              action="{{ route('admin.productos-zona.update', $zonaSeleccionada) }}">

            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-5 border-b flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold">
                            Pasteles de {{ $zonaSeleccionada->nombre }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Marca los productos que estarán disponibles en esta zona.
                        </p>
                    </div>
                </div>

                @if ($productos->isEmpty())
                    <div class="p-6 text-sm text-gray-500">
                        No hay productos registrados.
                    </div>
                @else
                    <div class="divide-y">
                        @foreach ($productos as $producto)
                            <label class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="producto_ids[]"
                                    value="{{ $producto->id }}"
                                    @checked(in_array($producto->id, $productosAsignados))
                                    class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                >

                                <span class="flex-1">
                                    <span class="block text-sm font-medium">
                                        {{ $producto->nombre }}
                                    </span>

                                    <span class="block text-xs text-gray-500">
                                        {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
                                    </span>
                                </span>

                                @unless ($producto->activo)
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        Inactivo
                                    </span>
                                @endunless
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex justify-end mt-5">
                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-700"
                >
                    Guardar asignación
                </button>
            </div>
        </form>
    @endif
@endif

@endsection