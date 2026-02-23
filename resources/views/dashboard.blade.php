@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">
        Panel de control
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card Administración --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                Administración
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                Gestión general del sistema
            </p>

            <div class="space-y-2">

                <a href="{{ route('admin.sucursales.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Sucursales - Inventarios
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.usuarios.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Usuarios
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                 <a href="{{ route('admin.productos.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Productos
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.categorias.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Categorias
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

            </div>
        </div>

         {{-- Card Inventario --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                Inventario
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                Gestión general del inventarios
            </p>

            <div class="space-y-2">

                 <a href="{{ route('admin.productos.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Productos
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.categorias.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Categorias
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.movimientos.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Ajustes de inventario (Salidas-entradas)
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.categorias.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Traspasos
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

            </div>
        </div>


        {{-- Card Productos --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                Ordenes
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                Gestión general de ordenes de venta
            </p>

            <div class="space-y-2">

                <a href="{{ route('admin.ordenes.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Ventas
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.cortes.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Cortes
                    </span>
                    <span class="text-gray-400">→</span>
                </a>

                <a href="{{ route('admin.remisiones.index') }}"
                   class="flex items-center justify-between px-4 py-2 rounded-lg border hover:bg-gray-50 transition">
                    <span class="text-sm text-gray-700">
                        Remisiones
                    </span>
                    <span class="text-gray-400">→</span>
                </a>
            </div>
        </div>

    </div>

</div>

@endsection
