@php

$dias=[

'Lunes',

'Martes',

'Miércoles',

'Jueves',

'Viernes',

'Sábado'

];

@endphp

<div
    x-data="{tab:0}"
    class="bg-white rounded-xl shadow">

    <div class="flex border-b">

        @foreach($dias as $i=>$dia)

            <button
                type="button"
                @click="tab={{ $i }}"
                class="px-6 py-4 border-r">

                {{ $dia }}

            </button>

        @endforeach

    </div>

    @foreach($dias as $i=>$dia)

        <div
            x-show="tab=={{ $i }}"
            class="p-6">

            @include('pedidos.partials.dia',[
                'dia'=>$dia,
                'indice'=>$i
            ])

        </div>

    @endforeach

</div>