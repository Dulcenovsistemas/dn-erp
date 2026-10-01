@extends('layouts.admin.app')

@section('content')


@php
$resumenPorCategoria = $resumen->groupBy('categoria');
@endphp

<div class="max-w-7xl mx-auto px-6 py-8">


{{-- ============================================================
     ENCABEZADO
============================================================ --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                PEDIDOS GLOBALES
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Consolidado de producción por zona
            </p>

        </div>


        <div class="text-right">

            <p class="text-sm text-slate-500">
                Semana del pedido
            </p>

            <p class="text-lg font-semibold text-slate-800">

                {{ $inicioSemana->format('d/m/Y') }}

                -

                {{ $finSemana->format('d/m/Y') }}

            </p>

        </div>

    </div>

</div>





  
{{-- ============================================================
     ENCABEZADO FIJO
============================================================ --}}

<div
    id="encabezadoFijo"
    style="
        display: none;
        position: fixed;
        top: 70px;
        z-index: 9999;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
        overflow: hidden;
    "
>

    {{-- Barra fija con flechas --}}
    <div
        class="flex items-center justify-between px-4 py-2 bg-slate-50 border-b"
        style="height: 52px;"
    >

        <div class="text-xs text-slate-500">
            Consulta todas las zonas
        </div>

        <div class="flex gap-2">

            <button
                type="button"
                onclick="scrollPedidos(-1)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 transition"
                title="Mover hacia la izquierda"
            >
                ←
            </button>

            <button
                type="button"
                onclick="scrollPedidos(1)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 transition"
                title="Mover hacia la derecha"
            >
                →
            </button>

        </div>

    </div>


    {{-- Encabezado de tabla clonado --}}
    <div
        id="encabezadoFijoInterior"
        style="
            overflow: hidden;
            background: #f1f5f9;
        "
    >
    </div>

</div>


{{-- ============================================================
     TABLA GLOBAL
============================================================ --}}

<div class="bg-white rounded-xl shadow">

    {{-- ========================================================
         BARRA DE DESPLAZAMIENTO ORIGINAL
    ========================================================= --}}

    <div
        class="flex items-center justify-between px-4 py-2 bg-slate-50 border-b"
        style="height: 52px;"
    >

        <div class="text-xs text-slate-500">
            Consulta todas las zonas
        </div>


        <div class="flex gap-2">

            <button
                type="button"
                onclick="scrollPedidos(-1)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 transition"
                title="Mover hacia la izquierda"
            >
                ←
            </button>


            <button
                type="button"
                onclick="scrollPedidos(1)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 transition"
                title="Mover hacia la derecha"
            >
                →
            </button>

        </div>

    </div>


    {{-- ========================================================
         CONTENEDOR HORIZONTAL
    ========================================================= --}}

    <div
        id="scrollPedidos"
        class="w-full overflow-x-auto"
        style="overflow-x: auto;"
    >

        <table
            class="text-sm"
            style="
                min-width: max-content;
                width: max-content;
            "
        >

            {{-- ====================================================
                 ENCABEZADO
            ==================================================== --}}

            <thead
                id="encabezadoPedidos"
                class="bg-slate-100 border-b"
            >

                <tr>

                    {{-- PRODUCTO --}}
                    <th
                        class="text-left px-4 py-3 font-semibold text-slate-700 whitespace-nowrap"
                        style="min-width: 240px;"
                    >
                        PRODUCTO
                    </th>


                    {{-- VARIANTE --}}
                    <th
                        class="text-left px-4 py-3 font-semibold text-slate-700 whitespace-nowrap"
                        style="min-width: 100px;"
                    >
                        VARIANTE
                    </th>


                    {{-- ZONAS --}}
                    @foreach($zonas as $zona)

                        <th
                            class="text-center px-4 py-3 font-semibold text-slate-700 whitespace-nowrap"
                            style="min-width: 110px;"
                        >
                            {{ $zona->nombre }}
                        </th>

                    @endforeach


                    {{-- TOTAL --}}
                    <th
                        class="text-center px-4 py-3 font-semibold text-slate-800 whitespace-nowrap"
                        style="min-width: 100px;"
                    >
                        TOTAL
                    </th>

                </tr>

            </thead>

            {{-- AQUÍ CONTINÚA EL TBODY --}}


            {{-- ====================================================
                 CUERPO
            ==================================================== --}}
            <tbody>

                @forelse($resumenPorCategoria as $categoria => $filas)


                    {{-- ==================================================
                         ENCABEZADO DE CATEGORÍA
                    ================================================== --}}
                    <tr class="bg-slate-800">

                        <td
                            colspan="{{ 3 + $zonas->count() }}"
                            class="px-4 py-3 font-bold text-white uppercase tracking-wide"
                        >

                            {{ $categoria }}

                        </td>

                    </tr>


                    {{-- ==================================================
                         PRODUCTOS
                    ================================================== --}}
                    @foreach($filas as $fila)

                        <tr class="border-b hover:bg-slate-50">


                            {{-- Producto --}}
                            <td
                                class="sticky left-0 z-20 bg-white px-4 py-3 font-medium text-slate-800 whitespace-nowrap"
                                style="min-width: 240px;"
                            >
                                {{ $fila['producto'] }}
                            </td>

                            <td
                                class="sticky z-20 bg-white px-4 py-3 text-slate-600 whitespace-nowrap"
                                style="left: 240px; min-width: 100px;"
                            >
                                {{ $fila['variante'] }}
                            </td>


                            {{-- ==================================================
                                 CANTIDAD POR ZONA
                            ================================================== --}}
                            @foreach($zonas as $zona)

                                <td
                                    class="px-4 py-3 text-center whitespace-nowrap"
                                >

                                    {{ $fila['zonas'][$zona->id] ?? 0 }}

                                </td>

                            @endforeach


                            {{-- Total --}}
                            <td
                                class="px-4 py-3 text-center font-bold text-slate-800 whitespace-nowrap"
                            >

                                {{ $fila['total'] }}

                            </td>

                        </tr>

                    @endforeach


                    {{-- ==================================================
                         SUBTOTAL DE CATEGORÍA
                    ================================================== --}}
                    <tr class="bg-slate-50 border-b-2 border-slate-300">


                        {{-- Texto --}}
                        <td
                            colspan="2"
                            class="px-4 py-3 font-semibold text-slate-700 text-right whitespace-nowrap"
                        >

                            SUBTOTAL {{ strtoupper($categoria) }}

                        </td>


                        {{-- Subtotal por zona --}}
                        @foreach($zonas as $zona)

                            <td
                                class="px-4 py-3 text-center font-bold text-slate-700 whitespace-nowrap"
                            >

                                {{
                                    $filas->sum(
                                        fn ($fila) =>
                                            $fila['zonas'][$zona->id] ?? 0
                                    )
                                }}

                            </td>

                        @endforeach


                        {{-- Subtotal general de categoría --}}
                        <td
                            class="px-4 py-3 text-center font-bold text-slate-900 whitespace-nowrap"
                        >

                            {{ $filas->sum('total') }}

                        </td>

                    </tr>


                @empty


                    {{-- ==================================================
                         SIN PEDIDOS
                    ================================================== --}}
                    <tr>

                        <td
                            colspan="{{ 3 + $zonas->count() }}"
                            class="px-6 py-12 text-center text-slate-500"
                        >

                            <div class="text-lg font-medium">

                                No hay pedidos para esta semana.

                            </div>


                            <div class="text-sm mt-1">

                                Los pedidos enviados aparecerán aquí automáticamente.

                            </div>

                        </td>

                    </tr>


                @endforelse

            </tbody>


    

        @if($resumen->isNotEmpty())

            <tfoot class="bg-slate-100 border-t-2">
                {{-- ====================================================
    TOTAL SIN MINIS Y PANQUES
===================================================== --}}
<tr>

    <td
        colspan="2"
        class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap"
    >
        TOTAL GENERAL
    </td>


    {{-- Total por zona SIN MINIS Y PANQUES --}}
    @foreach($zonas as $zona)

        @php

            // Total de la zona
            $totalZona = $resumen->sum(
                fn ($fila) =>
                    $fila['zonas'][$zona->id] ?? 0
            );

            // Total de Minis y Panques de esta zona
            $totalMinisZona = $resumen
                ->filter(fn ($fila) =>
                    str_contains(
                        strtoupper(trim($fila['categoria'] ?? '')),
                        'MINIS Y PANQUES'
                    )
                )
                ->sum(
                    fn ($fila) =>
                        $fila['zonas'][$zona->id] ?? 0
                );

            // Total de la zona SIN Minis
            $totalZonaSinMinis =
                $totalZona - $totalMinisZona;

        @endphp


        <td
            class="px-4 py-3 text-center font-bold text-slate-800 whitespace-nowrap"
        >
            {{ $totalZonaSinMinis }}
        </td>

    @endforeach


    {{-- Total general SIN Minis --}}
    <td
        class="px-4 py-3 text-center font-bold text-slate-900 whitespace-nowrap"
    >
        {{ $totalSinMinis }}
    </td>

</tr>


                {{-- ====================================================
                    TOTAL MINIS Y PANQUES
                ===================================================== --}}
                <tr>

                    <td
                        colspan="2"
                        class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap"
                    >
                        MINIS Y PANQUES
                    </td>

                    {{-- Total por zona --}}
                    @foreach($zonas as $zona)

                        <td
                            class="px-4 py-3 text-center font-bold text-slate-800 whitespace-nowrap"
                        >
                            {{
                                $resumen
                                    ->filter(fn ($fila) =>
                                        str_contains(
                                            strtoupper(trim($fila['categoria'] ?? '')),
                                            'MINIS Y PANQUES'
                                        )
                                    )
                                    ->sum(
                                        fn ($fila) =>
                                            $fila['zonas'][$zona->id] ?? 0
                                    )
                            }}
                        </td>

                    @endforeach

                    {{-- Total minis --}}
                    <td
                        class="px-4 py-3 text-center font-bold text-slate-900 whitespace-nowrap"
                    >
                        {{
                            $resumen
                                ->filter(fn ($fila) =>
                                    str_contains(
                                        strtoupper(trim($fila['categoria'] ?? '')),
                                        'MINIS Y PANQUES'
                                    )
                                )
                                ->sum('total')
                        }}
                    </td>

                </tr>


            </tfoot>

        @endif



        </table>

    </div>

</div>


</div>

<script>

    /*
     * ============================================================
     * SCROLL HORIZONTAL CON FLECHAS
     * ============================================================
     */

    function scrollPedidos(direccion) {

        const contenedor =
            document.getElementById('scrollPedidos');

        if (!contenedor) {
            return;
        }

        contenedor.scrollBy({
            left: direccion * 500,
            behavior: 'smooth'
        });

    }


    /*
     * ============================================================
     * ENCABEZADO FIJO
     * ============================================================
     */

    document.addEventListener('DOMContentLoaded', function () {

        const scrollPedidos =
            document.getElementById('scrollPedidos');

        const encabezado =
            document.getElementById('encabezadoPedidos');

        const encabezadoFijo =
            document.getElementById('encabezadoFijo');

        const encabezadoFijoInterior =
            document.getElementById('encabezadoFijoInterior');


        /*
         * --------------------------------------------------------
         * VALIDAR ELEMENTOS
         * --------------------------------------------------------
         */

        if (
            !scrollPedidos ||
            !encabezado ||
            !encabezadoFijo ||
            !encabezadoFijoInterior
        ) {
            return;
        }


        /*
         * --------------------------------------------------------
         * TABLA ORIGINAL
         * --------------------------------------------------------
         */

        const tablaOriginal =
            encabezado.closest('table');

        if (!tablaOriginal) {
            return;
        }


        /*
         * ========================================================
         * CREAR TABLA DEL ENCABEZADO FIJO
         * ========================================================
         */

        const tablaFija =
            document.createElement('table');

        tablaFija.className = 'text-sm';

        tablaFija.style.borderCollapse =
            'collapse';

        tablaFija.style.width =
            tablaOriginal.offsetWidth + 'px';

        tablaFija.style.minWidth =
            tablaOriginal.offsetWidth + 'px';


        /*
         * Clonar solamente el THEAD
         */

        const theadClonado =
            encabezado.cloneNode(true);

        theadClonado.removeAttribute('id');


        tablaFija.appendChild(
            theadClonado
        );


        encabezadoFijoInterior.appendChild(
            tablaFija
        );


        /*
         * ========================================================
         * IGUALAR ANCHOS DE COLUMNAS
         * ========================================================
         */

        function igualarColumnas() {

            const columnasOriginales =
                encabezado.querySelectorAll('th');

            const columnasFijas =
                theadClonado.querySelectorAll('th');


            columnasOriginales.forEach(
                (columna, index) => {

                    const columnaFija =
                        columnasFijas[index];

                    if (!columnaFija) {
                        return;
                    }


                    const ancho =
                        columna.getBoundingClientRect().width;


                    columnaFija.style.width =
                        ancho + 'px';

                    columnaFija.style.minWidth =
                        ancho + 'px';

                    columnaFija.style.maxWidth =
                        ancho + 'px';

                }
            );


            /*
             * Actualizar ancho total de la tabla fija
             */

            tablaFija.style.width =
                tablaOriginal.offsetWidth + 'px';

            tablaFija.style.minWidth =
                tablaOriginal.offsetWidth + 'px';

        }


        igualarColumnas();


        /*
         * ========================================================
         * POSICIÓN DEL ENCABEZADO FIJO
         * ========================================================
         */

        function actualizarEncabezado() {

            const rect =
                encabezado.getBoundingClientRect();


            /*
             * El encabezado ya salió de la pantalla
             */

            if (rect.bottom <= 0) {

                encabezadoFijo.style.display =
                    'block';


                /*
                 * Obtener posición real
                 * del contenedor horizontal
                 */

                const contenedorRect =
                    scrollPedidos.getBoundingClientRect();


                encabezadoFijo.style.left =
                    contenedorRect.left + 'px';

                encabezadoFijo.style.width =
                    contenedorRect.width + 'px';


                /*
                 * Mantener el mismo ancho
                 * que la tabla original
                 */

                tablaFija.style.width =
                    tablaOriginal.offsetWidth + 'px';

                tablaFija.style.minWidth =
                    tablaOriginal.offsetWidth + 'px';


                /*
                 * Mantener sincronizado
                 * el desplazamiento horizontal
                 */

                tablaFija.style.transform =
                    `translateX(-${scrollPedidos.scrollLeft}px)`;

            }

            else {

                encabezadoFijo.style.display =
                    'none';

            }

        }


        /*
         * ========================================================
         * SCROLL VERTICAL
         * ========================================================
         */

        window.addEventListener(
            'scroll',
            actualizarEncabezado,
            { passive: true }
        );


        /*
         * ========================================================
         * SCROLL HORIZONTAL
         * ========================================================
         */

        scrollPedidos.addEventListener(
            'scroll',
            function () {

                tablaFija.style.transform =
                    `translateX(-${scrollPedidos.scrollLeft}px)`;

            },
            { passive: true }
        );


        /*
         * ========================================================
         * RESIZE
         * ========================================================
         */

        window.addEventListener(
            'resize',
            function () {

                igualarColumnas();

                actualizarEncabezado();

            }
        );


        /*
         * ========================================================
         * INICIALIZAR
         * ========================================================
         */

        actualizarEncabezado();

    });

</script>

@endsection
