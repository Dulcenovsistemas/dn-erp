<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoMaximo;
use App\Models\User;
use Carbon\Carbon;

class GenerarPedidosAutomaticos extends Command
{
    protected $signature = 'pedidos:generar-automaticos';

    protected $description =
        'Genera pedidos automáticamente copiando el pedido anterior de cada zona';

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
             * VERIFICAR SI YA EXISTE PEDIDO PARA EL PRÓXIMO LUNES
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
             * BUSCAR EL ÚLTIMO PEDIDO ANTERIOR
             * ========================================================
             */

            $pedidoAnterior = Pedido::where('zona_id', $zona->id)
                ->whereDate(
                    'fecha_entrega',
                    '<',
                    $fechaLunes->toDateString()
                )
                ->orderByDesc('fecha_entrega')
                ->orderByDesc('id')
                ->first();


            if (!$pedidoAnterior) {

                $this->warn(
                    "Zona {$zona->nombre}: no tiene pedidos anteriores. Se omite."
                );

                continue;
            }


            /*
             * ========================================================
             * RECUPERAR DETALLES DEL PEDIDO ANTERIOR
             * ========================================================
             */

            $detallesAnteriores = PedidoDetalle::where(
                'pedido_id',
                $pedidoAnterior->id
            )->get();


            if ($detallesAnteriores->isEmpty()) {

                $this->warn(
                    "Zona {$zona->nombre}: el pedido anterior no tiene detalles. Se omite."
                );

                continue;
            }


            /*
             * ========================================================
             * COPIAR PRODUCTOS, VARIANTES Y CANTIDADES
             * ========================================================
             */

            $detalles = [];

            foreach ($detallesAnteriores as $detalleAnterior) {

                // Recuperar el día original de producción.
                $diaOriginal = Carbon::parse(
                    $detalleAnterior->fecha
                )->dayOfWeekIso;

                // Calcular la fecha correspondiente de la nueva semana.
                $nuevaFecha = $fechaLunes->copy()
                    ->addDays($diaOriginal - 1);

                $detalles[] = [

                    'producto_id' =>
                        $detalleAnterior->producto_id,

                    'producto_variante_id' =>
                        $detalleAnterior->producto_variante_id,

                    'fecha' =>
                        $nuevaFecha->toDateString(),

                    'cantidad' =>
                        (int) $detalleAnterior->cantidad,

                ];
            }


            /*
             * ========================================================
             * CREAR NUEVO PEDIDO
             * ========================================================
             */

            DB::transaction(function () use (
                $zona,
                $usuarioSistema,
                $fechaLunes,
                $detalles,
                $pedidoAnterior
            ) {

                $ultimo = (Pedido::max('id') ?? 0) + 1;

                $folio = 'PED-' . str_pad(
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
                        "Pedido generado automáticamente a partir del pedido {$pedidoAnterior->folio}.",

                ]);


                /*
                 * ====================================================
                 * GUARDAR DETALLES DEL NUEVO PEDIDO
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
                    "Pedido utilizado como plantilla: {$pedidoAnterior->folio}"
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
