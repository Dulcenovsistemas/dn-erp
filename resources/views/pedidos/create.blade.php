@extends('layouts.admin.app')

@section('title', 'Nuevo Pedido')

@section('content')

<div class="pedido-pantalla">

    <form action="{{ route('admin.pedidos.store') }}" method="POST">

        @csrf

        {{-- Datos generales --}}
        @include('pedidos.partials.datos-generales')

        {{-- Hoja de producción --}}
        @include('pedidos.partials.tabs-table')


        {{-- BOTONES INFERIORES --}}
        <div class="pedido-acciones">

            <button
                type="submit"
                name="accion"
                value="borrador"
                class="btn-borrador">

                Guardar borrador

            </button>

            <button
                type="submit"
                name="accion"
                value="enviar"
                class="btn-enviar">

                Enviar pedido

            </button>

        </div>

    </form>


    {{-- BOTONES FLOTANTES --}}
    <div class="pedido-flotantes">

        <button
            type="button"
            id="llenar-aleatorio"
            class="btn-aleatorio">

            🎲 Aleatorio

        </button>

        <button
            type="button"
            id="limpiar-pedido"
            class="btn-limpiar">

            🧹 Limpiar

        </button>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const botonAleatorio =
        document.getElementById('llenar-aleatorio');

    const botonLimpiar =
        document.getElementById('limpiar-pedido');

    const inputs = document.querySelectorAll(
        'input[type="number"][name^="pedido["]'
    );


    // ==========================================
    // ACTUALIZAR TOTALES
    // ==========================================

    function actualizarTotales() {

        document
            .querySelectorAll('.categoria-produccion')
            .forEach(categoria => {

                // Recorremos cada total de esta categoría
                categoria
                    .querySelectorAll('.total-variante')
                    .forEach(total => {

                        const columna = total.dataset.columna;

                        let suma = 0;

                        // Solamente inputs de ESTA categoría
                        // y de ESTA columna
                        categoria
                            .querySelectorAll(
                                `.cantidad-input[data-columna="${columna}"]`
                            )
                            .forEach(input => {

                                suma += parseInt(input.value) || 0;

                            });

                        total.textContent = suma;

                    });

            });

    }

    // ==========================================
    // LLENAR ALEATORIAMENTE
    // ==========================================

    botonAleatorio.addEventListener('click', function () {

        inputs.forEach(input => {

            // Entre 1 y 2 piezas
            input.value =
                Math.floor(Math.random() * 2) + 1;

        });

        actualizarTotales();

    });


    // ==========================================
    // LIMPIAR
    // ==========================================

    botonLimpiar.addEventListener('click', function () {

        inputs.forEach(input => {

            input.value = 0;

        });

        actualizarTotales();

    });


    // ==========================================
    // ACTUALIZAR AL ESCRIBIR
    // ==========================================

    document
        .querySelectorAll('.cantidad-input')
        .forEach(input => {

            input.addEventListener(
                'input',
                actualizarTotales
            );

        });


    actualizarTotales();

});

</script>


<style>

/* ==========================================
   PANTALLA
========================================== */

.pedido-pantalla {
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
}


/* ==========================================
   ACCIONES
========================================== */

.pedido-acciones {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 12px;
}

.btn-borrador,
.btn-enviar {
    border: none;
    border-radius: 6px;
    padding: 10px 18px;
    color: white;
    cursor: pointer;
    font-size: 13px;
}

.btn-borrador {
    background: #4b5563;
}

.btn-enviar {
    background: #2563eb;
}


/* ==========================================
   BOTONES FLOTANTES
========================================== */

.pedido-flotantes {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 9999;

    display: flex;
    flex-direction: column;
    gap: 8px;
}

.pedido-flotantes button {
    border: none;
    border-radius: 50px;
    padding: 11px 18px;

    color: white;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    box-shadow: 0 4px 12px rgba(0,0,0,.20);

    transition: .2s;
}

.pedido-flotantes button:hover {
    transform: scale(1.05);
}

.btn-aleatorio {
    background: #7c3aed;
}

.btn-aleatorio:hover {
    background: #6d28d9;
}

.btn-limpiar {
    background: #ef4444;
}

.btn-limpiar:hover {
    background: #dc2626;
}

</style>

@endsection