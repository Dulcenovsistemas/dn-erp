
@php
    use Carbon\Carbon;

    $inicioSemana = Carbon::parse($pedido->fecha_entrega)
        ->startOfWeek(Carbon::MONDAY);

    $dias = [
        'LUNES', 'MARTES', 'MIÉRCOLES',
        'JUEVES', 'VIERNES', 'SÁBADO'
    ];

    $zona = $pedido->zona->nombre ?? 'SIN ZONA';
    $detallesPedido = $pedido->detalles;
        // Ordenar categorías por el número al inicio del nombre
    $categoriasOrdenadas = $categorias->sortBy(function ($categoria) {
        preg_match('/^\s*(\d+)/', $categoria->nombre, $coincidencia);

        return isset($coincidencia[1])
            ? (int) $coincidencia[1]
            : 9999;
    })->values();

    /*
    |--------------------------------------------------------------------------
    | Preparar la información de cada día
    |--------------------------------------------------------------------------
    */
    $bloques = [];
    $maxVariantes = 1;

    foreach ($dias as $i => $dia) {
        $fechaDia = $inicioSemana->copy()->addDays($i);
        $fechaActual = $fechaDia->toDateString();

        $detallesDia = $detallesPedido->filter(function ($detalle) use ($fechaActual) {
            return $detalle->fecha
                && Carbon::parse($detalle->fecha)->toDateString() === $fechaActual;
        });

        $filas = [];

        // Encabezado del día
        $filas[] = [
            'tipo' => 'dia',
            'titulo' => $dia . ' — ' . $fechaDia->format('d/m/Y'),
        ];

        $filas[] = [
            'tipo' => 'zona',
            'titulo' => 'ZONA: ' . $zona,
        ];

        foreach ($categoriasOrdenadas as $categoria)  {
            $productosCategoria = $categoria->productos;

            $detallesCategoria = $detallesDia->filter(function ($detalle) use ($categoria) {
                return $detalle->producto
                    && $detalle->producto->categoria_id == $categoria->id;
            });

            $variantes = $productosCategoria
                ->flatMap(function ($producto) use ($detallesCategoria) {
                    return $producto->variantes->filter(function ($variante) use ($producto, $detallesCategoria) {
                        return $variante->activo
                            || $detallesCategoria->contains(function ($detalle) use ($producto, $variante) {
                                return $detalle->producto_id == $producto->id
                                    && $detalle->producto_variante_id == $variante->id;
                            });
                    });
                })
                ->unique(fn ($variante) => strtoupper(trim($variante->nombre)))
                ->sortBy(function ($variante) {
                    return match (strtoupper(trim($variante->nombre))) {
                        'CHICO' => 1,
                        'GRANDE' => 2,
                        'TAMAÑO UNICO', 'TAMAÑO ÚNICO' => 3,
                        default => 99,
                    };
                })
                ->values();

            $maxVariantes = max($maxVariantes, $variantes->count());

            $totales = [];

            foreach ($variantes as $variante) {
                $nombreVariante = strtoupper(trim($variante->nombre));

                $totales[$nombreVariante] = $detallesCategoria
                    ->filter(function ($detalle) use ($nombreVariante) {
                        return $detalle->variante
                            && strtoupper(trim($detalle->variante->nombre)) === $nombreVariante;
                    })
                    ->sum('cantidad');
            }

            $filas[] = [
                'tipo' => 'categoria',
                'titulo' => strtoupper($categoria->nombre),
            ];

            $encabezados = ['PRODUCTO'];

            foreach ($variantes as $variante) {
                $encabezados[] = strtoupper($variante->nombre);
            }

            $filas[] = [
                'tipo' => 'encabezados',
                'celdas' => $encabezados,
            ];

            foreach ($productosCategoria as $producto) {
                $celdas = [strtoupper($producto->nombre)];

                $detallesProducto = $detallesCategoria
                    ->where('producto_id', $producto->id);

                foreach ($variantes as $varianteEncabezado) {
                    $nombreEncabezado = strtoupper(trim($varianteEncabezado->nombre));

                    $varianteProducto = $producto->variantes->first(function ($variante) use ($nombreEncabezado) {
                        return strtoupper(trim($variante->nombre)) === $nombreEncabezado;
                    });

                    $cantidad = $varianteProducto
                        ? $detallesProducto
                            ->where('producto_variante_id', $varianteProducto->id)
                            ->sum('cantidad')
                        : 0;

                    $celdas[] = $cantidad > 0 ? $cantidad : '—';
                }

                $filas[] = [
                    'tipo' => 'producto',
                    'celdas' => $celdas,
                ];
            }

            $celdasTotal = ['TOTAL'];

            foreach ($variantes as $variante) {
                $nombreVariante = strtoupper(trim($variante->nombre));
                $celdasTotal[] = $totales[$nombreVariante] ?? 0;
            }

            $filas[] = [
                'tipo' => 'total-categoria',
                'celdas' => $celdasTotal,
            ];
        }

        $filas[] = [
            'tipo' => 'total-dia',
            'titulo' => 'TOTAL DEL DÍA: ' . $detallesDia->sum('cantidad') . ' PIEZAS',
        ];

        $bloques[] = $filas;
    }

    /*
    |--------------------------------------------------------------------------
    | Ancho uniforme para cada bloque diario
    |--------------------------------------------------------------------------
    */
    $columnasBloque = 1 + $maxVariantes;
    $totalFilas = max(array_map('count', $bloques));
