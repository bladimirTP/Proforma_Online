<?php

namespace App\Http\Controllers\Vendedor;

use App\User;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class VendedorEmpresaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
          $empresa= $user->empresas;
          return $this->showAll($empresa);  // recupera las empresas que teien un determinado ususrio
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
            'nombre'=>'required',
            'logo'=>'required|image',
       ];
        $this->validate($request,$reglas);

        if (!$user->esVerificado()) {
            return $this->errorResponse('El vendedor debe ser un usuario verificado',409);
        }
        $data=$request->all();
        $data['nombre']=$request->nombre;
        $data['logo']='image1.jpg';
        $data['user_id'] = $user->id;
        $empresas=Empresa::create($data);
        return $this->showOne($empresas,201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user,Empresa $empresa)
    {
              $reglas=[
                  'nombre'=>'max:300',
                  'logo'=>'image',

              ];
              $this->validate($request,$reglas);
               
              $empresa->fill($request->Only([
                   'nombre',
                   'logo',
                   'estado'
              ]));  
               if($empresa->user_id !=$user->id){
                   return $this->errorResponse('el usuario no es dueño del,producto no puede eliminar',422);
               }

               if (!$empresa->isDirty()) { //isDirty verifica si hubo un cambio enn olbejeto user, para
                return $this->errorResponse('se debe especificar almenos un valor diferente para actualizar',409);
            }
               $empresa->save();
               return $this->showOne($empresa);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Empresa $empresa)
    {
         if($empresa->user_id!= $user->id){
              return $this->errorResponse('usted no es dueño del producto, no puede eliminar el producto',222);
         }
         $empresa->estado=Empresa::DESACTIVAR;
         $empresa->save();
         return $this->showOne($empresa);

    }
}
