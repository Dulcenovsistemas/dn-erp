@foreach($categorias->sortBy('nombre') as $categoria)

    @include('pedidos.partials.categoria', [
        'categoria' => $categoria,
        'dia' => $indice,
        'fechaActual' => $fechaDia->toDateString(),
        'pedido' => $pedido ?? null
    ])

@endforeach