@extends('layouts.admin.app')

@section('title', 'Nuevo Pedido')

@section('content')

<div class="pedido-pantalla">

    <form action="{{ route('admin.pedidos.store') }}" method="POST">

        @csrf

        {{-- Datos generales --}}
        @include('pedidos.partials.datos-generales')
         {{-- CONTADOR GENERAL DE PIEZAS --}}
        <div id="resumen-piezas-pedido">
            <div class="resumen-piezas-texto">
                <strong>Total de piezas del pedido</strong>
                <span>Se actualiza automáticamente al cambiar las cantidades.</span>
            </div>

            <div class="resumen-piezas-total">
                <span id="contador-piezas" aria-live="polite">0</span>
                <span class="resumen-piezas-etiqueta">PIEZAS</span>
            </div>
        </div>


        {{-- Hoja de producción --}}
        @include('pedidos.partials.tabs-table')

        
       



        {{-- BOTONES INFERIORES --}}
        <div class="pedido-acciones">

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
            class="btn-flotante btn-aleatorio"
            title="Aleatorio"
        >
            <span class="icono">🎲</span>
            <span class="texto">Aleatorio</span>
        </button>

        <button
            type="button"
            id="limpiar-pedido"
            class="btn-flotante btn-limpiar"
            title="Limpiar pedido"
        >
            <span class="icono">🧹</span>
            <span class="texto">Limpiar</span>
        </button>

        <button
            type="button"
            id="cargar-pedido-anterior"
            class="btn-flotante btn-anterior"
            title="Cargar pedido anterior"
        >
            <span class="icono">↻</span>
            <span class="texto">Cargar pedido anterior</span>
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

// ==========================================
// MOSTRAR DÍAS SEGÚN LA ZONA
// ==========================================

const contenedorDias = document.getElementById('pedido-dias');

function actualizarDiasZona() {

    if (!zonaSelect || !contenedorDias) return;

    const opcion = zonaSelect.options[zonaSelect.selectedIndex];

    const diasPermitidos = (opcion.dataset.dias || '')
        .split(',')
        .filter(Boolean)
        .map(Number);

    const columnas = contenedorDias.querySelectorAll('.pedido-dia');

    let visibles = 0;

    columnas.forEach(columna => {

        const numeroDia = Number(columna.dataset.dia);

        const permitido = diasPermitidos.includes(numeroDia);

        columna.classList.toggle(
            'oculto-por-zona',
            !permitido
        );

        columna.querySelectorAll('input[type="number"]').forEach(input => {
            input.disabled = !permitido;
        });

        if (permitido) {
            visibles++;
        }

    });

    contenedorDias.className =
        'pedido-dias columnas-activas-' + visibles;

}

// Detectar cambios de zona.
if (zonaSelect) {

    zonaSelect.addEventListener('change', actualizarDiasZona);

    // Aplicar configuración inicial.
    actualizarDiasZona();

}

