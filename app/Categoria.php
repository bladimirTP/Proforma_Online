<?php

namespace App;
use App\Producto;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    const ACTIVAR= 'activo';
    const DESACTIVAR='inactivo';
    public $timestamps= false; 
    protected $fillable = [
          'nombre',
          'estado',
          
      ];

    public function productos(){
        return $this->hasMany(Producto::class);
    }


    public function estaDisponibleact(){
        return $this->estado == Categoria::ACTIVAR;
    }
    public function noDisponibleact(){
        return $this->estado == Categoria::INACTIVAR;
    }
}
