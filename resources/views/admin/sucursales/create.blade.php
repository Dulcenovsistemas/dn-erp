@extends('layouts.admin.app')

@section('title', 'Nueva sucursal')

@section('content')

<form method="POST" action="{{ route('admin.sucursales.store') }}">
    @csrf

    <div class="max-w-3xl mx-auto">

        {{-- Card título --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                Nueva sucursal
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Información básica de la sucursal
            </p>
        </div>

        {{-- Campos --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'nombre',
                'value' => old('nombre')
            ])

            @include('admin.partials.input', [
                'label' => 'Ciudad',
                'name' => 'ciudad',
                'value' => old('ciudad')
            ])

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Zona
                </label>

                <select
                    name="zona_id"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">

                    <option value="">Seleccione una zona</option>

                    @foreach($zonas as $zona)

                        <option
                            value="{{ $zona->id }}"
                            {{ old('zona_id') == $zona->id ? 'selected' : '' }}>

                            {{ $zona->nombre }}

                        </option>

                    @endforeach

                </select>

                @error('zona_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @include('admin.partials.textarea', [
                'label' => 'Dirección',
                'name' => 'direccion',
                'value' => old('direccion')
            ])

            @include('admin.partials.checkbox', [
                'label' => 'Sucursal activa',
                'name' => 'activo',
                'checked' => true
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
                Guardar
            </button>
        </div>

    </div>
</form>


@endsection
