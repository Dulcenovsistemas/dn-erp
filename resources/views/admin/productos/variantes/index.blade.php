@extends('layouts.admin.app')

@section('title', 'Variantes')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold">
            Variantes – {{ $producto->nombre }}
        </h1>
        <p class="text-sm text-gray-500">
            Categoría: {{ $producto->categoria->nombre }}
        </p>
    </div>

    <a href="{{ route('admin.productos.variantes.create', $producto) }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nueva variante
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Variante</th>
                <th class="px-6 py-4 text-left">SKU</th>
                <th class="px-6 py-4 text-center">Activo</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach ($variantes as $variante)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $variante->nombre }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $variante->sku ?? '—' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if ($variante->activo)
                            <span class="text-green-600 font-semibold">✔</span>
                        @else
                            <span class="text-red-500 font-semibold">✖</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.productos.variantes.edit', [$producto, $variante]) }}"
                           class="text-orange-500 mr-3">
                            ✏️
                        </a>

                        <form action="{{ route('admin.productos.variantes.destroy', [$producto, $variante]) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('¿Desactivar esta variante?');">
                            @csrf
                            @method('DELETE')

                            <button class="text-gray-400 hover:text-red-600">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    <a href="{{ route('admin.productos.index') }}"
       class="text-sm text-gray-600 hover:underline">
        ← Volver a productos
    </a>
</div>

@endsection
