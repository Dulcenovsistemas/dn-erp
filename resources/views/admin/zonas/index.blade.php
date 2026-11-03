
@extends('layouts.admin.app')

@section('title', 'Zonas')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Administración de zonas
        </h1>

        <p class="text-sm text-gray-500">
            Gestiona las zonas y sus días de entrega.
        </p>
    </div>

    <a href="{{ route('admin.zonas.create') }}"
       class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm transition">
        + Nueva zona
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left">Zona</th>
                <th class="px-6 py-4 text-left">Descripción</th>
                <th class="px-6 py-4 text-left">Días de entrega</th>
                <th class="px-6 py-4 text-center">Estado</th>
                <th class="px-6 py-4 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($zonas as $zona)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $zona->nombre }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $zona->descripcion ?: 'Sin descripción' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($zona->dias as $dia)
                                <span class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs">
                                    {{ $dia->nombre }}
                                </span>
                            @empty
                                <span class="text-amber-600 text-xs">
                                    Sin días asignados
                                </span>
                            @endforelse
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($zona->activo)
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                                Activa
                            </span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-600 text-xs">
                                Inactiva
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.zonas.edit', $zona) }}"
                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500">
                        No hay zonas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">
    {{ $zonas->links() }}
</div>

@endsection
