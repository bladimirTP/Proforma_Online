<?php

namespace App\Http\Controllers\Empresa;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Input;

class EmpresaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $empresa= Empresa::all();
         return $this->showAll($empresa);
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
    if (!$request->id) {
        $reglas=[
            'nombre'=>'required',
            'user_id'=>'required',
            //'imagen',
       ];
        $this->validate($request,$reglas);
        $data=$request->all();
        $data['nombre']=$request->nombre;
        $data['user_id']=$request->user_id;
        $var=$request->nombre;
        $logo='logo';
           if(Input::hasFile('imagen')){
            $file = Input::file('imagen');
            $file->move(public_path()."/imagenes/$var/$logo",$file->getClientOriginalName());
            $data['logo'] = $file->getClientOriginalName();
          }
        $data['estado']='activo';
        $empresa=Empresa::create($data);
        return $this->showOne($empresa,201); 
    }else{
       $empresa= Empresa::findOrFail($request->id);
        $empresa->nombre=$request->get('nombre');
        $empresa->estado=$request->get('estado');
        $var=$request->nombre;
        $logo='logo';
           if(Input::hasFile('imagen')){
            $file = Input::file('imagen');
            $file->move(public_path()."/imagenes/$var/$logo",$file->getClientOriginalName());
            $empresa->logo= $file->getClientOriginalName();
          }
        $empresa->update();
        return $this->showOne($empresa,201);
    }
  
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
    public function update(Request $request, $id)
    {
       
        // $data=$request->all();
        // $data['nombre']=$request->nombre;
        // $data['logo']=$request->logo;
        // $data['estado']=$request->estado;
        // $var=$request->nombre;
        // $logo='logo';
        //    if(Input::hasFile('imagen')){
        //     $file = Input::file('imagen');
        //     $file->move(public_path()."/imagenes/$var/$logo",$file->getClientOriginalName());
        //     $data['logo'] = $file->getClientOriginalName();
        //   }
        // $empresa=Empresa::update($data);
        // return $this->showOne($empresa,201); 
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         
    }
}
