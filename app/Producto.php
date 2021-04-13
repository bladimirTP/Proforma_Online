<?php

namespace App;
use App\Categoria;
use App\Empresa;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    
     protected $fillable=[
         'categoria_id',
         'empresa_id',
          'nombre',
          'precio',
          'imagen',
          'cantidad',
          'marca',
          'estado',
          'descripcion',
     ];
     const ACTIVAR= 'activo';
     const DESACTIVAR='inactivo';
     public $timestamps= false;
     public function categorias(){
          return $this->belongsToMany(Categoria::Class);
       }
       public function empresas(){
           return $this->belongsToMany(Empresa::Class);
       }
       public function detalles(){
          return $this->belongsToMany(Producto::Class);
      }
}
