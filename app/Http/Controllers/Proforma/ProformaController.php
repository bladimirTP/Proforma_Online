<?php

namespace App\Http\Controllers\Proforma;
use App\Proforma;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use DB;

class ProformaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($empresa)
    {
        $proforma=DB::table('empresas as emp')
        ->join('productos as produ','emp.id','=','produ.empresa_id')
        ->join('detalles as d','produ.id','=','d.id_producto')
        ->join('proformas as prof','d.id_proforma','=','prof.id')
        ->select('prof.numero','prof.descuento','prof.total','prof.estado','emp.id as empresa','prof.id as proforma')->distinct('prof.numero')
        ->where('produ.empresa_id','=',$empresa)
        ->get();
         return response()->json(['data'=>$proforma]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proforma $proforma)
    {   
        $reglas=[
            'estado'=>'max:30',  
        ];
             $this->validate($request,$reglas);
             $proforma->fill($request->Only([ // en caso que al actualizar no entre uno de ellos, esta funcion only lo descarta, se usa cuenta de intersect
                'estado'
            ])); 
 
             if (!$proforma->isDirty()) { //isDirty verifica si hubo un cambio enn olbejeto user, para
                return $this->errorResponse('se debe especificar almenos un valor diferente para actualizar',409);
            }
             $proforma->save();
             return $this->showOne($proforma);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
