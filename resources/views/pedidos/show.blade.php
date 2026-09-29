@extends('layouts.admin.app')

@section('title', 'Pedido '.$pedido->folio)

@section('content')

@php

    use Carbon\Carbon;


    /*
     * ============================================================
     * SEMANA DEL PEDIDO
     * ============================================================
     */

    $inicioSemana = Carbon::parse(
        $pedido->fecha_entrega
    )->startOfWeek(Carbon::MONDAY);

    $dias = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado'
    ];


    /*
     * ============================================================
     * ESTATUS
     * ============================================================
     */

    $estatus = strtolower($pedido->estatus);

    $estatusTexto = match ($estatus) {
        'borrador'    => 'Borrador',
        'enviado'     => 'Enviado',
        'preparacion' => 'En preparación',
        'entregado'  => 'Entregado',
        default       => ucfirst($pedido->estatus),
    };


    $estatusClase = match ($estatus) {
        'borrador' => 'estado-borrador',
        'enviado' => 'estado-enviado',
        'preparacion' => 'estado-preparacion',
        'entregado' => 'estado-entregado',
        default => 'estado-default',
    };

@endphp


<div class="pedido-pantalla">


    {{-- ==========================================================
         ENCABEZADO
    =========================================================== --}}

    <div class="pedido-info">

        <div class="pedido-info-principal">

            <div>

                <div class="pedido-folio">

                    {{ $pedido->folio }}

                </div>

                <h1>

                    PEDIDO DE PRODUCCIÓN

                </h1>

                <p>

                    Semana:

                    <strong>

                        {{ $inicioSemana->translatedFormat('d F') }}

                        -

                        {{ $inicioSemana
                            ->copy()
                            ->addDays(5)
                            ->translatedFormat('d F')
                        }}

                    </strong>

                </p>

            </div>


            <div class="pedido-estado {{ $estatusClase }}">

                {{ $estatusTexto }}

            </div>

        </div>


        {{-- ======================================================
             DATOS
        ======================================================= --}}

        <div class="pedido-datos">


            <div class="pedido-dato">

                <span>
                    ZONA
                </span>

                <strong>

                    {{ $pedido->zona->nombre ?? 'SIN ZONA' }}

                </strong>

            </div>


            <div class="pedido-dato">

                <span>
                    USUARIO
                </span>

                <strong>

                    {{ $pedido->usuario->name ?? '—' }}

                </strong>

            </div>


            <div class="pedido-dato">

                <span>
                    FECHA CAPTURA
                </span>

                <strong>

                    {{ Carbon::parse($pedido->fecha_pedido)
                        ->format('d/m/Y') }}

                </strong>

            </div>


            <div class="pedido-dato">

                <span>
                    FECHA ENTREGA
                </span>

                <strong>

                    {{ Carbon::parse($pedido->fecha_entrega)
                        ->format('d/m/Y') }}

                </strong>

            </div>


        </div>


        {{-- ======================================================
             OBSERVACIONES
        ======================================================= --}}

        @if($pedido->observaciones)

            <div class="pedido-observaciones">

                <span>
                    OBSERVACIONES
                </span>

                <p>

                    {{ $pedido->observaciones }}

                </p>

            </div>

        @endif

    </div>


    {{-- ==========================================================
         HOJA DE PRODUCCIÓN
    =========================================================== --}}

    <div class="pedido-hoja">

        <div class="pedido-titulo">

            <div>

                <h2>
                    DETALLE DEL PEDIDO
                </h2>

                <p>

                    {{ $pedido->folio }}

                    ·

                    {{ $pedido->zona->nombre ?? 'SIN ZONA' }}

                </p>

            </div>

        </div>


        <div class="pedido-scroll">

            <div class="pedido-dias">


                {{-- ==================================================
                     SEIS DÍAS
                =================================================== --}}

                @foreach($dias as $i => $dia)

    @php

        /*
         * ============================================================
         * FECHA DEL DÍA
         * ============================================================
         */

        $fechaDia = $inicioSemana
            ->copy()
            ->addDays($i);

        $fechaActual = $fechaDia
            ->toDateString();


        /*
         * ============================================================
         * DETALLES DEL PEDIDO PARA ESTE DÍA
         * ============================================================
         */

        $detallesDia = $pedido->detalles
            ->filter(function ($detalle) use ($fechaActual) {

                return Carbon::parse(
                    $detalle->fecha
                )->toDateString() === $fechaActual;

            });


        /*
         * ============================================================
         * TOTAL DEL DÍA
         * ============================================================
         */

        $totalDia = $detallesDia
            ->sum('cantidad');

    @endphp


    <div class="pedido-dia">


        {{-- ==========================================================
             ENCABEZADO DÍA
        =========================================================== --}}

        <div class="pedido-dia-header">

            <div class="pedido-dia-nombre">

                {{ strtoupper($dia) }}

            </div>

            <div class="pedido-dia-fecha">

                {{ $fechaDia->translatedFormat('d F') }}

            </div>

        </div>


        {{-- ==========================================================
             ZONA
        =========================================================== --}}

        <div class="pedido-sucursal">

            ZONA:

            <strong>

                {{ $pedido->zona->nombre ?? 'SIN ZONA' }}

            </strong>

        </div>


        {{-- ==========================================================
             CATEGORÍAS
        =========================================================== --}}

        <div class="pedido-productos">


            @foreach($categorias as $categoria)

                @php

                    /*
                    * ============================================================
                    * PRODUCTOS DE LA CATEGORÍA
                    * ============================================================
                    */

                    $productosCategoria = $categoria->productos;


                    /*
                    * ============================================================
                    * DETALLES DE ESTA CATEGORÍA PARA ESTE DÍA
                    * ============================================================
                    */

                    $detallesCategoria = $detallesDia
                        ->filter(function ($detalle) use ($categoria) {

                            return $detalle->producto
                                && $detalle->producto->categoria_id == $categoria->id;

                        });


                    /*
                    * ============================================================
                    * VARIANTES QUE DEBE MOSTRAR LA CATEGORÍA
                    * ============================================================
                    *
                    * Tomamos las variantes activas.
                    *
                    * También conservamos una variante inactiva si ya fue
                    * utilizada en este pedido, para no perder información
                    * histórica.
                    *
                    */

                    $variantes = $productosCategoria
                        ->flatMap(function ($producto) use ($detallesCategoria) {

                            return $producto->variantes
                                ->filter(function ($variante) use (
                                    $producto,
                                    $detallesCategoria
                                ) {

                                    return $variante->activo
                                        || $detallesCategoria->contains(function ($detalle) use (
                                            $producto,
                                            $variante
                                        ) {

                                            return
                                                $detalle->producto_id == $producto->id
                                                &&
                                                $detalle->producto_variante_id == $variante->id;

                                        });

                                });

                        })
                        ->unique(function ($variante) {

                            return strtoupper(trim($variante->nombre));

                        })
                        ->sortBy(function ($variante) {

                            $nombre = strtoupper(trim($variante->nombre));

                            return match ($nombre) {

                                'CHICO' => 1,
                                'GRANDE' => 2,
                                'TAMAÑO UNICO' => 3,
                                'TAMAÑO ÚNICO' => 3,

                                default => 99,

                            };

                        })
                        ->values();


                    /*
                    * ============================================================
                    * TOTALES POR VARIANTE
                    * ============================================================
                    */

                    $totalesVariantes = [];

                    foreach ($variantes as $variante) {

                        $nombreVariante = strtoupper(
                            trim($variante->nombre)
                        );

                        $totalesVariantes[$nombreVariante] = $detallesCategoria
                            ->filter(function ($detalle) use ($nombreVariante) {

                                if (!$detalle->variante) {
                                    return false;
                                }

                                return strtoupper(
                                    trim($detalle->variante->nombre)
                                ) === $nombreVariante;

                            })
                            ->sum('cantidad');

                    }

                @endphp

                <div class="categoria-produccion">


                    {{-- ==============================================
                         CATEGORÍA
                    =============================================== --}}

                    <div class="categoria-header">

                        {{ strtoupper($categoria->nombre) }}

                    </div>


                    {{-- ==============================================
                         TABLA
                    =============================================== --}}

                    <table class="tabla-categoria">

                        <thead>

                            <tr>

                                <th class="producto-col">
                                    PRODUCTO
                                </th>

                                @foreach($variantes as $variante)

                                    <th class="variante-col">

                                        {{ strtoupper($variante->nombre) }}

                                    </th>

                                @endforeach

                            </tr>

                        </thead>


                        <tbody>


                            {{-- ======================================
                                 TODOS LOS PRODUCTOS
                            ======================================= --}}

                            @foreach($productosCategoria as $producto)

                                @php

                                    /*
                                    * ========================================================
                                    * VARIANTES DEL PRODUCTO
                                    * ========================================================
                                    */

                                    $variantesProducto = $producto->variantes;


                                    /*
                                    * ========================================================
                                    * DETALLES DE ESTE PRODUCTO
                                    * ========================================================
                                    */

                                    $detallesProducto = $detallesCategoria
                                        ->where('producto_id', $producto->id);

                                @endphp


                                <tr>

                                    {{-- =====================================================
                                        PRODUCTO
                                    ====================================================== --}}

                                    <td class="producto-nombre">

                                        {{ strtoupper($producto->nombre) }}

                                    </td>


                                    {{-- =====================================================
                                        VARIANTES
                                    ====================================================== --}}

                                    @foreach($variantes as $varianteEncabezado)

                                        @php

                                            /*
                                            * Nombre de la columna actual
                                            *
                                            * Ejemplo:
                                            * CHICO
                                            * GRANDE
                                            * TAMAÑO UNICO
                                            */

                                            $nombreEncabezado = strtoupper(
                                                trim($varianteEncabezado->nombre)
                                            );


                                            /*
                                            * Buscar la variante REAL de este producto
                                            * por nombre y NO por posición.
                                            */

                                            $varianteProducto = $variantesProducto
                                                ->first(function ($variante) use (
                                                    $nombreEncabezado
                                                ) {

                                                    return strtoupper(
                                                        trim($variante->nombre)
                                                    ) === $nombreEncabezado;

                                                });


                                            /*
                                            * Buscar la cantidad guardada para esa variante.
                                            */

                                            $cantidad = $varianteProducto
                                                ? $detallesProducto
                                                    ->where(
                                                        'producto_variante_id',
                                                        $varianteProducto->id
                                                    )
                                                    ->sum('cantidad')
                                                : 0;

                                        @endphp


                                        <td class="cantidad-col">

                                            {{ $cantidad > 0 ? $cantidad : '—' }}

                                        </td>

                                    @endforeach

                                </tr>

                            @endforeach

                            {{-- ======================================
                                 TOTAL CATEGORÍA
                            ======================================= --}}

                            <tr class="total-categoria">

                                <td>
                                    TOTAL
                                </td>

                                @foreach($variantes as $variante)

                                    @php

                                        $nombreVariante = strtoupper(
                                            trim($variante->nombre)
                                        );

                                    @endphp

                                    <td>

                                        {{ $totalesVariantes[$nombreVariante] ?? 0 }}

                                    </td>

                                @endforeach

                            </tr>


                        </tbody>

                    </table>


                </div>


            @endforeach


        </div>


        {{-- ==========================================================
             TOTAL DEL DÍA
        =========================================================== --}}

        <div class="total-dia">

            <span>
                TOTAL DEL DÍA
            </span>

            <strong>

                {{ $totalDia }}

            </strong>

            <small>
                piezas
            </small>

        </div>


    </div>


