<div style="background:red; height:100vh; width:100vw;">
    TEST POS
</div>

@extends('layouts.admin.pos')

@section('content')
<div class="flex flex-col h-full w-full overflow-hidden">

    {{-- ================= BODY ================= --}}
    <div class="flex-1 grid grid-cols-12 overflow-hidden">

        {{-- ================= IZQUIERDA ================= --}}
        <div class="col-span-8 flex flex-col p-6 gap-4 overflow-hidden">

            {{-- BUSCADOR --}}
            <input
                type="text"
                placeholder="Comienza a escribir..."
                class="w-full border rounded px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500"
            >

            {{-- TABLA (SCROLL SOLO AQUÍ) --}}
            <div class="flex-1 overflow-y-auto border rounded bg-white">

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-gray-600">
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Status</th>
                            <th class="px-3 py-2 text-left">Producto</th>
                            <th class="px-3 py-2 text-center">Cantidad</th>
                            <th class="px-3 py-2 text-right">Precio Unit.</th>
                            <th class="px-3 py-2 text-right">Desc.</th>
                            <th class="px-3 py-2 text-right">Total</th>
                            <th class="px-3 py-2 text-left">Notas</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orden->detalles as $detalle)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $detalle->id }}</td>

                                <td class="px-3 py-2">
                                    <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">
                                        Activo
                                    </span>
                                </td>

                                <td class="px-3 py-2">
                                    {{ $detalle->productoVariante->producto->nombre }}
                                </td>

                                <td class="px-3 py-2 text-center">
                                    {{ $detalle->cantidad }}
                                </td>

                                <td class="px-3 py-2 text-right">
                                    ${{ number_format($detalle->precio_unitario, 2) }}
                                </td>

                                <td class="px-3 py-2 text-right">$0.00</td>

                                <td class="px-3 py-2 text-right font-semibold">
                                    ${{ number_format($detalle->total, 2) }}
                                </td>

                                <td class="px-3 py-2 text-gray-400">—</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-gray-400">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        {{-- ================= DERECHA (ASIDE REAL) ================= --}}
        <div class="col-span-4 border-l bg-white flex flex-col overflow-hidden">

            {{-- INFO (SCROLLEA SI CRECE) --}}
            <div class="p-6 space-y-4 text-sm overflow-y-auto">

                <div>
                    <label class="text-gray-500 text-xs">Sucursal</label>
                    <div class="font-medium">{{ $orden->sucursal->nombre }}</div>
                </div>

                <div>
                    <label class="text-gray-500 text-xs">Folio</label>
                    <div class="font-mono">{{ $orden->folio }}</div>
                </div>

                <div>
                    <label class="text-gray-500 text-xs">Estado</label>
                    <select class="w-full border rounded px-3 py-2 text-sm">
                        <option>En Proceso</option>
                        <option>Completado</option>
                    </select>
                </div>

                <div>
                    <label class="text-gray-500 text-xs">Fecha</label>
                    <div>{{ $orden->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <div>
                    <label class="text-gray-500 text-xs">Fecha de Entrega</label>
                    <input
                        type="date"
                        class="w-full border rounded px-3 py-2 text-sm"
                        value="{{ optional($orden->fecha_entrega)->format('Y-m-d') }}"
                    >
                </div>

                <div>
                    <label class="text-gray-500 text-xs">Notas</label>
                    <textarea class="w-full border rounded px-3 py-2 text-sm" rows="3"></textarea>
                </div>

            </div>

            {{-- TOTAL FIJO ABAJO --}}
            <div class="shrink-0 bg-gray-900 text-white p-6 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>$1,485.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Descuento</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between border-t border-gray-700 pt-3 text-lg font-semibold">
                    <span>Total</span>
                    <span>$1,485.00</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
