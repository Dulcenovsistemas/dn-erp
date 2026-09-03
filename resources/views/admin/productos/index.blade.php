@extends('layouts.admin.app')

@section('title', 'Productos')

@section('content')

<div class="flex items-center justify-between mb-6">

    <h1 class="text-xl font-semibold">
        Productos
    </h1>

    <a
        href="{{ route('admin.productos.create') }}"
        class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm"
    >
        + Nuevo producto
    </a>

</div>


{{-- Burbujas de categorías --}}
<div class="flex gap-2 overflow-x-auto pb-4 mb-4">

    {{-- Todos --}}
    <a
        href="{{ route('admin.productos.index') }}"
        class="
            whitespace-nowrap
            px-4 py-2
            rounded-full
            text-sm font-medium
            transition
            {{ !request('categoria')
                ? 'bg-gray-900 text-white'
                : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
            }}
        "
    >
        Todos
    </a>


    {{-- Categorías --}}
    @foreach ($categorias as $categoria)

        <a
            href="{{ route('admin.productos.index', ['categoria' => $categoria->id]) }}"
            class="
                whitespace-nowrap
                px-4 py-2
                rounded-full
                text-sm font-medium
                transition
                {{ request('categoria') == $categoria->id
                    ? 'bg-gray-900 text-white'
                    : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
                }}
            "
        >
            {{ $categoria->nombre }}
        </a>

    @endforeach

</div>


{{-- Tabla de productos --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 border-b">

            <tr>

                <th class="px-6 py-4 text-left">
                    Producto
                </th>

                <th class="px-6 py-4 text-left">
                    Categoría
                </th>

                <th class="px-6 py-4 text-center">
                    Activo
                </th>

                <th class="px-6 py-4 text-right">
                    Acciones
                </th>

            </tr>

        </thead>


        <tbody class="divide-y">

            @forelse ($productos as $producto)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4 font-medium">
                        {{ $producto->nombre }}
                    </td>


                    <td class="px-6 py-4 text-gray-600">
                        {{ $producto->categoria->nombre }}
                    </td>


                    <td class="px-6 py-4 text-center">

                        @if ($producto->activo)

                            <span class="text-green-600 font-semibold">
                                ✔
                            </span>

                        @else

                            <span class="text-red-500 font-semibold">
                                ✖
                            </span>

                        @endif

                    </td>


                    <td class="px-6 py-4 text-right">

                        <a
                            href="{{ route('admin.productos.variantes.index', $producto) }}"
                            class="text-blue-600 mr-3"
                        >
                            Variantes
                        </a>


                        <a
                            href="{{ route('admin.productos.edit', $producto) }}"
                            class="text-orange-500 mr-3"
                        >
                            ✏️
                        </a>


                        <form
                            action="{{ route('admin.productos.destroy', $producto) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('¿Desactivar este producto?');"
                        >

                            @csrf
                            @method('DELETE')

                            <button class="text-gray-400 hover:text-red-600">
                                🗑️
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="4"
                        class="px-6 py-10 text-center text-gray-500"
                    >
                        No hay productos en esta categoría.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection