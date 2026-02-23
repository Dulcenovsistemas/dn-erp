@extends('layouts.admin.app')

@section('title', 'Categorías')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Categorías</h1>

    <a href="{{ route('admin.categorias.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nueva categoría
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Nombre</th>
                <th class="px-6 py-4 text-center">Activo</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach ($categorias as $categoria)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $categoria->nombre }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if ($categoria->activo)
                            <span class="text-green-600 font-semibold">✔</span>
                        @else
                            <span class="text-red-500 font-semibold">✖</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.categorias.edit', $categoria) }}"
                           class="text-orange-500 mr-3">
                            ✏️
                        </a>

                        <form action="{{ route('admin.categorias.destroy', $categoria) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('¿Desactivar esta categoría?');">
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

@endsection
