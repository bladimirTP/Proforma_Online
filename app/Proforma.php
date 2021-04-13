<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $fillable=[
        'numero',
        'descuento',
        'total',
        'estado',
        'id_cliente',
    ];
    public $timestamps= false; 

    public function clientes(){
        return $this->belongsToMany(User::Class);
    }
    public function detalles(){
        return $this->hasMany(Detalle::Class);
    }
}
