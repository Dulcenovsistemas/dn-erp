@extends('layouts.admin.app')

@section('title', 'Cortes')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Cortes de caja
        </h1>
        <p class="text-sm text-gray-500">
            Registro de pagos por orden finalizada
        </p>
    </div>

    <button onclick="abrirModal()"
        class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nuevo corte
    </button>


</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Orden</th>
                <th class="px-6 py-4 text-left">Sucursal</th>
                <th class="px-6 py-4 text-left">Fecha</th>
                <th class="px-6 py-4 text-right">Efectivo</th>
                <th class="px-6 py-4 text-right">Tarjeta</th>
                <th class="px-6 py-4 text-right">Total</th>
                <th class="px-6 py-4 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($cortes as $ordenId => $pagos)

                @php
                    $orden = $pagos->first()->orden;
                    $efectivo = $pagos->where('metodo', 'efectivo')->sum('monto');
                    $tarjeta  = $pagos->where('metodo', 'tarjeta')->sum('monto');
                @endphp

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-3 font-medium">
                        {{ $orden->folio }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $orden->sucursal->nombre }}
                    </td>

                    <td class="px-6 py-3 text-gray-600">
                        {{ $orden->updated_at->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-6 py-3 text-right text-green-600 font-semibold">
                        ${{ number_format($efectivo, 2) }}
                    </td>

                    <td class="px-6 py-3 text-right text-blue-600 font-semibold">
                        ${{ number_format($tarjeta, 2) }}
                    </td>

                    <td class="px-6 py-3 text-right font-bold">
                        ${{ number_format($efectivo + $tarjeta, 2) }}
                    </td>

                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('admin.cortes.show', $orden) }}"
                           class="text-gray-600 hover:text-gray-800">
                            👁
                        </a>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                        No hay cortes registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

{{-- MODAL CORTE --}}
<div id="modalCorte"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6 relative">

        <button onclick="cerrarModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✖
        </button>

        <h2 class="text-lg font-semibold mb-4">
            Registrar nuevo corte
        </h2>

        <form method="POST" action="{{ route('admin.cortes.store') }}">
            @csrf

            {{-- Seleccionar orden --}}
            <div class="mb-3">
                <label class="block text-sm mb-1">Orden finalizada</label>
                <select name="orden_venta_id"
                        class="w-full border rounded-lg px-3 py-2 text-sm"
                        required>
                    <option value="">Seleccionar orden</option>

                    @foreach(\App\Models\OrdenVenta::where('estado','finalizada')
                        ->whereDoesntHave('pagos')->get() as $ordenDisponible)

                        <option value="{{ $ordenDisponible->id }}">
                            {{ $ordenDisponible->folio }}
                            - ${{ number_format($ordenDisponible->total,2) }}
                        </option>

                    @endforeach
                </select>
            </div>

            {{-- Efectivo --}}
            <div class="mb-3">
                <label class="block text-sm mb-1">Efectivo</label>
                <input type="number"
                       step="0.01"
                       name="efectivo"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            {{-- Tarjeta --}}
            <div class="mb-4">
                <label class="block text-sm mb-1">Tarjeta</label>
                <input type="number"
                       step="0.01"
                       name="tarjeta"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <button class="bg-green-600 text-white w-full py-2 rounded-lg text-sm hover:bg-green-700">
                Guardar corte
            </button>
        </form>

    </div>
</div>
<script>
    function abrirModal() {
        document.getElementById('modalCorte').classList.remove('hidden');
        document.getElementById('modalCorte').classList.add('flex');
    }

    function cerrarModal() {
        document.getElementById('modalCorte').classList.add('hidden');
        document.getElementById('modalCorte').classList.remove('flex');
    }
</script>
