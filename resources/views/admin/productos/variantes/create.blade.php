@extends('layouts.admin.app')

@section('title', 'Nueva variante')

@section('content')

<form method="POST"
      action="{{ route('admin.productos.variantes.store', $producto) }}">
    @csrf

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold">
                Nueva variante – {{ $producto->nombre }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre de la variante',
                'name' => 'nombre',
                'value' => old('nombre')
            ])

            @include('admin.partials.input', [
                'label' => 'SKU (opcional)',
                'name' => 'sku',
                'value' => old('sku')
            ])

            @include('admin.partials.checkbox', [
                'label' => 'Variante activa',
                'name' => 'activo',
                'checked' => true
            ])

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.productos.variantes.index', $producto) }}"
               class="px-4 py-2 text-sm rounded-lg border bg-white">
                Cancelar
            </a>

            <button class="px-4 py-2 text-sm rounded-lg bg-gray-900 text-white">
                Guardar
            </button>
        </div>

    </div>
</form>

@endsection
