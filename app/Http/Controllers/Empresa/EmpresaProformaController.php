<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use DB;

class EmpresaProformaController extends Controller
{
    public function index($proformas)
    {
           
            $proforma=DB::table('proformas as pro')
            ->join('users as u','pro.user_id','=','u.id')
            ->join('detalles as d','pro.id','=','d.id_proforma')
            ->join('productos as prod','prod.id','=','d.id_producto')
            ->select('pro.numero','pro.total','pro.estado','prod.nombre','prod.precio','d.cantidad')
            ->where('pro.id','=',$proformas)
            ->get();
             return response()->json(['data'=>$proforma]);

    }
}
