@extends('layouts.admin.app')

@section('title', 'Editar usuario')

@section('content')

<form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
    @csrf
    @method('PUT')

    <div class="max-w-3xl mx-auto">

        {{-- Card título --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                Editar usuario
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Actualiza la información del usuario
            </p>
        </div>

        {{-- Campos --}}
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-5">

            {{-- Nombre --}}
            @include('admin.partials.input', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name', $usuario->name)
            ])

            {{-- Email --}}
            @include('admin.partials.input', [
                'label' => 'Correo electrónico',
                'name' => 'email',
                'type' => 'email',
                'value' => old('email', $usuario->email)
            ])

            {{-- Password (opcional) --}}
            @include('admin.partials.input', [
                'label' => 'Contraseña (opcional)',
                'name' => 'password',
                'type' => 'password'
            ])

            <p class="text-xs text-gray-500">
                Deja este campo vacío si no deseas cambiar la contraseña.
            </p>

            {{-- Rol --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Rol
                </label>

                <select name="role"
                    class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">Selecciona un rol</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role', $usuario->roles->first()?->name) === $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>

                @error('role')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Sucursales asignadas
                </label>

                <div class="grid grid-cols-2 gap-3">
                    @foreach ($sucursales as $sucursal)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox"
                                name="sucursales[]"
                                value="{{ $sucursal->id }}"
                                class="rounded border-gray-300"
                                {{ in_array($sucursal->id, old(
                                        'sucursales',
                                        $usuario->sucursales->pluck('id')->toArray()
                                )) ? 'checked' : '' }}>
                            {{ $sucursal->nombre }}
                        </label>
                    @endforeach
                </div>
            </div>


            {{-- Activo --}}
            @include('admin.partials.checkbox', [
                'label' => 'Usuario activo',
                'name' => 'activo',
                'checked' => old('activo', $usuario->activo) == 1
            ])

        </div>

        {{-- Acciones --}}
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.usuarios.index') }}"
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
