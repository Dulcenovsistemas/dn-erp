@extends('layouts.admin.app')

@section('title', 'Sucursales')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Sucursales</h1>

    <a href="{{ route('admin.sucursales.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nueva sucursal
    </a>
    

</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Nombre</th>
                <th class="px-6 py-4 text-left">Dirección</th>
                <th class="px-6 py-4 text-left">Ciudad</th>
                <th class="px-6 py-4 text-left">Activo</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach ($sucursales as $sucursal)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $sucursal->nombre }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $sucursal->direccion }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $sucursal->ciudad }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if ($sucursal->activo)
                            <span class="text-green-600 font-semibold">✔</span>
                        @else
                            <span class="text-red-500 font-semibold">✖</span>
                        @endif
                    </td>


                    <td class="px-6 py-4 text-right whitespace-nowrap">

                        {{-- Inventario --}}
                        <a href="{{ route('admin.sucursales.inventario.edit', $sucursal) }}"
                        class="text-blue-600 hover:text-blue-800 mr-3"
                        title="Inventario">
                            📦
                        </a>

                        {{-- Editar --}}
                        <a href="{{ route('admin.sucursales.edit', $sucursal) }}"
                        class="text-orange-500 hover:text-orange-700 mr-3"
                        title="Editar sucursal">
                            ✏️
                        </a>

                        {{-- Eliminar --}}
                        <form action="{{ route('admin.sucursales.destroy', $sucursal) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('¿Seguro que deseas eliminar esta sucursal?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-gray-400 hover:text-red-600"
                                    title="Eliminar">
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

