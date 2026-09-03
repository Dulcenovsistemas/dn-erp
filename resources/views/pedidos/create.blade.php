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

                <button
                    type="button"
                    id="llenar-aleatorio"
                    class="bg-purple-600 text-white px-5 py-3 rounded-lg hover:bg-purple-700">

                    🎲 Llenar aleatoriamente

                </button>

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

    const boton = document.getElementById('llenar-aleatorio');

    boton.addEventListener('click', function () {

        const inputs = document.querySelectorAll(
            'input[type="number"][name^="pedido["]'
        );

        inputs.forEach(input => {

            // Entre 0 y 10
            const cantidad = Math.floor(Math.random() * 3);

            input.value = cantidad;

        });

    });

});
</script>

@endsection