@endforeach

            </div>

        </div>

    </div>


    {{-- ==========================================================
         ACCIONES
    =========================================================== --}}

    <div class="pedido-acciones">


        <a
            href="{{ route('admin.pedidos.index') }}"
            class="btn-regresar"
        >

            ← Regresar

        </a>


        <a
            href="{{ route('admin.pedidos.edit', $pedido) }}"
            class="btn-editar"
        >

            ✎ Editar pedido

        </a>


    </div>


</div>


<style>

/* ============================================================
   CONTENEDOR GENERAL
============================================================ */

.pedido-pantalla {

    width: 100%;

    padding: 8px;

    box-sizing: border-box;

}


/* ============================================================
   INFORMACIÓN DEL PEDIDO
============================================================ */

.pedido-info {

    background: white;

    border: 1px solid #d1d5db;

    margin-bottom: 8px;

}


.pedido-info-principal {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 10px 12px;

    border-bottom: 1px solid #9ca3af;

}


.pedido-folio {

    font-size: 10px;

    font-weight: 800;

    color: #6b7280;

    text-transform: uppercase;

}


.pedido-info h1 {

    margin: 1px 0;

    font-size: 17px;

    font-weight: 800;

    color: #111827;

}


.pedido-info p {

    margin: 2px 0 0;

    font-size: 10px;

    color: #6b7280;

}


