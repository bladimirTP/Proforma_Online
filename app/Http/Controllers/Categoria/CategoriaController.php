<?php

namespace App\Http\Controllers\Categoria;
use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $categorias= Categoria::all();
           return $this->showAll($categorias);
        //return response()->json(['data'=>$categoria],200);
       // return response()->json(['data'=> $usuarios],200); 
       
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
        $reglas = [
            'nombre' => 'required',
        ];
     
        $this->validate($request,$reglas);
        $data= $request->all();
        $data['estado']=Categoria::ACTIVAR;
        $categoria= Categoria::create($data);

        return $this->showOne($categoria, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
          return $this->showOne($categoria);
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
    public function update(Request $request, Categoria $categoria)
    {
        $reglas=[
            'nombre'=>'max:250',
        
        ];
             $this->validate($request,$reglas);
             $categoria->fill($request->Only([ // en caso que al actualizar no entre uno de ellos, esta funcion only lo descarta, se usa cuenta de intersect
                'nombre',
                'estado'
            ])); 
 
             if (!$categoria->isDirty()) { //isDirty verifica si hubo un cambio enn olbejeto user, para
                return $this->errorResponse('se debe especificar almenos un valor diferente para actualizar',409);
            }
             $categoria->save();
             return $this->showOne($categoria);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {   
        $categoria->estado= Categoria::DESACTIVAR;
        $categoria->save();
        return  $this->showOne($categoria);
     
    }
}
