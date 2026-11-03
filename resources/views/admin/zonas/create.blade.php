
@extends('layouts.admin.app')

@section('title', 'Nueva zona')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.zonas.index') }}"
           class="text-sm text-gray-500 hover:text-gray-800">
            ← Volver a zonas
        </a>

        <h1 class="text-xl font-semibold text-gray-800 mt-3">
            Crear zona
        </h1>

        <p class="text-sm text-gray-500">
            Define la zona y selecciona sus días de entrega.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.zonas.store') }}"
          method="POST"
          class="bg-white rounded-xl shadow-sm p-6 space-y-6">
        @csrf

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                Nombre de la zona
            </label>

            <input type="text"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre') }}"
                   required
                   maxlength="255"
                   class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                   placeholder="Ej. Delicias">

            @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                Descripción
            </label>

            <textarea id="descripcion"
                      name="descripcion"
                      rows="3"
                      class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                      placeholder="Descripción opcional de la zona">{{ old('descripcion') }}</textarea>
        </div>

        <div>
            <p class="block text-sm font-medium text-gray-700 mb-3">
                Días de entrega
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($dias as $dia)
                    <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer hover:bg-emerald-50">
                        <input type="checkbox"
                               name="dias[]"
                               value="{{ $dia->id }}"
                               @checked(in_array($dia->id, old('dias', [])))
                               class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">

                        <span class="text-sm text-gray-700">
                            {{ $dia->nombre }}
                        </span>
                    </label>
                @endforeach
            </div>

            @error('dias')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @error('dias.*')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="activo" class="block text-sm font-medium text-gray-700 mb-2">
                Estado de la zona
            </label>

            <select id="activo"
                    name="activo"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                <option value="1" @selected(old('activo', '1') == '1')>
                    Activa
                </option>
                <option value="0" @selected(old('activo') === '0')>
                    Inactiva
                </option>
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('admin.zonas.index') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>

            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                Guardar zona
            </button>
        </div>
    </form>
</div>

@endsection
