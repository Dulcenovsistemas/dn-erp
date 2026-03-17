@extends('layouts.admin.app')

@section('title', 'Órdenes de venta')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Remisiones
        </h1>
        <p class="text-sm text-gray-500">
            Registro de Remisiones por sucursal
        </p>
    </div>

    <a href="{{ route('admin.remisiones.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nueva remision
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">#</th>
                <th class="px-6 py-4 text-left">Sucursal</th>
                <th class="px-6 py-4 text-left">Fecha</th>
                <th class="px-6 py-4 text-center">Estado</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($remisiones as $remision)
                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-3 font-medium">
                        #{{ $remision->id }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $remision->sucursal->nombre }}
                    </td>

                    <td class="px-6 py-3 text-gray-600">
                        {{ $remision->created_at->format('d/m/Y H:i') }}
                    </td>

                   <td class="px-6 py-3 text-center">

                        @if ($remision->estado === 'en_proceso')

                            <form action="{{ route('admin.remisiones.cambiarEstado', $remision) }}"

                                method="POST" 
                                class="mt-2">
                                @csrf
                                @method('PATCH')

                                <select name="estado"
                                        class="mt-1 text-xs rounded border-gray-300 focus:ring-2 focus:ring-blue-500"
                                        onchange="if(this.value === 'finalizada'){ 
                                            if(confirm('¿Seguro que deseas finalizar esta orden? Esto descontará inventario.')){
                                                this.form.submit();
                                            } else {
                                                this.value='en_proceso';
                                            }
                                        }">

                                    <option value="en_proceso" selected>En proceso</option>
                                    <option value="finalizada">Finalizar orden</option>

                                </select>
                            </form>

                        @elseif ($remision->estado === 'finalizada')

                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                Finalizada
                            </span>

                        @elseif ($remision->estado === 'cancelada')

                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                Cancelada
                            </span>

                        @else

                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                Desconocido
                            </span>

                        @endif

                    </td>


                    <td class="px-6 py-3 text-center flex justify-center gap-2">

                        <a href="{{ route('admin.remisiones.show', $remision)}}"
                            class="bi bi-eye">
                            👁
                        </a>


                        @if($remision->puedeEditar())

                            {{-- Botón editar --}}
                            <a href="{{ route('admin.remisiones.edit', $remision)}}"
                            class="text-blue-600 hover:text-blue-800">
                                ✏️
                            </a>

                            {{-- Botón eliminar --}}
                            <form action="{{ route('admin.remisiones.destroy', $remision) }}"
                                method="POST"
                                onsubmit="return confirm('¿Seguro que deseas eliminar esta orden?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:text-red-800">
                                    🗑️
                                </button>
                            </form>

                        @else

                            {{-- Solo mostrar iconos deshabilitados --}}
                            <span class="text-gray-400 cursor-not-allowed">✏️</span>
                            <span class="text-gray-400 cursor-not-allowed">🗑️</span>

                        @endif

                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                        No hay órdenes de venta registradas
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