.pedido-info p strong {

    color: #111827;

}


/* ============================================================
   ESTATUS
============================================================ */

.pedido-estado {

    padding: 5px 12px;

    border-radius: 50px;

    font-size: 10px;

    font-weight: 800;

    text-transform: uppercase;

}


.estado-borrador {

    background: #e5e7eb;

    color: #374151;

}


.estado-enviado {

    background: #dbeafe;

    color: #1d4ed8;

}


.estado-preparacion {

    background: #fef3c7;

    color: #92400e;

}


.estado-entregado {

    background: #dcfce7;

    color: #166534;

}


.estado-default {

    background: #fee2e2;

    color: #991b1b;

}


/* ============================================================
   DATOS
============================================================ */

.pedido-datos {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    border-bottom: 1px solid #d1d5db;

}


.pedido-dato {

    padding: 7px 10px;

    border-right: 1px solid #d1d5db;

}


.pedido-dato:last-child {

    border-right: none;

}


.pedido-dato span,
.pedido-observaciones span {

    display: block;

    font-size: 8px;

    font-weight: 800;

    color: #6b7280;

}


.pedido-dato strong {

    display: block;

    margin-top: 2px;

    font-size: 10px;

    color: #111827;

}


/* ============================================================
   OBSERVACIONES
============================================================ */

