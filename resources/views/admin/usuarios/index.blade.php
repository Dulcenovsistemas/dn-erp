@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Usuarios</h1>

    <a href="{{ route('admin.usuarios.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
        + Nuevo usuario
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Nombre</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Rol</th>
                <th class="px-6 py-4 text-center">Activo</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach ($usuarios as $usuario)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">
                        {{ $usuario->name }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $usuario->email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $usuario->roles->first()->name ?? '—' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if ($usuario->activo)
                            <span class="text-green-600 font-semibold">✔</span>
                        @else
                            <span class="text-red-500 font-semibold">✖</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                           class="text-orange-500 mr-3">✏️</a>

                        
                        <form action="{{ route('admin.usuarios.destroy', $usuario) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('¿Seguro que deseas desactivar este usuario?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="text-gray-400 hover:text-red-600">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
