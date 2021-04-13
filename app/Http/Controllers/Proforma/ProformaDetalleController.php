<?php

namespace App\Http\Controllers\Proforma;

use App\User;
use App\Producto;
use App\Detalle;
use App\Proforma;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use DB;

class ProformaDetalleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
    public function store(Request $request, User $user)
    {
          $reglas=[
               'total'=>'required'
          ];
           $this->validate($request,$reglas);
           if (!$user->esVerificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado',409);
            }
         $var = DB::table('proformas')->max('numero');
          
         try{
           DB::beginTransaction();
           $proforma= new Proforma; 
           $proforma->user_id=$user->id;
           $proforma->estado='por confirmar';
           $proforma->descuento=$request->get('descuento');
           $proforma->total=$request->get('total');
           $proforma->numero=$var+1;
         
           //$mytime= Carbon::now('America/Lima');
           //$venta->fecha_hora=$mytime->toDateTimeString();
         
           $proforma->save();
      
           //todo estos son arreglos Array
            $id_producto= $request->get('id_producto');
            $cantidad= $request->get('pcantidad');
            $costo= $request->get('pcosto');
          
             $cont=0;
   
             while ($cont<count($id_producto)) {
                  $detalle= new Detalle;
                  $detalle->id_proforma=$proforma->id;
                  $detalle->id_producto=$id_producto[$cont];
                  $detalle->cantidad=$cantidad[$cont];
                  $detalle->costo=$costo[$cont];
                  $detalle->save();
                  $cont=$cont+1;
             }
   
             DB::commit();
   
         }catch(\exeption $e){
   
           DB::rollback();
         }
         //return Redirect::to('shoping/productolista/create');
         return $this->showOne($detalle);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
