@extends('layouts.admin.app')

@section('title', 'Nuevo Movimiento')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">
            Nuevo Movimiento de Inventario
        </h1>
        <p class="text-sm text-gray-500">
            Registrar entrada, salida o transferencia
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">

        <form action="{{ route('admin.movimientos.store') }}" method="POST">
            @csrf

            {{-- Tipo --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tipo de movimiento</label>
                <select name="tipo" id="tipo"
                        class="w-full border-gray-300 rounded-lg text-sm"
                        required>
                    <option value="">Seleccione...</option>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            {{-- Producto Variante --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Producto</label>
                <select name="producto_variante_id"
                        class="w-full border-gray-300 rounded-lg text-sm"
                        required>
                    <option value="">Seleccione...</option>
                    @foreach($variantes as $variante)
                        <option value="{{ $variante->id }}">
                            {{ $variante->producto->nombre }} - {{ $variante->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sucursal Origen --}}
            <div class="mb-4" id="origen-group">
                <label class="block text-sm font-medium mb-1">Sucursal Origen</label>
                <select name="sucursal_origen_id"
                        class="w-full border-gray-300 rounded-lg text-sm">
                    <option value="">Seleccione...</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sucursal Destino --}}
            <div class="mb-4" id="destino-group">
                <label class="block text-sm font-medium mb-1">Sucursal Destino</label>
                <select name="sucursal_destino_id"
                        class="w-full border-gray-300 rounded-lg text-sm">
                    <option value="">Seleccione...</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cantidad --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Cantidad</label>
                <input type="number"
                       name="cantidad"
                       min="1"
                       class="w-full border-gray-300 rounded-lg text-sm"
                       required>
            </div>

            {{-- Referencia --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Referencia</label>
                <input type="text"
                       name="referencia"
                       class="w-full border-gray-300 rounded-lg text-sm">
            </div>

            {{-- Observaciones --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Observaciones</label>
                <textarea name="observaciones"
                          rows="3"
                          class="w-full border-gray-300 rounded-lg text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.movimientos.index') }}"
                   class="px-4 py-2 text-sm bg-gray-200 rounded-lg">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 text-sm bg-gray-900 text-white rounded-lg">
                    Guardar movimiento
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Script para ocultar campos según tipo --}}
<script>
document.getElementById('tipo').addEventListener('change', function() {

    let tipo = this.value;
    let origen = document.getElementById('origen-group');
    let destino = document.getElementById('destino-group');

    if (tipo === 'entrada') {
        origen.style.display = 'none';
        destino.style.display = 'block';
    }

    else if (tipo === 'salida') {
        origen.style.display = 'block';
        destino.style.display = 'none';
    }

    else if (tipo === 'transferencia') {
        origen.style.display = 'block';
        destino.style.display = 'block';
    }

    else {
        origen.style.display = 'block';
        destino.style.display = 'block';
    }

});
</script>

@endsection
