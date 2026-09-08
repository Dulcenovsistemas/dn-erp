@php

    use Carbon\Carbon;


    /*
     * ============================================================
     * SEMANA
     * ============================================================
     */

    if (
        isset($pedido)
        &&
        $pedido
        &&
        $pedido->fecha_entrega
    ) {

        $inicioSemana = Carbon::parse(
            $pedido->fecha_entrega
        )->startOfWeek(Carbon::MONDAY);

    } else {

        $hoy = Carbon::today();

        $jueves = $hoy->copy();

        if (!$hoy->isThursday()) {

            $jueves = $hoy->next(
                Carbon::THURSDAY
            );

        }

        $inicioSemana = $jueves
            ->copy()
            ->addDays(4);

    }


    $finSemana = $inicioSemana
        ->copy()
        ->addDays(5);

@endphp


<div class="bg-white rounded-xl shadow p-6 mb-6">

    <div class="pedido-datos">

    {{-- ======================================================
         ZONA
    ======================================================= --}}

    <div>

        <span>ZONA</span>

        <select
            name="zona_id"
            class="pedido-select"
        >

            @foreach(auth()->user()->zonas as $zona)

                <option
                    value="{{ $zona->id }}"
                    @selected(
                        isset($pedido) &&
                        $pedido &&
                        $pedido->zona_id == $zona->id
                    )
                >
                    {{ $zona->nombre }}
                </option>

            @endforeach

        </select>

    </div>


    {{-- ======================================================
         USUARIO
    ======================================================= --}}

    <div>

        <span>USUARIO</span>

        <strong>
            {{ auth()->user()->name }}
        </strong>

    </div>


    {{-- ======================================================
         FECHA CAPTURA
    ======================================================= --}}

    <div>

        <span>FECHA CAPTURA</span>

        <strong>

            {{ isset($pedido) && $pedido
                ? Carbon::parse($pedido->fecha_pedido)->format('d/m/Y')
                : now()->format('d/m/Y')
            }}

        </strong>

    </div>


    {{-- ======================================================
         FECHA ENTREGA
    ======================================================= --}}

    <div>

        <span>FECHA ENTREGA</span>

        <strong>

            {{ isset($pedido) && $pedido->fecha_entrega
                ? Carbon::parse($pedido->fecha_entrega)->format('d/m/Y')
                : '-'
            }}

        </strong>

    </div>


    {{-- ======================================================
         SEMANA
    ======================================================= --}}

    <div>

        <span>SEMANA</span>

        <strong>

            {{ $inicioSemana->translatedFormat('d F') }}
            -
            {{ $finSemana->translatedFormat('d F') }}

        </strong>

    </div>


    {{-- ======================================================
         OBSERVACIONES
    ======================================================= --}}

    <div class="pedido-observaciones-wrapper">

        <span>OBSERVACIONES</span>

        <input
            type="text"
            name="observaciones"
            class="pedido-observaciones"
            value="{{ old(
                'observaciones',
                $pedido->observaciones ?? ''
            ) }}"
            placeholder="Agregar observaciones..."
        >

    </div>

</div>

</div>


<style>

.pedido-datos {

    display: flex;

    align-items: center;

    gap: 0;

    width: 100%;

    min-height: 45px;

    padding: 0;

    margin-bottom: 8px;

    background: white;

    border: 1px solid #9ca3af;

    font-size: 10px;

}


/* ============================================================
   CADA DATO
============================================================ */

.pedido-datos > div {

    display: flex;

    flex-direction: column;

    justify-content: center;

    gap: 3px;

    height: 45px;

    padding: 5px 10px;

    border-right: 1px solid #9ca3af;

    min-width: 0;

}


/* ============================================================
   ETIQUETA
============================================================ */

.pedido-datos span {

    font-size: 8px;

    font-weight: 700;

    color: #6b7280;

    text-transform: uppercase;

}


/* ============================================================
   VALOR
============================================================ */

.pedido-datos strong {

    font-size: 10px;

    font-weight: 700;

    color: #111827;

}


/* ============================================================
   ZONA
============================================================ */

.pedido-datos > div:first-child {

    width: 25%;

}


/* ============================================================
   USUARIO
============================================================ */

.pedido-datos > div:nth-child(2) {

    width: 25%;

}


/* ============================================================
   FECHA CAPTURA
============================================================ */

.pedido-datos > div:nth-child(3) {

    width: 15%;

}


/* ============================================================
   FECHA ENTREGA
============================================================ */

.pedido-datos > div:nth-child(4) {

    width: 15%;

}


/* ============================================================
   SEMANA
============================================================ */

.pedido-datos > div:nth-child(5) {

    width: 20%;

}


/* ============================================================
   SELECT
============================================================ */

.pedido-select {

    width: 100%;

    height: 22px;

    padding: 1px 5px;

    border: none;

    background: transparent;

    font-size: 10px;

    font-weight: 700;

    color: #111827;

    outline: none;

}


/* ============================================================
   OBSERVACIONES
============================================================ */

.pedido-observaciones-wrapper {

    width: 260px !important;

    flex-shrink: 0;

    border-right: none !important;

}


.pedido-observaciones {

    width: 100%;

    height: 22px;

    padding: 2px 5px;

    border: 1px solid #d1d5db;

    border-radius: 3px;

    font-size: 10px;

    outline: none;

}


.pedido-observaciones:focus {

    border-color: #6b7280;

}


/* ============================================================
   RESPONSIVE
============================================================ */

@media (max-width: 900px) {

    .pedido-datos {

        flex-wrap: wrap;

        height: auto;

    }

    .pedido-datos > div {

        width: 50% !important;

        border-bottom: 1px solid #9ca3af;

    }

    .pedido-observaciones-wrapper {

        width: 100% !important;

    }

}

</style>