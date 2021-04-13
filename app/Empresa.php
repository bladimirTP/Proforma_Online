<?php

namespace App;
use App\Vendedor;
use App\Producto;
use Illuminate\Database\Eloquent\Model;



class Empresa extends Model
{

    const ACTIVAR= 'activo';
    const DESACTIVAR='inactivo';
     protected $fillable=[
         'user_id',
         'nombre',
         'logo',
         'estado',
     ];
     
     public $timestamps= false; 
     public function productos(){
         return $this->hasMany(Producto::class);
     }

    
     public function vendedor(){
        return $this->belongsTo(User::class);
  
     }

     public function estaDisponible(){
        return $this->estado == Empresa::ACTIVAR;
    }
    public function noDisponible(){
        return $this->estado == Empresa::INACTIVAR;
    }
}