.pedido-observaciones {

    padding: 7px 10px;

}


.pedido-observaciones p {

    margin: 3px 0 0;

    font-size: 10px;

    color: #374151;

}


/* ============================================================
   HOJA
============================================================ */

.pedido-hoja {

    width: 100%;

    padding: 4px;

    box-sizing: border-box;

    background: white;

    border: 1px solid #d1d5db;

}


/* ============================================================
   TÍTULO
============================================================ */

.pedido-titulo {

    display: flex;

    align-items: center;

    padding: 4px 8px;

    margin-bottom: 5px;

    border-bottom: 2px solid #111827;

}


.pedido-titulo h2 {

    margin: 0;

    font-size: 14px;

    font-weight: 800;

}


.pedido-titulo p {

    margin: 2px 0 0;

    font-size: 9px;

    color: #6b7280;

}


/* ============================================================
   SCROLL
============================================================ */

.pedido-scroll {

    width: 100%;

    overflow-x: auto;

    overflow-y: visible;

}


/* ============================================================
   SEIS DÍAS
============================================================ */

.pedido-dias {

    display: grid;

    grid-template-columns:
        repeat(6, minmax(250px, 1fr));

    min-width: 1500px;

    gap: 4px;

}


/* ============================================================
   DÍA
============================================================ */

.pedido-dia {

    border: 1px solid #9ca3af;

    background: white;

    min-width: 0;

}


/* ============================================================
   HEADER DÍA
============================================================ */

.pedido-dia-header {

    background: #f3f4f6;

    border-bottom: 1px solid #111827;

    padding: 4px 6px;

    line-height: 1.1;

}


.pedido-dia-nombre {

    font-size: 11px;

    font-weight: 800;

}


