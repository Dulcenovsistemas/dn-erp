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

        <button
            type="button"
            id="cargar-pedido-anterior"
            class="btn-anterior"
        >
            ↻ Cargar pedido anterior
        </button>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const botonAleatorio =
        document.getElementById('llenar-aleatorio');

    const botonLimpiar =
        document.getElementById('limpiar-pedido');

    const botonAnterior =
        document.getElementById('cargar-pedido-anterior');

    const zonaSelect =
        document.querySelector('[name="zona_id"]');

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

                categoria
                    .querySelectorAll('.total-variante')
                    .forEach(total => {

                        const columna = total.dataset.columna;

                        let suma = 0;

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
    // CARGAR PEDIDO ANTERIOR
    // ==========================================

    if (botonAnterior) {

        botonAnterior.addEventListener('click', async function () {

            if (!zonaSelect || !zonaSelect.value) {

                alert('Primero selecciona una zona.');

                return;
            }


            botonAnterior.disabled = true;
            botonAnterior.textContent = 'Cargando...';


            try {

                const response = await fetch(
                    `/admin/pedidos/anterior/${zonaSelect.value}`
                );

                const data = await response.json();


                if (!data.encontrado) {

                    alert(data.mensaje);

                    return;
                }


                const confirmar = confirm(
                    `Se encontró el pedido anterior.\n\n` +
                    `Pedido #${data.pedido_id}\n` +
                    `Fecha: ${data.fecha_entrega}\n\n` +
                    `¿Quieres cargar sus cantidades?`
                );


                if (!confirmar) {
                    return;
                }


                // Primero limpiamos el pedido actual
                inputs.forEach(input => {
                    input.value = 0;
                });


                // ==========================================
                // COPIAR CANTIDADES
                // ==========================================

                data.detalles.forEach(detalle => {

                    const fecha =
                        new Date(detalle.fecha + 'T00:00:00');

                    /*
                     * 1 = lunes
                     * 2 = martes
                     * ...
                     * 7 = domingo
                     */

                    const diaSemana = fecha.getDay();

                    const dia =
                        diaSemana === 0
                            ? 6
                            : diaSemana - 1;


                    const selector =
                        `input[name="pedido[${dia}][${detalle.producto_id}][${detalle.producto_variante_id}]"]`;


                    const input =
                        document.querySelector(selector);


                    if (input) {

                        input.value =
                            detalle.cantidad;

                    }

                });


                actualizarTotales();


                alert(
                    'Pedido anterior cargado correctamente.'
                );


            } catch (error) {

                console.error(error);

                alert(
                    'Ocurrió un error al cargar el pedido anterior.'
                );

            } finally {

                botonAnterior.disabled = false;
                botonAnterior.textContent =
                    '↻ Cargar pedido anterior';

            }

        });

    }


    // ==========================================
    // LLENAR ALEATORIAMENTE
    // ==========================================

    botonAleatorio.addEventListener('click', function () {

        inputs.forEach(input => {

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
   ETIQUETAS LATERALES DEL PEDIDO
========================================== */

.pedido-flotantes {
    position: fixed;
    right: 0;
    top: 45%;
    transform: translateY(-50%);
    z-index: 9999;

    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}

.pedido-flotantes button {
    border: none;
    border-radius: 10px 0 0 10px;
    padding: 12px 14px;

    color: white;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;

    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, .12);

    transition: padding-right .2s ease,
                filter .2s ease,
                box-shadow .2s ease;
}

/* Efecto al pasar el cursor */
.pedido-flotantes button:hover {
    padding-right: 22px;
    filter: brightness(.92);
    box-shadow: 0 4px 12px rgba(0, 0, 0, .18);
}

/* Colores */
.btn-aleatorio {
    background: #7c3aed;
}

.btn-limpiar {
    background: #ef4444;
}

.btn-anterior {
    background: #0f766e;
}

/* Botón deshabilitado */
.pedido-flotantes button:disabled {
    opacity: .6;
    cursor: not-allowed;
    box-shadow: none;
}

/* Adaptación para móviles */
@media (max-width: 768px) {
    .pedido-flotantes {
        top: auto;
        bottom: 15px;
        right: 0;
        transform: none;
        gap: 6px;
    }

    .pedido-flotantes button {
        padding: 10px 11px;
        font-size: 11px;
        border-radius: 8px 0 0 8px;
    }

    .pedido-flotantes button:hover {
        padding-right: 14px;
    }
}


</style>

@endsection