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

    <div class="grid grid-cols-4 gap-6">


        {{-- ======================================================
             ZONA
        ======================================================= --}}

        <div>

            <label class="block text-sm font-medium mb-1">

                Zona

            </label>


            <select
                name="zona_id"
                class="w-full rounded-lg"
            >

                @foreach(auth()->user()->zonas as $zona)

                    <option
                        value="{{ $zona->id }}"

                        @selected(
                            isset($pedido)
                            &&
                            $pedido
                            &&
                            $pedido->zona_id == $zona->id
                        )
                    >

                        {{ $zona->nombre }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- ======================================================
             SEMANA
        ======================================================= --}}

        <div>

            <label class="block text-sm font-medium mb-1">

                Semana

            </label>


            <input

                class="w-full rounded-lg bg-gray-100"

                readonly

                value="
                    {{ $inicioSemana->translatedFormat('d F') }}
                    -
                    {{ $finSemana->translatedFormat('d F') }}
                "

            >

        </div>


        {{-- ======================================================
             FECHA CAPTURA
        ======================================================= --}}

        <div>

            <label class="block text-sm font-medium mb-1">

                Fecha captura

            </label>


            <input

                class="w-full rounded-lg bg-gray-100"

                readonly

                value="
                    {{ isset($pedido) && $pedido
                        ? Carbon::parse($pedido->fecha_pedido)
                            ->format('d/m/Y')
                        : now()->format('d/m/Y')
                    }}
                "

            >

        </div>


        {{-- ======================================================
             OBSERVACIONES
        ======================================================= --}}

        <div>

            <label class="block text-sm font-medium mb-1">

                Observaciones

            </label>


            <input

                type="text"

                name="observaciones"

                class="w-full rounded-lg"

                value="{{ old(
                    'observaciones',
                    $pedido->observaciones ?? ''
                ) }}"

            >

        </div>


    </div>

</div>


<style>

.pedido-datos {

    display: flex;

    align-items: center;

    gap: 18px;

    width: 100%;

    padding: 5px 8px;

    margin-bottom: 5px;

    background: white;

    border-bottom: 1px solid #9ca3af;

    font-size: 10px;

}


.pedido-datos > div {

    display: flex;

    align-items: center;

    gap: 5px;

}


.pedido-datos span {

    font-size: 9px;

    font-weight: 800;

    color: #6b7280;

}


.pedido-datos strong {

    font-size: 10px;

    color: #111827;

}


.pedido-select {

    height: 25px;

    padding: 2px 6px;

    border: 1px solid #d1d5db;

    border-radius: 4px;

    font-size: 10px;

}


.pedido-observaciones {

    height: 25px;

    width: 220px;

    border: 1px solid #d1d5db;

    border-radius: 4px;

    font-size: 10px;

}

</style>