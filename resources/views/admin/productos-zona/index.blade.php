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
    @php
        $productosPorCategoria = $productos
            ->groupBy(fn ($producto) => $producto->categoria?->nombre ?? 'Sin categoría')
            ->sortKeys();
    @endphp

    <div class="p-5 space-y-5">
        @foreach ($productosPorCategoria as $nombreCategoria => $productosCategoria)
            <section class="overflow-hidden rounded-xl border border-gray-200">

                <div class="flex items-center justify-between bg-gray-100 px-4 py-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            class="check-todos-categoria rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                        >

                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">
                            {{ $nombreCategoria }}
                        </h3>
                    </label>

                    <span class="rounded-full bg-white px-2.5 py-1 text-xs font-medium text-gray-600">
                        {{ $productosCategoria->count() }} productos
                    </span>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach ($productosCategoria->sortBy('nombre') as $producto)
                        <label class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50">
                            <input
                                type="checkbox"
                                name="producto_ids[]"
                                value="{{ $producto->id }}"
                                @checked(in_array($producto->id, $productosAsignados))
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                            >

                            <span class="flex-1 text-sm font-medium text-gray-800">
                                {{ $producto->nombre }}
                            </span>

                            @unless ($producto->activo)
                                <span class="rounded bg-gray-100 px-2 py-1 text-xs text-gray-500">
                                    Inactivo
                                </span>
                            @endunless
                        </label>
                    @endforeach
                </div>
            </section>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.check-todos-categoria').forEach(checkCategoria => {
        const categoria = checkCategoria.closest('section');

        const productos = categoria.querySelectorAll(
            'input[type="checkbox"][name="producto_ids[]"]'
        );

        function actualizarCheckCategoria() {
            const seleccionados = [...productos].filter(check => check.checked).length;

            checkCategoria.checked =
                productos.length > 0 && seleccionados === productos.length;

            checkCategoria.indeterminate =
                seleccionados > 0 && seleccionados < productos.length;
        }

        checkCategoria.addEventListener('change', function () {
            productos.forEach(check => {
                check.checked = checkCategoria.checked;
            });

            checkCategoria.indeterminate = false;
        });

        productos.forEach(check => {
            check.addEventListener('change', actualizarCheckCategoria);
        });

        actualizarCheckCategoria();
    });
});
</script>