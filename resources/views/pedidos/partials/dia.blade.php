<h2 class="font-bold text-lg mb-5">

{{ $dia }}

</h2>

@foreach($categorias->sortBy('nombre') as $categoria)

    @include('pedidos.partials.categoria',[
        'categoria'=>$categoria,
        'dia'=>$indice
    ])

@endforeach