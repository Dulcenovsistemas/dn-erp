@extends('layouts.admin.app')

@section('title', 'Editar Pedido')

@section('content')

<div class="pedido-pantalla">

    <form
        action="{{ route('admin.pedidos.update', $pedido) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- DATOS GENERALES --}}

        @include('pedidos.partials.datos-generales', [
            'pedido' => $pedido
        ])

        {{-- HOJA DE PRODUCCIÓN --}}

        @include('pedidos.partials.tabs-table', [
            'pedido' => $pedido,
            'categorias' => $categorias
        ])


        {{-- BOTONES --}}

        <div class="pedido-acciones">

            <button
                type="submit"
                class="btn-borrador"
            >
                Guardar cambios
            </button>

            <a
                href="{{ route('admin.pedidos.show', $pedido) }}"
                class="btn-cancelar"
            >
                Cancelar
            </a>

        </div>

    </form>


    {{-- BOTONES FLOTANTES --}}

    <div class="pedido-flotantes">

        <button
            type="button"
            id="llenar-aleatorio"
            class="btn-aleatorio"
        >
            🎲 Aleatorio
        </button>

        <button
            type="button"
            id="limpiar-pedido"
            class="btn-limpiar"
        >
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
    // TOTALES
    // ==========================================

    function actualizarTotales() {

        document
            .querySelectorAll('.categoria-produccion')
            .forEach(categoria => {

                categoria
                    .querySelectorAll('.total-variante')
                    .forEach(total => {

                        const columna =
                            total.dataset.columna;

                        let suma = 0;

                        categoria
                            .querySelectorAll(
                                `.cantidad-input[data-columna="${columna}"]`
                            )
                            .forEach(input => {

                                suma +=
                                    parseInt(input.value) || 0;

                            });

                        total.textContent = suma;

                    });

            });

    }


    // ==========================================
    // ALEATORIO
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
    // CAMBIAR CANTIDAD
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

.pedido-pantalla {
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
}

.pedido-acciones {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 12px;
}

.btn-borrador,
.btn-cancelar {
    border: none;
    border-radius: 6px;
    padding: 10px 18px;
    color: white;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none;
}

.btn-borrador {
    background: #2563eb;
}

.btn-cancelar {
    background: #6b7280;
}

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

.btn-limpiar {
    background: #ef4444;
}

</style>

@endsection