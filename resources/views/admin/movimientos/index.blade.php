@extends('layouts.admin.app')

@section('title', 'Órdenes de venta')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Traspasos
        </h1>
        <p class="text-sm text-gray-500">
            Registro ajustes de inventario por sucursal
        </p>
    </div>

    <a href="{{ route('admin.movimientos.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nuevo movimiento
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Fecha</th>
                <th class="px-6 py-4 text-left">Tipo</th>
                <th class="px-6 py-4 text-left">Origen</th>
                <th class="px-6 py-4 text-center">Destino</th>
                <th class="px-6 py-4 text-right">Producto</th>
                <th class="px-6 py-4 text-right">Cantidad</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        @forelse ($movimientos as $movimiento)
            <tr class="hover:bg-gray-50">

                <td class="px-6 py-3">
                    {{ $movimiento->created_at->format('d/m/Y H:i') }}
                </td>

                <td class="px-6 py-3">
                    <span class="px-2 py-1 text-xs rounded
                        @if($movimiento->tipo === 'entrada') bg-green-100 text-green-700
                        @elseif($movimiento->tipo === 'salida') bg-red-100 text-red-700
                        @else bg-blue-100 text-blue-700
                        @endif">
                        {{ ucfirst($movimiento->tipo) }}
                    </span>
                </td>

                <td class="px-6 py-3">
                    {{ $movimiento->sucursalOrigen->nombre ?? '-' }}
                </td>

                <td class="px-6 py-3">
                    {{ $movimiento->sucursalDestino->nombre ?? '-' }}
                </td>

                <td class="px-6 py-3">
                    {{ $movimiento->variante->producto->nombre ?? '' }}
                    -
                    {{ $movimiento->variante->nombre ?? '' }}
                </td>

                <td class="px-6 py-3 text-right font-semibold">
                    {{ $movimiento->cantidad }}
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                    No hay movimientos registrados
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

@endsection
