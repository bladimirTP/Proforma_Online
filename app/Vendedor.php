<?php

namespace App;
use App\Empresa;

class Vendedor extends User
{
    public function empresas(){
        return  $this->hasMany(Empresa::class);
    }
     
}
