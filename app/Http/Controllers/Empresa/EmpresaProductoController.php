<?php
namespace App\Http\Controllers\Empresa;
use App\Empresa;
use App\Categoria;
use App\Producto;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use DB;
class EmpresaProductoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($empresas)
    {
           // devuleve los productos con incluyendo las categorias
            $productos=DB::table('productos as pro')
            ->join('empresas as p','pro.empresa_id','=','p.id')
            ->join('categorias as dv','pro.categoria_id','=','dv.id')
            ->select('p.id as idempresa','pro.nombre','pro.categoria_id','pro.imagen','pro.precio','pro.descripcion','dv.nombre as categoria','p.nombre as empresa','pro.estado','pro.id','dv.id as idcategoria')
            ->where('p.id','=',$empresas)
            ->get();
             return response()->json(['data'=>$productos]);
 
        //  $producto= $empresas->productos()->whereHas('categorias')->with('categorias')
        //  ->get()
        //  ->pluck('categorias')
        //  ->collapse()
        //  ->unique()
        //  ->values();
        //   return $this->showAll($producto);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Empresa $empresa, Categoria $categoria)
    {
        $reglas=[
            'nombre'=>'required',
            'precio'=>'required',
            //'imagen',
            'cantidad'=>'required',
            'marca'=>'required',
            'descripcion'=>'required'
       ];
        $this->validate($request,$reglas);
       
        $data=$request->all();
        $data['nombre']=$request->nombre;
        $data['precio']=$request->precio;
        $var=$empresa->nombre;
           if(Input::hasFile('imagen')){
            $file = Input::file('imagen');
            $file->move(public_path()."/imagenes/$var/",$file->getClientOriginalName());
            $data['imagen'] = $file->getClientOriginalName();
          }
        $data['cantidad']=$request->cantidad;
        $data['marca']=$request->marca;
        $data['estado']='activo';
        $data['descripcion']=$request->descripcion;
        $data['categoria_id'] = $categoria->id;
        $data['empresa_id'] = $empresa->id;
        $productos=Producto::create($data);
        return $this->showOne($productos,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa,Categoria $categoria,Producto $producto)
    {
        $reglas=[
            'nombre'=>'max:100',
            
       ];
         $this->validate($request,$reglas);
         $producto->fill($request->Only([ // en caso que al actualizar no entre uno de ellos, esta funcion only lo descarta, se usa cuenta de intersect
            'nombre',
            'precio',
            'imagen',
            'cantidad',
            'marca',
            'estado',
            'descripcion',
            'categoria_id',
            'empresa_id'
        
        ])); 

         if (!$producto->isDirty()) { //isDirty verifica si hubo un cambio enn olbejeto user, para
            return $this->errorResponse('se debe especificar almenos un valor diferente para actualizar',409);
        }
        $var=$empresa->nombre;
           if(Input::hasFile('imagen')){
            $file = Input::file('imagen');
            $file->move(public_path()."/imagenes/$var/",$file->getClientOriginalName());
            $producto->imagen= $file->getClientOriginalName();
          }
          
        $producto->save();
        return $this->showOne($producto,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        
    }
}
