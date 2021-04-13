<?php

namespace App\Http\Controllers\Cliente;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;

class ClienteController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cli= User::has('proformm')->get();
        return $this->showAll($cli);
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
            'apellido'=>'required',
            'email'=>'required',
            'password'=>'required',
            
        ];
     
        $this->validate($request,$reglas);
        $data= $request->all();
        $data['nombre']=$request->nombre;
        $data['apellido']=$request->apellido;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $data['estado']=User::ACTIVAR;
        $usuario=User::create($data);
        return $this->showOne($usuario, 201);
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
    public function update(Request $request, $user)
    {    
        try {
          $users=User::findOrFail($user);

          $users->nombre= $request->get('nombre');
          $users->apellido= $request->get('apellido');
          $users->email= $request->get('email');
          $users->estado= $request->get('estado');

           $users->update();
            return $this->showOne($users,201);
        } catch (\Throwable $th) {
            dd($th);
        }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario->estado= User::DESACTIVAR;
        $usuario->save();
        return  $this->showOne($usuario);
    }
}
