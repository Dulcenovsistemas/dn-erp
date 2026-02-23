<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenVenta;

class OrdenVentaGastosController extends Controller
{
    public function index(OrdenVenta $orden)
    {
        return view('admin.ordenes.gastos', compact('orden'));
    }
}
