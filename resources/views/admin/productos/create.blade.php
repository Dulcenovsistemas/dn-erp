@extends('layouts.admin.app')

@section('title', 'Nuevo producto')

@section('content')

<form method="POST" action="{{ route('admin.productos.store') }}">
    @csrf

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold">Nuevo producto</h2>
            <p class="text-sm text-gray-500 mt-1">
                Información básica del producto
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Categoría
                </label>

                <select name="categoria_id"
                    class="w-full rounded-lg border-gray-300">
                    <option value="">Selecciona una categoría</option>

                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'nombre',
                'value' => old('nombre')
            ])

            <div>
                <label class="block text-sm font-medium mb-1">
                    Descripción
                </label>
                <textarea name="descripcion"
                    class="w-full rounded-lg border-gray-300"
                    rows="3">{{ old('descripcion') }}</textarea>
            </div>

            @include('admin.partials.checkbox', [
                'label' => 'Producto activo',
                'name' => 'activo',
                'checked' => true
            ])

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.productos.index') }}"
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