@endphp

<table>
    <tr>
        <th colspan="6"
            style="background-color:#111827;color:#FFFFFF;font-size:18px;">
            DULCE NOVIEMBRE — PEDIDO DE PRODUCCIÓN
        </th>
    </tr>

    <tr>
        <th style="width:110px;background-color:#E5E7EB;">FOLIO</th>
        <td style="width:180px;">{{ $pedido->folio }}</td>

        <th style="width:110px;background-color:#E5E7EB;">ZONA</th>
        <td style="width:180px;">{{ $zona }}</td>

        <th style="width:110px;background-color:#E5E7EB;">ESTATUS</th>
        <td style="width:130px;">{{ strtoupper($pedido->estatus) }}</td>
    </tr>

    <tr>
        <th style="background-color:#E5E7EB;">USUARIO</th>
        <td>{{ $pedido->usuario->name ?? '—' }}</td>

        <th style="background-color:#E5E7EB;">FECHA CAPTURA</th>
        <td>
            {{ $pedido->fecha_pedido
                ? Carbon::parse($pedido->fecha_pedido)->format('d/m/Y')
                : '' }}
        </td>

        <th style="background-color:#E5E7EB;">FECHA ENTREGA</th>
        <td>
            {{ $pedido->fecha_entrega
                ? Carbon::parse($pedido->fecha_entrega)->format('d/m/Y')
                : '' }}
        </td>
    </tr>

    <tr>
        <th colspan="6" style="background-color:#F3F4F6;text-align:left;">
            SEMANA:
            {{ $inicioSemana->format('d/m/Y') }}
            AL
            {{ $inicioSemana->copy()->addDays(5)->format('d/m/Y') }}
        </th>
    </tr>

    @if($pedido->observaciones)
        <tr>
            <th>OBSERVACIONES</th>
            <td colspan="5">{{ $pedido->observaciones }}</td>
        </tr>
    @endif
</table>

<table>
    @for($r = 0; $r < $totalFilas; $r++)
        <tr>
            @foreach($bloques as $bloque)
                @php
                    $fila = $bloque[$r] ?? null;
                    $tipo = $fila['tipo'] ?? 'vacia';
                    $celdas = $fila['celdas'] ?? [];
                    $estilo = '';

                    if ($tipo === 'dia') {
                        $estilo = 'background-color:#111827;color:#FFFFFF;font-weight:bold;text-align:center;';
                    } elseif ($tipo === 'zona') {
                        $estilo = 'background-color:#F3F4F6;font-weight:bold;text-align:center;';
                    } elseif ($tipo === 'categoria') {
                        $estilo = 'background-color:#F0A9D8;color:#111827;font-weight:bold;';
                    } elseif ($tipo === 'encabezados') {
                        $estilo = 'background-color:#DBE4F3;font-weight:bold;text-align:center;';
                    } elseif ($tipo === 'producto') {
                        $estilo = 'border-bottom:1px solid #D1D5DB;';
                    } elseif ($tipo === 'total-categoria' || $tipo === 'total-dia') {
                        $estilo = 'background-color:#111827;color:#FFFFFF;font-weight:bold;';
                    }
                @endphp

                @if($tipo === 'dia' || $tipo === 'zona' || $tipo === 'categoria' || $tipo === 'total-dia')
                    <td colspan="{{ $columnasBloque }}"
                        style="{{ $estilo }}">
                        {{ $fila['titulo'] ?? '' }}
                    </td>
                @else
                    @for($c = 0; $c < $columnasBloque; $c++)
                        @php
                            $valor = $celdas[$c] ?? '';
                            $estiloCelda = $estilo;

                            if ($tipo === 'producto' && $c > 0) {
                                $estiloCelda .= 'background-color:#C7D5EA;text-align:center;';
                            }

                            if ($tipo === 'total-categoria') {
                                $estiloCelda .= 'text-align:center;';
                            }

                            if ($tipo === 'encabezados' && $c === 0) {
                                $estiloCelda .= 'text-align:left;';
                            }
                        @endphp

                        @php
                            if ($c === 0) {
                                $estiloCelda .= 'width:180px;min-width:180px;text-align:left;';
                            } else {
                                $estiloCelda .= 'width:65px;min-width:65px;text-align:center;';
                            }
                        @endphp

                        <td style="{{ $estiloCelda }}">
                            {{ $valor }}
                        </td>
                    @endfor
                @endif
            @endforeach
        </tr>
    @endfor
</table>
