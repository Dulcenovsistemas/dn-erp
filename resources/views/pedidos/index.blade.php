@extends('layouts.admin.app')

@section('title', 'Pedidos')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Pedidos
        </h1>

        <p class="text-sm text-gray-500">
            Administración de pedidos por sucursal
        </p>
    </div>

    <a href="{{ route('admin.pedidos.create') }}"
       class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm transition">

        + Nuevo pedido

    </a>

</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 border-b">

            <tr>

                <th class="px-6 py-4 text-left">
                    Folio
                </th>

                <th class="px-6 py-4 text-left">
                    Sucursal
                </th>

                <th class="px-6 py-4 text-left">
                    Usuario
                </th>

                <th class="px-6 py-4 text-left">
                    Pedido
                </th>

                <th class="px-6 py-4 text-left">
                    Entrega
                </th>

                <th class="px-6 py-4 text-center">
                    Estado
                </th>

                <th class="px-6 py-4 text-center">
                    Acciones
                </th>

            </tr>

        </thead>

        <tbody class="divide-y">

            @forelse($pedidos as $pedido)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4 font-medium">
                        {{ $pedido->folio }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $pedido->sucursal->nombre }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $pedido->usuario->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $pedido->fecha_pedido->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $pedido->fecha_entrega->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 text-center">

                        @switch($pedido->estatus)

                            @case('BORRADOR')
                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs">
                                    Borrador
                                </span>
                            @break

                            @case('ENVIADO')
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">
                                    Enviado
                                </span>
                            @break

                            @case('PREPARACION')
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">
                                    Preparación
                                </span>
                            @break

                            @case('ENTREGADO')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                                    Entregado
                                </span>
                            @break

                            @case('CANCELADO')
                                <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">
                                    Cancelado
                                </span>
                            @break

                        @endswitch

                    </td>

                    <td class="px-6 py-4 flex justify-center gap-3">

                        <a href="{{ route('admin.pedidos.show',$pedido) }}"
                           class="hover:scale-110 transition">
                            👁
                        </a>

                        @if($pedido->estatus != 'ENTREGADO')

                            <a href="{{ route('admin.pedidos.edit',$pedido) }}"
                               class="hover:scale-110 transition">
                                ✏️
                            </a>

                            <form action="{{ route('admin.pedidos.destroy',$pedido) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar este pedido?')">

                                @csrf
                                @method('DELETE')

                                <button class="hover:scale-110 transition">
                                    🗑️
                                </button>

                            </form>

                        @else

                            <span class="text-gray-300">
                                ✏️
                            </span>

                            <span class="text-gray-300">
                                🗑️
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7"
                        class="py-10 text-center text-gray-500">

                        No existen pedidos registrados.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-5">
    {{ $pedidos->links() }}
</div>

@endsection