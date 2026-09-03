@extends('layouts.admin.app')

@section('title','Nuevo Pedido')

@section('content')

<div class="max-w-screen-2xl mx-auto">

    <form action="{{ route('admin.pedidos.store') }}" method="POST">

        @csrf

        @include('pedidos.partials.datos-generales')

        @include('pedidos.partials.tabs')

        <div class="mt-6 flex justify-end gap-3">

            <div class="mt-6 flex justify-end gap-3">

               {{-- Botones flotantes --}}
                <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">

                    {{-- Llenado aleatorio --}}
                    <button
                        type="button"
                        id="llenar-aleatorio"
                        class="bg-purple-600 text-white px-5 py-3 rounded-full shadow-lg
                            hover:bg-purple-700 transition-all duration-200
                            hover:scale-105">

                        🎲 Llenar aleatoriamente

                    </button>

                    {{-- Limpiar --}}
                    <button
                        type="button"
                        id="limpiar-pedido"
                        class="bg-red-500 text-white px-5 py-3 rounded-full shadow-lg
                            hover:bg-red-600 transition-all duration-200
                            hover:scale-105">

                        🧹 Limpiar

                    </button>

                </div>
                <button
                    class="bg-gray-600 text-white px-5 py-3 rounded-lg"
                    type="submit"
                    name="accion"
                    value="borrador">

                    Guardar borrador

                </button>

                <button
                    class="bg-blue-600 text-white px-5 py-3 rounded-lg"
                    type="submit"
                    name="accion"
                    value="enviar">

                    Enviar pedido

                </button>

            </div>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const botonAleatorio = document.getElementById('llenar-aleatorio');
    const botonLimpiar = document.getElementById('limpiar-pedido');

    const inputs = document.querySelectorAll(
        'input[type="number"][name^="pedido["]'
    );

    // Llenado aleatorio
    botonAleatorio.addEventListener('click', function () {

        inputs.forEach(input => {

            // Entre 1 y 2 piezas
            const cantidad = Math.floor(Math.random() * 2) + 1;

            input.value = cantidad;

        });

    });


    // Limpiar todo
    botonLimpiar.addEventListener('click', function () {

        inputs.forEach(input => {
            input.value = 0;
        });

    });

});
</script>

@endsection