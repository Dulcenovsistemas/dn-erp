@extends('layouts.admin.app')

@section('title', 'Editar variante')

@section('content')

<form method="POST"
      action="{{ route('admin.productos.variantes.update', [$producto, $variante]) }}">
    @csrf
    @method('PUT')

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold">
                Editar variante – {{ $producto->nombre }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre de la variante',
                'name' => 'nombre',
                'value' => old('nombre', $variante->nombre)
            ])

            @include('admin.partials.input', [
                'label' => 'SKU (opcional)',
                'name' => 'sku',
                'value' => old('sku', $variante->sku)
            ])

            @include('admin.partials.checkbox', [
                'label' => 'Variante activa',
                'name' => 'activo',
                'checked' => old('activo', $variante->activo)
            ])

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.productos.variantes.index', $producto) }}"
               class="px-4 py-2 text-sm rounded-lg border bg-white">
                Cancelar
            </a>

            <button class="px-4 py-2 text-sm rounded-lg bg-gray-900 text-white">
                Guardar cambios
            </button>
        </div>

    </div>
</form>

@endsection

