@extends('layouts.admin.app')

@section('title', 'Editar categoría')

@section('content')

<form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
    @csrf
    @method('PUT')

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold">Editar categoría</h2>
            <p class="text-sm text-gray-500 mt-1">
                Actualiza la información de la categoría
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'nombre',
                'value' => old('nombre', $categoria->nombre)
            ])

            @include('admin.partials.checkbox', [
                'label' => 'Categoría activa',
                'name' => 'activo',
                'checked' => old('activo', $categoria->activo)
            ])

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.categorias.index') }}"
               class="px-4 py-2 text-sm rounded-lg border bg-white">
                Cancelar
            </a>

            <button type="submit"
                class="px-4 py-2 text-sm rounded-lg bg-gray-900 text-white">
                Guardar cambios
            </button>
        </div>

    </div>
</form>

@endsection
