@extends('layouts.admin.app')

@section('title', 'Nueva categoría')

@section('content')

<form method="POST" action="{{ route('admin.categorias.store') }}">
    @csrf

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold">Nueva categoría</h2>
            <p class="text-sm text-gray-500 mt-1">
                Información básica de la categoría
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'nombre',
                'value' => old('nombre')
            ])

            @include('admin.partials.checkbox', [
                'label' => 'Categoría activa',
                'name' => 'activo',
                'checked' => true
            ])

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.categorias.index') }}"
               class="px-4 py-2 text-sm rounded-lg border bg-white">
                Cancelar
            </a>

            <button type="submit"
                class="px-4 py-2 text-sm rounded-lg bg-gray-900 text-white">
                Guardar
            </button>
        </div>

    </div>
</form>

@endsection