.pedido-dia-fecha {

    font-size: 10px;

    font-weight: 600;

    color: #374151;

    text-transform: uppercase;

}


/* ============================================================
   ZONA
============================================================ */

.pedido-sucursal {

    font-size: 9px;

    font-weight: 700;

    padding: 3px 6px;

    border-bottom: 1px solid #9ca3af;

}


/* ============================================================
   PRODUCTOS
============================================================ */

.pedido-productos {

    padding: 0;

}


/* ============================================================
   CATEGORÍA
============================================================ */

.categoria-produccion {

    margin: 0;

    border-bottom: 1px solid #9ca3af;

}


.categoria-header {

    background: #f0a9d8;

    color: #111827;

    padding: 3px 5px;

    font-size: 10px;

    font-weight: 800;

    border-bottom: 1px solid #111827;

}


/* ============================================================
   TABLA
============================================================ */

.tabla-categoria {

    width: 100%;

    border-collapse: collapse;

    table-layout: fixed;

    font-size: 9px;

}


.tabla-categoria thead th {

    background: #dbe4f3;

    border-bottom: 1px solid #9ca3af;

    border-right: 1px solid #9ca3af;

    padding: 2px 3px;

    font-size: 8px;

    font-weight: 800;

    text-align: center;

    white-space: nowrap;

}


.tabla-categoria .producto-col {

    width: 58%;

    text-align: left;

}


.tabla-categoria .variante-col {

    width: 21%;

    text-align: center;

}


.tabla-categoria tbody tr {

    height: 19px;

}


.tabla-categoria tbody td {

    border-bottom: 1px solid #d1d5db;

    border-right: 1px solid #d1d5db;

    padding: 0 3px;

}


.tabla-categoria tbody td:last-child {

    border-right: none;

}


.producto-nombre {

    font-weight: 600;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

    text-align: left;

}


.cantidad-col {

    text-align: center;

    font-size: 10px;

    font-weight: 700;

    color: #111827;

    background: #c7d5ea;

}


/* ============================================================
   TOTAL CATEGORÍA
============================================================ */

.total-categoria td {

    background: #111827;

    color: white;

    font-weight: 800;

    border-color: #111827;

    height: 20px;

    text-align: center;

}


.total-categoria td:first-child {

    text-align: left;

}


/* ============================================================
   SIN DETALLES
============================================================ */

.sin-detalles {

    padding: 15px 5px;

    text-align: center;

    font-size: 9px;

    font-weight: 700;

    color: #9ca3af;

}


/* ============================================================
   TOTAL DEL DÍA
============================================================ */

.total-dia {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 5px;

    padding: 5px 7px;

    background: #111827;

    color: white;

}


.total-dia span {

    font-size: 8px;

    font-weight: 800;

}


.total-dia strong {

    font-size: 12px;

}


.total-dia small {

    font-size: 8px;

    opacity: .7;

}


/* ============================================================
   BOTONES
============================================================ */

.pedido-acciones {

    display: flex;

    justify-content: flex-end;

    gap: 8px;

    margin-top: 10px;

}


.btn-regresar,
.btn-editar {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 9px 16px;

    border-radius: 6px;

    font-size: 12px;

    font-weight: 700;

    text-decoration: none;

}


.btn-regresar {

    background: #4b5563;

    color: white;

}


.btn-regresar:hover {

    background: #374151;

}


.btn-editar {

    background: #2563eb;

    color: white;

}


.btn-editar:hover {

    background: #1d4ed8;

}


/* ============================================================
   MÓVIL
============================================================ */

@media (max-width: 768px) {

    .pedido-datos {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .pedido-dato:nth-child(2) {

        border-right: none;

    }


    .pedido-dato:nth-child(-n+2) {

        border-bottom: 1px solid #d1d5db;

    }


    .pedido-info-principal {

        align-items: flex-start;

    }


    .pedido-estado {

        margin-left: 8px;

        white-space: nowrap;

    }


    .pedido-dias {

        grid-template-columns:
            repeat(6, 260px);

        min-width: 1560px;

    }

}

</style>

@endsection