<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use DB;

class EmpresaCategoriaController extends ApiController
{
    public function index($empresas)
    {
           // devuleve los productos con incluyendo las categorias
            $categorias=DB::table('productos as pro')
            ->join('empresas as p','pro.empresa_id','=','p.id')
            ->join('categorias as dv','pro.categoria_id','=','dv.id')
            ->select('dv.nombre as categoria','dv.id as idcategoria')
            ->where('p.id','=',$empresas)->distinct()
            ->get();
             return response()->json(['data'=>$categorias]);
 
    }
}
