@extends('layouts.admin.app')

@section('title', 'Nuevo Pedido')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-xl font-semibold text-gray-800">
                Nuevo Pedido
            </h1>

            <p class="text-sm text-gray-500">
                Captura de pedido por sucursal
            </p>

        </div>

        <a href="{{ route('admin.pedidos.index') }}"
            class="text-gray-600 hover:text-black">

            ← Regresar

        </a>

    </div>

    <form action="{{ route('admin.pedidos.store') }}" method="POST">

        @csrf

        {{-- Datos generales --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <div class="grid grid-cols-3 gap-6">

               <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Sucursal
        </label>

        <select
            name="sucursal_id"
            id="sucursal_id"
            class="w-full rounded-lg border-gray-300"
            required>

            <option value="">Seleccione una sucursal</option>

            @foreach(auth()->user()->sucursales as $sucursal)
                <option value="{{ $sucursal->id }}">
                    {{ $sucursal->nombre }}
                </option>
            @endforeach

        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fecha del pedido
        </label>

        <input
            type="text"
            class="w-full rounded-lg bg-gray-100"
            value="{{ now()->format('d/m/Y') }}"
            readonly>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Fecha de entrega
        </label>

        <input
            id="fecha_entrega"
            type="text"
            class="w-full rounded-lg bg-gray-100"
            value="Seleccione una sucursal"
            readonly>
    </div>

</div>
                <div>

                    <label class="text-sm font-medium block mb-2">
                        Fecha Pedido
                    </label>

                    <input
                        class="w-full rounded-lg bg-gray-100 border-gray-300"
                        readonly
                        value="{{ now()->format('d/m/Y') }}">

                </div>

                <div>

                    <label class="text-sm font-medium block mb-2">
                        Fecha Entrega
                    </label>

                    <input
                        class="w-full rounded-lg bg-gray-100 border-gray-300"
                        readonly
                        value="Se calculará automáticamente">

                </div>

            </div>

            <div class="mt-6">

                <label class="text-sm font-medium block mb-2">
                    Observaciones
                </label>

                <textarea
                    rows="3"
                    name="observaciones"
                    class="w-full rounded-lg border-gray-300"></textarea>

            </div>

        </div>

        {{-- Productos --}}

        @foreach($categorias as $categoria)

            <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">

                <div class="bg-gray-100 px-6 py-3 border-b">

                    <h2 class="font-semibold text-gray-800 uppercase">

                        {{ $categoria->nombre }}

                    </h2>

                </div>

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left">
                                Producto
                            </th>

                            <th class="px-6 py-3 text-center w-40">
                                Cantidad
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @php($totalCategoria = 0)

                        @foreach($categoria->productos as $producto)

                            <tr class="border-t hover:bg-gray-50">

                                <td class="px-6 py-3">

                                    {{ $producto->nombre }}

                                </td>

                                <td class="px-6 py-3 text-center">

                                    <input
                                        type="number"
                                        min="0"
                                        value="0"
                                        data-categoria="{{ $categoria->id }}"
                                        class="cantidad w-20 rounded border-gray-300 text-center"
                                        name="productos[{{ $producto->id }}]">

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr class="bg-gray-50 font-semibold">

                            <td class="px-6 py-3 text-right">

                                Total {{ $categoria->nombre }}

                            </td>

                            <td class="px-6 py-3 text-center">

                                <span id="total_categoria_{{ $categoria->id }}">

                                    0

                                </span>

                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        @endforeach

        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="flex justify-between items-center">

                <div>

                    <h3 class="font-semibold text-lg">

                        Total del Pedido

                    </h3>

                </div>

                <div class="text-3xl font-bold text-blue-600">

                    <span id="totalPedido">

                        0

                    </span>

                    piezas

                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <button
                type="submit"
                name="accion"
                value="borrador"
                class="px-6 py-3 rounded-lg bg-gray-600 text-white">

                Guardar borrador

            </button>

            <button
                type="submit"
                name="accion"
                value="enviar"
                class="px-6 py-3 rounded-lg bg-gray-900 text-white">

                Enviar pedido

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

    calcular();

    document.querySelectorAll('.cantidad').forEach(input=>{

        input.addEventListener('input', calcular);

    });

});

function calcular(){

    let totalGeneral = 0;

    let categorias = {};

    document.querySelectorAll('.cantidad').forEach(input=>{

        let cantidad = parseInt(input.value) || 0;

        let categoria = input.dataset.categoria;

        if(!categorias[categoria]){

            categorias[categoria]=0;

        }

        categorias[categoria]+=cantidad;

        totalGeneral+=cantidad;

    });

    Object.keys(categorias).forEach(function(id){

        document.getElementById('total_categoria_'+id).innerHTML = categorias[id];

    });

    document.getElementById('totalPedido').innerHTML = totalGeneral;

}

</script>

@endpush