<?php

namespace App\Exports;

use App\Models\Pedido;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PedidoExport implements FromView
{
    public function __construct(
        protected Pedido $pedido
    ) {}

    public function view(): View
    {
        $pedido = $this->pedido->load([
            'zona',
            'usuario',
            'detalles.producto',
            'detalles.variante',
        ]);

        $categorias = \App\Models\Categoria::with([
            'productos.variantes',
        ])->get();

        return view('pedidos.exportar-excel', compact(
            'pedido',
            'categorias'
        ));
    }
}