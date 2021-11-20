<?php

namespace App\Http\Controllers;

use App\TomaPedidos;
use Illuminate\Http\Request;

class TomaPedidosController extends Controller
{
    public function index()
    {
        $items = TOMAPEDIDOS::paginate(10);
        return view('tables.toma_pedidos', compact('items'));
    }
}
