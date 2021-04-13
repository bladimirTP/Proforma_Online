<?php

namespace App;
use App\Producto;
use App\Proforma;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $fillable=[
        'id_proforma',
         'id_producto',
         'cantidad',
         'costo',
         'total',
    ];
    public $timestamps= false; 
  public function proformas(){
      return $this->belongsToMany(Proforma::Class);
  }
  public function productos(){

    return $this->belongsToMany(Producto::Class);
  }
}
