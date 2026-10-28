
@extends('layouts.admin.app')

@section('title', 'Panel de control')

@section('content')

<div class="mx-auto max-w-7xl space-y-8 pb-8">

    {{-- ENCABEZADO --}}
    <section class="overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
        <div class="flex flex-col gap-6 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    SISTEMA DE GESTIÓN INTERNA
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Panel de control
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    Bienvenido a Dulce Noviembre Pedidos.
                    Desde aquí puedes acceder a las herramientas de gestión
                    disponibles para tu cuenta.
                </p>
            </div>

            <div class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.7"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs text-gray-500">
                        Sesión iniciada
                    </p>

                    <p class="mt-1 truncate text-sm font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="mt-0.5 text-xs text-emerald-700">
                        Acceso al sistema
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- TÍTULO DE LOS MÓDULOS --}}
    <section>
        <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Módulos del sistema
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Selecciona el área que deseas administrar.
                </p>
            </div>

            <span class="mt-2 text-xs font-medium text-gray-400 sm:mt-0">
                Dulce Noviembre · Pedidos
            </span>
        </div>


        {{-- CUADRÍCULA DE MÓDULOS --}}

        
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">


            {{-- ADMINISTRACIÓN --}}
            @hasanyrole('admin')
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">

                <div class="border-b border-gray-100 p-5 sm:p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6V4m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m-6 4v-2m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m12-6v-2m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-gray-900">
                                Administración
                            </h3>

                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Configuración y gestión general del sistema.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 p-4 sm:p-5">

                    <a href="{{ route('admin.sucursales.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-500 group-hover/enlace:bg-white group-hover/enlace:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7"
                                     aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 21h18M5 21V7l8-4v18M13 10h6v11M8 9h1m-1 4h1m-1 4h1m7-3h1m-1 3h1"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-gray-700">
                                Sucursales e inventarios
                            </span>
                        </div>

                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    @hasanyrole('admin')
                    <a href="{{ route('admin.usuarios.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-500 group-hover/enlace:bg-white group-hover/enlace:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7"
                                     aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m12-13a4 4 0 1 1-8 0 4 4 0 0 1 8 0m4 13v-2a4 4 0 0 0-3-3.87M17 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-gray-700">
                                Usuarios
                            </span>
                        </div>

                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.productos.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-500 group-hover/enlace:bg-white group-hover/enlace:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7"
                                     aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m12 3 9 5-9 5-9-5 9-5Zm-9 9 9 5 9-5m-18 4 9 5 9-5"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-gray-700">
                                Productos
                            </span>
                        </div>

                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.categorias.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-500 group-hover/enlace:bg-white group-hover/enlace:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7"
                                     aria-hidden="true">
                                    <rect x="4" y="4" width="6" height="6" rx="1"/>
                                    <rect x="14" y="4" width="6" height="6" rx="1"/>
                                    <rect x="4" y="14" width="6" height="6" rx="1"/>
                                    <rect x="14" y="14" width="6" height="6" rx="1"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-gray-700">
                                Categorías
                            </span>
                        </div>

                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>
                    @endhasanyrole

                </div>
            </article>
            @endhasanyrole


            {{-- INVENTARIO --}}
            @hasanyrole('admin')
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">

                <div class="border-b border-gray-100 p-5 sm:p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 7h18v13H3zM3 7l3-4h12l3 4M9 12h6"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-gray-900">
                                Inventario
                            </h3>

                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Productos, existencias y movimientos.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 p-4 sm:p-5">

                    <a href="{{ route('admin.productos.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Productos
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.categorias.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Categorías
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.movimientos.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Ajustes de inventario
                            <span class="mt-1 block text-xs font-normal text-gray-400">
                                Entradas y salidas
                            </span>
                        </span>
                        <span class="shrink-0 text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    {{-- TODO: sustituir por la ruta real de traspasos cuando esté confirmada --}}
                    <a href="{{ route('admin.categorias.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Traspasos
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                </div>
            </article>
            @endhasanyrole


            {{-- ÓRDENES DE VENTA --}}
            @hasanyrole('admin')
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">

                <div class="border-b border-gray-100 p-5 sm:p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                                <circle cx="10" cy="21" r="1"/>
                                <circle cx="18" cy="21" r="1"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-gray-900">
                                Órdenes de venta
                            </h3>

                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Operación de ventas y seguimiento.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 p-4 sm:p-5">

                    <a href="{{ route('admin.ordenes.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div>
                            <span class="text-sm font-medium text-gray-700">
                                Ventas
                            </span>
                            <span class="mt-1 block text-xs text-gray-400">
                                Órdenes de venta
                            </span>
                        </div>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.cortes.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div>
                            <span class="text-sm font-medium text-gray-700">
                                Cortes
                            </span>
                            <span class="mt-1 block text-xs text-gray-400">
                                Control de cortes
                            </span>
                        </div>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    <a href="{{ route('admin.remisiones.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div>
                            <span class="text-sm font-medium text-gray-700">
                                Remisiones
                            </span>
                            <span class="mt-1 block text-xs text-gray-400">
                                Consulta y seguimiento
                            </span>
                        </div>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                </div>
            </article>
            @endhasanyrole


            {{-- PEDIDOS --}}
            @hasanyrole('admin|pedidos|gerente')
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">

                <div class="border-b border-gray-100 p-5 sm:p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 12h6m-6 4h6"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-gray-900">
                                Pedidos
                            </h3>

                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Administración y seguimiento de pedidos.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 p-4 sm:p-5">

                    <a href="{{ route('admin.pedidos.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Pedidos
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>

                    

                    @hasanyrole('admin|pedidos')

                    <a href="{{ route('admin.pedidos.maximos.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Pedidos máximos
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>


                    <a href="{{ route('admin.pedidos.globales.index') }}"
                       class="group/enlace flex items-center justify-between gap-3 rounded-xl border border-gray-100 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="text-sm font-medium text-gray-700">
                            Pedidos globales
                        </span>
                        <span class="text-gray-400 transition group-hover/enlace:translate-x-1 group-hover/enlace:text-emerald-700">→</span>
                    </a>
                    @endhasanyrole

                </div>
            </article>
            @endhasanyrole

        </div>
    </section>

    {{-- PIE DEL PANEL --}}
    <footer class="flex flex-col gap-2 border-t border-gray-200 pt-5 text-xs text-gray-400 sm:flex-row sm:items-center sm:justify-between">
        <p>
            Dulce Noviembre <span class="font-semibold text-emerald-700">· Pedidos</span>
        </p>

        <p>
            Sistema de gestión interna · {{ date('Y') }}
        </p>
    </footer>

</div>

@endsection
