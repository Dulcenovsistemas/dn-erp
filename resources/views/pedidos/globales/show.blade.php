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



{{-- FILTROS DE ZONA Y SEMANA --}}
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <form method="GET"
          action="{{ request()->url() }}"
          class="flex flex-wrap items-end gap-4">

        <div class="flex flex-col gap-1">
            <label for="pedido_global_id"
                   class="text-sm font-semibold text-slate-700">
                Semana
            </label>

            <select name="pedido_global_id"
                    id="pedido_global_id"
                    class="border border-slate-300 rounded-lg px-3 py-2 min-w-64">
                @foreach($semanasDisponibles as $semana)
                    <option value="{{ $semana->id }}"
                        @selected($semana->id == $pedidoGlobal->id)>
                        {{ \Carbon\Carbon::parse($semana->fecha_inicio)->format('d/m/Y') }}
                        -
                        {{ \Carbon\Carbon::parse($semana->fecha_fin)->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label for="zona_id"
                   class="text-sm font-semibold text-slate-700">
                Zona
            </label>

            <select name="zona_id"
                    id="zona_id"
                    class="border border-slate-300 rounded-lg px-3 py-2 min-w-56">
                <option value="todas"
                    @selected($zonaSeleccionada === 'todas')>
                    Todas las zonas
                </option>

                @foreach($zonasDisponibles as $zona)
                    <option value="{{ $zona->id }}"
                        @selected((string) $zonaSeleccionada === (string) $zona->id)>
                        {{ $zona->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="rounded-lg bg-emerald-700 hover:bg-emerald-800
                       text-white font-semibold px-5 py-2.5 transition">
            Aplicar filtros
        </button>

        <a href="{{ request()->url() }}"
           class="rounded-lg border border-slate-300
                  text-slate-700 font-semibold px-5 py-2.5">
            Limpiar
        </a>
    </form>
</div>


{{-- INDICADORES DE PRODUCCIÓN --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
        <p class="text-sm font-semibold text-slate-500">
            TOTAL DE PASTELES
        </p>

        <p class="text-3xl font-bold text-slate-900 mt-2">
            {{ number_format($totalSinMinis) }}
        </p>

        <p class="text-sm text-slate-500 mt-1">
            Sin minis ni panqués
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
        <p class="text-sm font-semibold text-slate-500">
            TOTAL DE MINIS Y PANQUÉS
        </p>

        <p class="text-3xl font-bold text-slate-900 mt-2">
            {{ number_format($totalMinis) }}
        </p>

        <p class="text-sm text-slate-500 mt-1">
            Producción de minis y panqués
        </p>
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






<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="w-full overflow-x-auto">
        <table class="w-full border-collapse text-sm">

            <thead>
                <tr style="background: #f08cf0;">
                    <th class="border border-gray-400 px-3 py-2 text-left">
                        PRODUCTO
                    </th>
                    <th class="border border-gray-400 px-3 py-2 text-center">
                        CHICO
                    </th>
                    <th class="border border-gray-400 px-3 py-2 text-center">
                        GRANDE
                    </th>
                    <th class="border border-gray-400 px-3 py-2 text-center">
                        TAMAÑO ÚNICO
                    </th>
                </tr>
            </thead>

            <tbody>
                @php
                    $resumenPorCategoria = $resumen->groupBy('categoria');
                @endphp

                @forelse($resumenPorCategoria as $categoria => $filas)
                    <tr style="background: #f08cf0;">
                        <td colspan="4"
                            class="border border-gray-400 px-3 py-2 font-bold uppercase">
                            {{ $categoria }}
                        </td>
                    </tr>

                    @foreach($filas as $fila)
                        <tr>
                            <td class="border border-gray-400 px-3 py-2 bg-white">
                                {{ $fila['producto'] }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center font-bold"
                                style="background: #b4c7e7;">
                                {{ ($fila['variantes']['CHICO'] ?? 0) ?: '—' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center font-bold"
                                style="background: #b4c7e7;">
                                {{ ($fila['variantes']['GRANDE'] ?? 0) ?: '—' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center font-bold"
                                style="background: #b4c7e7;">
                                {{ ($fila['variantes']['TAMAÑO ÚNICO'] ?? 0) ?: '—' }}
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            No hay pedidos para esta semana.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr style="background: #000000; color: #ffffff;">
                    <td class="border border-gray-500 px-3 py-3 font-bold">
                        TOTAL DE PASTEL
                    </td>

                    <td class="border border-gray-500 px-3 py-3 text-center font-bold">
                        {{ number_format($totalPorVariante['CHICO'] ?? 0) }}
                    </td>

                    <td class="border border-gray-500 px-3 py-3 text-center font-bold">
                        {{ number_format($totalPorVariante['GRANDE'] ?? 0) }}
                    </td>

                    <td class="border border-gray-500 px-3 py-3 text-center font-bold">
                        {{ number_format($totalPorVariante['TAMAÑO ÚNICO'] ?? 0) }}
                    </td>
                </tr>
            </tfoot>

        </table>
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
