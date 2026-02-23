@extends('layouts.admin.app')

@section('title', 'Editar sucursal')

@section('content')

<form method="POST" action="{{ route('admin.sucursales.update', $sucursal) }}">
    @csrf
    @method('PUT')

    <div class="max-w-3xl mx-auto">

        {{-- Card título --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                Editar sucursal
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Actualiza la información de la sucursal
            </p>
        </div>

        {{-- Campos --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'nombre',
                'value' => old('nombre', $sucursal->nombre)
            ])

            @include('admin.partials.input', [
                'label' => 'Ciudad',
                'name' => 'ciudad',
                'value' => old('ciudad', $sucursal->ciudad)
            ])

            @include('admin.partials.textarea', [
                'label' => 'Dirección',
                'name' => 'direccion',
                'value' => old('direccion', $sucursal->direccion)
            ])


            @include('admin.partials.checkbox', [
                'label' => 'Sucursal activa',
                'name' => 'activo',
                'checked' => old('activo', $sucursal->activo) == 1
            ])


        </div>

        {{-- Acciones --}}
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.sucursales.index') }}"
               class="px-4 py-2 text-sm rounded-lg border text-gray-700 bg-white">
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
