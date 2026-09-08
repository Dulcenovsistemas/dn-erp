@php

    use Carbon\Carbon;

    /*
     * ============================================================
     * DÍAS DE PRODUCCIÓN
     * ============================================================
     */

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
     * SEMANA
     * ============================================================
     *
     * EDITAR:
     * Utilizamos la fecha de entrega del pedido existente.
     *
     * CREAR:
     * Calculamos la próxima semana de producción.
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

@endphp


<div class="pedido-hoja">

    {{-- ==========================================================
         TÍTULO
    =========================================================== --}}

    <div class="pedido-titulo">

        <div>

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

    </div>


    {{-- ==========================================================
         DÍAS
    =========================================================== --}}

    <div class="pedido-scroll">

        <div class="pedido-dias">

            @foreach($dias as $i => $dia)

                @php

                    $fechaDia = $inicioSemana
                        ->copy()
                        ->addDays($i);

                @endphp


                <div class="pedido-dia">


                    {{-- ==========================================
                         ENCABEZADO DEL DÍA
                    =========================================== --}}

                    <div class="pedido-dia-header">

                        <div class="pedido-dia-nombre">

                            {{ strtoupper($dia) }}

                        </div>

                        <div class="pedido-dia-fecha">

                            {{ $fechaDia->translatedFormat('d F') }}

                        </div>

                    </div>


                    {{-- ==========================================
                         ZONA
                    =========================================== --}}

                    <div class="pedido-sucursal">

                        ZONA:

                        <strong>

                            {{ auth()->user()->zonas->first()->nombre ?? 'SIN ZONA' }}

                        </strong>

                    </div>


                    {{-- ==========================================
                         PRODUCTOS
                    =========================================== --}}

                    <div class="pedido-productos">

                        @include('pedidos.partials.dia', [

                            'dia' => $dia,

                            'indice' => $i,

                            'fechaDia' => $fechaDia,

                            'pedido' => $pedido ?? null

                        ])

                    </div>


                </div>

            @endforeach

        </div>

    </div>

</div>


<style>

.pedido-hoja {

    width: 100%;

    padding: 4px;

    box-sizing: border-box;

}


.pedido-titulo {

    display: flex;

    align-items: center;

    padding: 4px 8px;

    margin-bottom: 5px;

    border-bottom: 2px solid #111827;

}


.pedido-titulo h1 {

    margin: 0;

    font-size: 16px;

    font-weight: 800;

}


.pedido-titulo p {

    margin: 2px 0 0;

    font-size: 11px;

    color: #4b5563;

}


.pedido-scroll {

    width: 100%;

    overflow-x: auto;

    overflow-y: visible;

}


.pedido-dias {

    display: grid;

    grid-template-columns:
        repeat(6, minmax(250px, 1fr));

    min-width: 1500px;

    gap: 4px;

}


.pedido-dia {

    border: 1px solid #9ca3af;

    background: white;

    min-width: 0;

}


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


.pedido-sucursal {

    font-size: 9px;

    font-weight: 700;

    padding: 3px 6px;

    border-bottom: 1px solid #9ca3af;

}


.pedido-productos {

    padding: 0;

}


.pedido-productos > h2 {

    display: none;

}


@media (max-width: 768px) {

    .pedido-dias {

        grid-template-columns:
            repeat(6, 260px);

        min-width: 1560px;

    }

}

</style>