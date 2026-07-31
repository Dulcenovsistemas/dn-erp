<div class="mb-8 border rounded-lg overflow-hidden">

    <div class="bg-pink-300 px-4 py-2 font-bold">
        {{ strtoupper($categoria->nombre) }}
    </div>

    @php
        $maxVariantes = $categoria->productos->max(fn ($p) => $p->variantes->count());
    @endphp

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>

                <th class="text-left p-2">
                    Producto
                </th>

                @for($i = 0; $i < $maxVariantes; $i++)

                    <th class="text-center p-2">
                        Variante {{ $i + 1 }}
                    </th>

                @endfor

            </tr>
        </thead>

        <tbody>

            @foreach($categoria->productos as $producto)

                <tr class="border-t">

                    <td class="p-2 font-medium">
                        {{ $producto->nombre }}
                    </td>

                    @foreach($producto->variantes as $variante)

                        <td class="text-center p-2">

                            <label class="block text-xs text-gray-500 mb-1">
                                {{ $variante->nombre }}
                            </label>

                            <input
                                type="number"
                                min="0"
                                value="0"
                                class="w-16 text-center rounded border-gray-300"
                                name="pedido[{{ $dia }}][{{ $producto->id }}][{{ $variante->id }}]">

                        </td>

                    @endforeach

                    {{-- Completar columnas vacías --}}
                    @for($i = $producto->variantes->count(); $i < $maxVariantes; $i++)

                        <td></td>

                    @endfor

                </tr>

            @endforeach

        </tbody>

    </table>

</div>