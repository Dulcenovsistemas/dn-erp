<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


// ✅ IMPORTS OBLIGATORIOS
use App\Models\OrdenVenta;


class OrdenVentaMermaController extends Controller
{
    public function index(OrdenVenta $orden)
    {
        // seguridad básica
        if ($orden->estado !== 'en_proceso') {
            abort(403);
        }

        return view('admin.ordenes.mermas', compact('orden'));
    }
}

