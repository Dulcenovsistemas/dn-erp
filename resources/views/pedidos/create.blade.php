@extends('layouts.admin.app')

@section('title','Nuevo Pedido')

@section('content')

<div class="max-w-screen-2xl mx-auto">

    <form action="{{ route('admin.pedidos.store') }}" method="POST">

        @csrf

        @include('pedidos.partials.datos-generales')

        @include('pedidos.partials.tabs')

        <div class="mt-6 flex justify-end gap-3">

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

    </form>

</div>

@endsection