const inputs = document.querySelectorAll(
    'input[type="number"][name^="pedido["]'
);


    // ==========================================
    // ACTUALIZAR TOTALES
    // ==========================================

   
    function actualizarTotales() {

        // Actualizar los totales por variante y categoría
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
                                suma += Math.max(0, Number(input.value) || 0);
                            });

                        total.textContent = suma;
                    });
            });

        // Actualizar el total general del pedido
        let totalPiezas = 0;

        document.querySelectorAll('.cantidad-input').forEach(input => {
            totalPiezas += Math.max(0, Number(input.value) || 0);
        });

        const contador = document.getElementById('contador-piezas');

        if (contador) {
            contador.textContent = totalPiezas.toLocaleString('es-MX');
        }
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
            botonAnterior.querySelector('.texto').textContent = 'Cargando...';


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
                botonAnterior.querySelector('.texto').textContent =
                        'Cargar pedido anterior';
            }

        });

    }

    // ==========================================
    // LLENAR ALEATORIAMENTE
    // RESPETANDO EL MAXIMO SEMANAL
    // ==========================================

    botonAleatorio.addEventListener('click', function () {

        const opcion = zonaSelect.options[zonaSelect.selectedIndex];

        const maximo = Number(opcion.dataset.maximo || 0);

        // Obtener únicamente campos de días permitidos.
        const inputsDisponibles = Array.from(inputs).filter(input => {
            const categoria = input.closest('.categoria-produccion');

            if (!categoria || input.disabled) {
                return false;
            }

            const nombreCategoria = categoria
                .querySelector('h2, h3, .categoria-titulo')
                ?.textContent.trim().toUpperCase() || '';
                console.log('Categoría detectada:', nombreCategoria);
            // Excluir MINIS Y PANQUÉS
            if (nombreCategoria.includes('MINIS Y PANQU')) {
                return false;
            }

            return true;
        });

        if (maximo <= 0) {
            alert('Esta zona no tiene un máximo semanal configurado.');
            return;
        }

        if (inputsDisponibles.length === 0) {
            alert('No hay campos disponibles para distribuir las piezas.');
            return;
        }

        // Generar pesos aleatorios para distribuir las piezas.
        const pesos = inputsDisponibles.map(() => Math.random());

        const sumaPesos = pesos.reduce((total, peso) => total + peso, 0);

        // Calcular la distribución inicial.
        const distribucion = pesos.map(peso => {
            return (peso / sumaPesos) * maximo;
        });

        // Asignar la parte entera de cada distribución.
        const cantidades = distribucion.map(Math.floor);

        // Calcular las piezas que faltan por distribuir.
        let restantes = maximo - cantidades.reduce((a, b) => a + b, 0);

        // Ordenar índices según los decimales más grandes.
        const indices = distribucion
            .map((valor, indice) => ({
                indice,
                decimal: valor - Math.floor(valor)
            }))
            .sort((a, b) => b.decimal - a.decimal);

        // Repartir las piezas restantes.
        for (let i = 0; i < restantes; i++) {
            cantidades[indices[i].indice]++;
        }

        // Limpiar primero los campos disponibles.
        inputsDisponibles.forEach(input => {
            input.value = 0;
        });

        // Colocar las cantidades generadas.
        inputsDisponibles.forEach((input, indice) => {
            input.value = cantidades[indice];
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

/* CONTENEDOR DE BOTONES FLOTANTES */
.pedido-flotantes {
    position: fixed;
    right: 20px;
    top: 45%;
    transform: translateY(-50%);
    z-index: 9999;

    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
}

/* BOTONES */
.btn-flotante {
    box-sizing: border-box;
    width: 52px;
    height: 52px;
    padding: 0 15px;

    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;

    overflow: hidden;
    white-space: nowrap;

    border: none;
    border-radius: 50px;

    color: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;

    box-shadow: 0 4px 12px rgba(0,0,0,0.18);

    transition: width 0.3s ease,
                transform 0.3s ease,
                box-shadow 0.3s ease;
}

/* ICONOS */
.btn-flotante .icono {
    min-width: 22px;
    font-size: 20px;
    text-align: center;
}

/* TEXTO */
.btn-flotante .texto {
    opacity: 0;
    transition: opacity 0.2s ease;
}

/* EXPANSIÓN */
.btn-flotante:hover {
    width: max-content;
    max-width: 280px;
    border-radius: 30px;
    transform: translateX(-5px);
}

.btn-flotante:hover .texto {
    opacity: 1;
}

/* COLORES */
.btn-aleatorio {
    background: #7c3aed;
}

.btn-limpiar {
    background: #dc2626;
}

.btn-anterior {
    background: #0f766e;
}

/* HOVER */
.btn-aleatorio:hover {
    background: #6d28d9;
}

.btn-limpiar:hover {
    background: #b91c1c;
}

.btn-anterior:hover {
    background: #115e59;
}

/* DESHABILITADO */
.pedido-flotantes button:disabled {
    opacity: .6;
    cursor: not-allowed;
}

/* MÓVILES */
@media (max-width: 768px) {
    .pedido-flotantes {
        right: 10px;
        bottom: 15px;
        top: auto;
        transform: none;
    }

    .btn-flotante {
        width: 46px;
        height: 46px;
    }
}



#resumen-piezas-pedido {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    width: 100%;
    box-sizing: border-box;
    margin: 18px 0;
    padding: 16px 20px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 12px;
}

.resumen-piezas-texto {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.resumen-piezas-texto strong {
    color: #1e3a8a;
    font-size: 15px;
}

.resumen-piezas-texto span {
    color: #1d4ed8;
    font-size: 12px;
}

.resumen-piezas-total {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 75px;
}

#contador-piezas {
    color: #1e40af;
    font-size: 30px;
    font-weight: 800;
    line-height: 1.2;
}

.resumen-piezas-etiqueta {
    color: #1d4ed8;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

/* ACCIONES DEL PEDIDO */
.pedido-acciones {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 20px;
    padding: 15px 0;
}

/* ESTILO GENERAL */
.btn-borrador,
.btn-enviar {
    border: none;
    border-radius: 9px;
    padding: 12px 22px;
    min-width: 155px;

    color: white;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;

    transition: all 0.25s ease;
    box-shadow: 0 3px 8px rgba(0,0,0,0.12);
}

/* GUARDAR BORRADOR */
.btn-borrador {
    background: #475569;
}

.btn-borrador:hover {
    background: #334155;
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.18);
}

/* ENVIAR PEDIDO */
.btn-enviar {
    background: #047857;
}

.btn-enviar:hover {
    background: #065f46;
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.18);
}

/* EFECTO AL PRESIONAR */
.btn-borrador:active,
.btn-enviar:active {
    transform: translateY(0);
}

/* MÓVILES */
@media (max-width: 600px) {
    .pedido-acciones {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-borrador,
    .btn-enviar {
        width: 100%;
    }
}


</style>


@endsection