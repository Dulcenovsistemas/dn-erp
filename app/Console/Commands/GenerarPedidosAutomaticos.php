<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Zona;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoMaximo;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;

class GenerarPedidosAutomaticos extends Command
{
    protected $signature = 'pedidos:generar-automaticos';

    protected $description =
        'Genera automáticamente los pedidos de las zonas que no tengan pedido enviado';

    public function handle()
    {
        /*
         * ============================================================
         * PRÓXIMO LUNES
         * ============================================================
         */

        $fechaLunes = Carbon::now()
            ->next(Carbon::MONDAY)
            ->startOfDay();


        /*
         * ============================================================
         * DÍAS DE LA SEMANA
         * ============================================================
         */

        $diasSemana = [];

        for ($i = 0; $i < 6; $i++) {

            $diasSemana[] = $fechaLunes
                ->copy()
                ->addDays($i);
        }


        /*
         * ============================================================
         * MÁXIMOS CONFIGURADOS
         * ============================================================
         */

        $pedidosMaximos = PedidoMaximo::with('zona')
            ->where('maximo', '>', 0)
            ->get();


        if ($pedidosMaximos->isEmpty()) {

            $this->info('No hay máximos configurados.');

            return self::SUCCESS;
        }


        /*
         * ============================================================
         * USUARIO DEL SISTEMA
         * ============================================================
         */

        $usuarioSistema = User::whereHas('roles', function ($query) {

            $query->where('name', 'admin');

        })->first();


        if (!$usuarioSistema) {

            $this->error(
                'No se encontró un usuario con rol admin para crear los pedidos.'
            );

            return self::FAILURE;
        }


        /*
         * ============================================================
         * PRODUCTOS DISPONIBLES
         * ============================================================
         */

        $productos = Producto::with([
            'variantes' => function ($query) {

                $query
                    ->where('activo', true)
                    ->orderBy('nombre');

            }
        ])
        ->where('activo', true)
        ->get()
        ->filter(function ($producto) {

            return $producto->variantes->isNotEmpty();

        })
        ->values();


        if ($productos->isEmpty()) {

            $this->error(
                'No hay productos con variantes activas.'
            );

            return self::FAILURE;
        }


        /*
         * ============================================================
         * GENERAR POR ZONA
         * ============================================================
         */

        foreach ($pedidosMaximos as $pedidoMaximo) {

            $zona = $pedidoMaximo->zona;

            if (!$zona) {
                continue;
            }


            /*
             * ========================================================
             * VERIFICAR SI YA EXISTE PEDIDO ENVIADO
             * PARA EL PRÓXIMO LUNES
             * ========================================================
             */

            $yaExiste = Pedido::where('zona_id', $zona->id)
                ->where('estatus', 'enviado')
                ->whereDate(
                    'fecha_entrega',
                    $fechaLunes->toDateString()
                )
                ->exists();


            if ($yaExiste) {

                $this->info(
                    "Zona {$zona->nombre}: ya tiene pedido enviado. Se omite."
                );

                continue;
            }


            /*
             * ========================================================
             * MÁXIMO TOTAL DE PIEZAS
             * ========================================================
             */

            $maximo = (int) $pedidoMaximo->maximo;


            if ($maximo <= 0) {
                continue;
            }


            /*
             * ========================================================
             * CREAR LISTA DE PRODUCTOS/VARIANTES
             *
             * Cada combinación producto + variante puede recibir
             * 1 o 2 piezas.
             * ========================================================
             */

            $opciones = collect();


            foreach ($productos as $producto) {

                foreach ($producto->variantes as $variante) {

                    $opciones->push([
                        'producto_id' => $producto->id,
                        'producto_variante_id' => $variante->id,
                    ]);
                }
            }


            /*
             * Mezclamos para que el pedido sea diferente.
             */

            $opciones = $opciones->shuffle();


            /*
             * ========================================================
             * GENERAR EXACTAMENTE EL MÁXIMO
             * ========================================================
             */

                    /*
 * ========================================================
 * GENERAR EXACTAMENTE EL MÁXIMO
 * DISTRIBUIDO DE LUNES A VIERNES
 * MÁXIMO 2 PIEZAS POR PRODUCTO/VARIANTE/DÍA
 * ========================================================
 */

$detalles = [];

$total = 0;


/*
 * ========================================================
 * CANTIDAD MÁXIMA POR COMBINACIÓN
 * ========================================================
 *
 * Chihuahua permite una cantidad mayor por combinación.
 * Las demás zonas empiezan con máximo 2 piezas.
 */

$esChihuahua =
    mb_strtoupper(trim($zona->nombre)) === 'CHIHUAHUA';

$maximoPorCombinacion = $esChihuahua ? 10 : 2;


/*
 * ========================================================
 * CREAR TODAS LAS COMBINACIONES
 * ========================================================
 *
 * Producto + variante + día
 */

$opciones = collect();

foreach ($productos as $producto) {

    foreach ($producto->variantes as $variante) {

        foreach ($diasSemana as $fecha) {

            $opciones->push([

                'producto_id' =>
                    $producto->id,

                'producto_variante_id' =>
                    $variante->id,

                'fecha' =>
                    $fecha->copy(),

            ]);

        }
    }
}


/*
 * Mezclar para que cada pedido tenga
 * una distribución diferente.
 */

$opciones = $opciones->shuffle();


/*
 * ========================================================
 * PRIMERA DISTRIBUCIÓN
 * ========================================================
 *
 * Cada combinación recibe entre 1 y el máximo permitido.
 */

foreach ($opciones as $opcion) {

    if ($total >= $maximo) {
        break;
    }

    $cantidad = rand(
        1,
        $maximoPorCombinacion
    );


    /*
     * Nunca superar el máximo semanal.
     */

    $cantidad = min(
        $cantidad,
        $maximo - $total
    );


    if ($cantidad <= 0) {
        break;
    }


    $clave =
        $opcion['producto_id'] .
        '-' .
        $opcion['producto_variante_id'] .
        '-' .
        $opcion['fecha']->toDateString();


    $detalles[$clave] = [

        'producto_id' =>
            $opcion['producto_id'],

        'producto_variante_id' =>
            $opcion['producto_variante_id'],

        'fecha' =>
            $opcion['fecha']->toDateString(),

        'cantidad' =>
            $cantidad,

    ];


    $total += $cantidad;
}


/*
 * ========================================================
 * COMPLETAR EL MÁXIMO
 * ========================================================
 *
 * Si todavía faltan piezas para llegar al máximo
 * configurado de la zona, volvemos a recorrer las
 * combinaciones existentes y aumentamos cantidades.
 *
 * Esto permite que el sistema siga funcionando aunque
 * se hayan eliminado categorías o productos.
 */

if ($total < $maximo) {

    $claves = array_keys($detalles);

    shuffle($claves);


    foreach ($claves as $clave) {

        if ($total >= $maximo) {
            break;
        }


        $actual =
            (int) $detalles[$clave]['cantidad'];


        /*
         * Cuánto espacio queda en esta combinación.
         */

        $espacio =
            $maximoPorCombinacion - $actual;


        if ($espacio <= 0) {
            continue;
        }


        /*
         * Cuánto necesitamos todavía.
         */

        $faltante =
            $maximo - $total;


        /*
         * Agregamos una cantidad aleatoria,
         * pero nunca superior al espacio disponible
         * ni al faltante.
         */

        $adicional = rand(
            1,
            min($espacio, $faltante)
        );


        $detalles[$clave]['cantidad']
            += $adicional;


        $total += $adicional;
    }
}


/*
 * ========================================================
 * SEGUNDO INTENTO
 * ========================================================
 *
 * Si todavía falta cantidad, hacemos un recorrido
 * determinista para llenar cualquier espacio restante.
 */

if ($total < $maximo) {

    foreach ($detalles as $clave => &$detalle) {

        if ($total >= $maximo) {
            break;
        }


        $espacio =
            $maximoPorCombinacion -
            (int) $detalle['cantidad'];


        if ($espacio <= 0) {
            continue;
        }


        $faltante =
            $maximo - $total;


        $adicional =
            min($espacio, $faltante);


        $detalle['cantidad']
            += $adicional;


        $total += $adicional;
    }

    unset($detalle);
}


/*
 * ========================================================
 * CONVERTIR A ARREGLO NORMAL
 * ========================================================
 */

$detalles = array_values($detalles);
            /*
             * ========================================================
             * COMPROBACIÓN
             * ========================================================
             */

            if ($total !== $maximo) {

                $this->warn(
                    "Zona {$zona->nombre}: " .
                    "se esperaban {$maximo} piezas " .
                    "pero se generaron {$total}."
                );

                continue;
            }


            /*
             * ========================================================
             * CREAR PEDIDO
             * ========================================================
             */

            DB::transaction(function () use (
                $zona,
                $usuarioSistema,
                $fechaLunes,
                $detalles
            ) {

                $ultimo = Pedido::max('id') + 1;

                $folio =
                    'PED-' .
                    str_pad(
                        $ultimo,
                        6,
                        '0',
                        STR_PAD_LEFT
                    );


                $pedido = Pedido::create([

                    'folio' => $folio,

                    'zona_id' => $zona->id,

                    'user_id' => $usuarioSistema->id,

                    'fecha_pedido' => now(),

                    'fecha_entrega' => $fechaLunes,

                    'estatus' => 'enviado',

                    'observaciones' =>
                        'Pedido generado automáticamente.',

                ]);


                /*
                 * ====================================================
                 * DETALLES
                 * ====================================================
                 */

                foreach ($detalles as $detalle) {

                    PedidoDetalle::create([

                        'pedido_id' =>
                            $pedido->id,

                        'producto_id' =>
                            $detalle['producto_id'],

                        'producto_variante_id' =>
                            $detalle['producto_variante_id'],

                        'fecha' =>
                            $detalle['fecha'],

                        'cantidad' =>
                            $detalle['cantidad'],

                    ]);
                }


                $this->info(
                    "Pedido {$pedido->folio} generado para {$zona->nombre}."
                );

                $this->info(
                    "Total generado: " .
                    collect($detalles)->sum('cantidad') .
                    " piezas."
                );
            });
        }


        $this->info('Proceso terminado.');

        return self::SUCCESS;
    }
}