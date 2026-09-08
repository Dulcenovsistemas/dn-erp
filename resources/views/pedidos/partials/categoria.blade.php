@php

    /*
     * ============================================================
     * PRODUCTOS ACTIVOS
     * ============================================================
     */

    $productosActivos = $categoria->productos
        ->where('activo', 1);


    /*
     * ============================================================
     * VARIANTES PARA LOS ENCABEZADOS
     * ============================================================
     *
     * Tomamos las variantes del primer producto que tenga variantes.
     *
     * Posición 0 = primera variante
     * Posición 1 = segunda variante
     */

    $productoReferencia = $productosActivos
        ->first(fn ($producto) => $producto->variantes->count() > 0);

    $variantesEncabezado = $productoReferencia
        ? $productoReferencia->variantes->take(2)->values()
        : collect();

@endphp


<div class="categoria-produccion">

    {{-- ==========================================================
         CATEGORÍA
    =========================================================== --}}

    <div class="categoria-header">

        {{ strtoupper($categoria->nombre) }}

    </div>


    {{-- ==========================================================
         TABLA
    =========================================================== --}}

    <table class="tabla-categoria">

        <thead>

            <tr>

                {{-- PRODUCTO --}}

                <th class="producto-col">
                    PRODUCTO
                </th>


                {{-- VARIANTE 1 --}}

                @if(isset($variantesEncabezado[0]))

                    <th class="variante-col">

                        {{ strtoupper($variantesEncabezado[0]->nombre) }}

                    </th>

                @endif


                {{-- VARIANTE 2 --}}

                @if(isset($variantesEncabezado[1]))

                    <th class="variante-col">

                        {{ strtoupper($variantesEncabezado[1]->nombre) }}

                    </th>

                @endif

            </tr>

        </thead>


        <tbody>


            {{-- ==================================================
                 PRODUCTOS
            =================================================== --}}

            @foreach($productosActivos as $producto)

                @php

                    /*
                     * ==================================================
                     * VARIANTES DEL PRODUCTO
                     * ==================================================
                     *
                     * Cada producto utiliza sus propias variantes.
                     */

                    $variantesProducto = $producto->variantes
                        ->take(2)
                        ->values();


                    /*
                     * ==================================================
                     * CANTIDADES GUARDADAS
                     * ==================================================
                     *
                     * Si estamos editando un pedido:
                     *
                     * buscamos las cantidades que corresponden
                     * a este producto y a la fecha actual.
                     *
                     * Si estamos creando:
                     *
                     * $pedido no existe y se utilizará 0.
                     */

                    $cantidades = collect();

                    if (
                        isset($pedido)
                        &&
                        $pedido
                        &&
                        isset($fechaActual)
                    ) {

                        $cantidades = $pedido->detalles
                            ->filter(function ($detalle) use (
                                $producto,
                                $fechaActual
                            ) {

                                return
                                    $detalle->producto_id == $producto->id
                                    &&
                                    $detalle->fecha
                                    &&
                                    \Carbon\Carbon::parse($detalle->fecha)->toDateString() === $fechaActual;

                            })
                            ->keyBy('producto_variante_id');

                    }

                @endphp


                <tr>


                    {{-- ==================================================
                         NOMBRE DEL PRODUCTO
                    =================================================== --}}

                    <td class="producto-nombre">

                        {{ strtoupper($producto->nombre) }}

                    </td>


                    {{-- ==================================================
                         PRIMERA VARIANTE
                    =================================================== --}}

                    @if(isset($variantesEncabezado[0]))

                        <td class="cantidad-col">

                            @if(isset($variantesProducto[0]))

                                <input
                                    type="number"
                                    min="0"

                                    value="{{ $cantidades[$variantesProducto[0]->id]->cantidad ?? 0 }}"

                                    class="cantidad-input"

                                    data-categoria="{{ $categoria->id }}"

                                    data-dia="{{ $dia }}"

                                    data-columna="0"

                                    data-variante="{{ $variantesProducto[0]->id }}"

                                    name="pedido[{{ $dia }}][{{ $producto->id }}][{{ $variantesProducto[0]->id }}]"
                                >

                            @endif

                        </td>

                    @endif


                    {{-- ==================================================
                         SEGUNDA VARIANTE
                    =================================================== --}}

                    @if(isset($variantesEncabezado[1]))

                        <td class="cantidad-col">

                            @if(isset($variantesProducto[1]))

                                <input
                                    type="number"
                                    min="0"

                                    value="{{ $cantidades[$variantesProducto[1]->id]->cantidad ?? 0 }}"

                                    class="cantidad-input"

                                    data-categoria="{{ $categoria->id }}"

                                    data-dia="{{ $dia }}"

                                    data-columna="1"

                                    data-variante="{{ $variantesProducto[1]->id }}"

                                    name="pedido[{{ $dia }}][{{ $producto->id }}][{{ $variantesProducto[1]->id }}]"
                                >

                            @endif

                        </td>

                    @endif


                </tr>


            @endforeach


            {{-- ==========================================================
                 TOTAL
            =========================================================== --}}

            <tr class="total-categoria">


                <td>
                    TOTAL
                </td>


                {{-- TOTAL VARIANTE 1 --}}

                @if(isset($variantesEncabezado[0]))

                    <td>

                        <span
                            class="total-variante"
                            data-columna="0"
                        >
                            0
                        </span>

                    </td>

                @endif


                {{-- TOTAL VARIANTE 2 --}}

                @if(isset($variantesEncabezado[1]))

                    <td>

                        <span
                            class="total-variante"
                            data-columna="1"
                        >
                            0
                        </span>

                    </td>

                @endif


            </tr>


        </tbody>

    </table>

</div>


<style>

/* ============================================================
   CATEGORÍA
============================================================ */

.categoria-produccion {

    margin: 0;

    border-bottom: 1px solid #9ca3af;

}


/* ============================================================
   ENCABEZADO CATEGORÍA
============================================================ */

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


/* ============================================================
   ENCABEZADOS
============================================================ */

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


/* ============================================================
   COLUMNA PRODUCTO
============================================================ */

.tabla-categoria .producto-col {

    width: 58%;

    text-align: left;

}


/* ============================================================
   COLUMNAS VARIANTES
============================================================ */

.tabla-categoria .variante-col {

    width: 21%;

    text-align: center;

}


/* ============================================================
   FILAS
============================================================ */

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


/* ============================================================
   PRODUCTO
============================================================ */

.producto-nombre {

    font-weight: 600;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

    text-align: left;

}


/* ============================================================
   CANTIDAD
============================================================ */

.cantidad-col {

    text-align: center;

    padding: 0 !important;

}


/* ============================================================
   INPUT
============================================================ */

.cantidad-input {

    width: 100%;

    height: 18px;

    padding: 0;

    border: none !important;

    outline: none;

    background: #c7d5ea;

    text-align: center;

    font-size: 10px;

    font-weight: 700;

    color: #111827;

}


.cantidad-input:focus {

    background: white;

    box-shadow:
        inset 0 0 0 2px #2563eb;

}


/* ============================================================
   QUITAR FLECHAS
============================================================ */

.cantidad-input::-webkit-inner-spin-button,
.cantidad-input::-webkit-outer-spin-button {

    -webkit-appearance: none;

    margin: 0;

}


.cantidad-input[type=number] {

    appearance: textfield;

}


/* ============================================================
   TOTAL
============================================================ */

.total-categoria td {

    background: #111827;

    color: white;

    font-weight: 800;

    border-color: #111827;

    height: 20px;

}


.total-categoria td:first-child {

    text-align: left;

}


.total-variante {

    display: block;

    text-align: center;

}

</style>