@extends('layouts.admin.app')

@section('title', 'Movimientos de inventario')

@section('content')

<div class="max-w-6xl mx-auto">

    <h1 class="text-xl font-semibold mb-6">
        Movimientos – {{ $sucursal->nombre }}
    </h1>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3 text-center">Cantidad</th>
                    <th class="px-4 py-3 text-center">Fecha</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($movimientos as $mov)
                    <tr>
                        <td class="px-4 py-3">
                            {{ $mov->variante->producto->nombre }}
                        </td>
                        <td class="px-4 py-3">
                            {{ ucfirst($mov->tipo) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ $mov->cantidad }}
                        </td>
                        <td class="px-4 py-3 text-center text-gray-500">
                            {{ $mov->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            No hay movimientos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
