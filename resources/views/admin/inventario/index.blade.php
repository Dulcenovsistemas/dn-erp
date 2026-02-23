@extends('layouts.admin.app')

@section('title', 'Inventario')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-semibold">
                Inventario – {{ $sucursal->nombre }}
            </h1>
            <p class="text-sm text-gray-500">
                Gestión de stock y precios por producto
            </p>
        </div>

        <a href="{{ route('admin.sucursales.inventario.movimientos', $sucursal) }}"
           class="text-sm px-4 py-2 rounded-lg border bg-white">
            Ver movimientos
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-center">Precio</th>
                    <th class="px-4 py-3 text-center">Stock</th>
                    <th class="px-4 py-3 text-center">Activo</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($variantes as $variante)
                    @php
                        $item = $inventario[$variante->id] ?? null;
                    @endphp

                    <tr>
                        <td class="px-4 py-3 font-medium">
                            {{ $variante->producto->nombre }}
                            <div class="text-xs text-gray-500">
                                {{ $variante->nombre }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $variante->producto->categoria->nombre ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            ${{ number_format($item->pivot->precio ?? 0, 2) }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $item->pivot->stock ?? 0 }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {!! ($item && $item->pivot->activo)
                                ? '✅'
                                : '❌' !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
