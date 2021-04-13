<?php

namespace App;
use App\Empresa;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    const USUARIO_VERIFICADO= '1';
    const USUARIO_NO_VERIFICADO= '0';
    const USUARIO_ADMINISTRADOR= 'true';
    const USUARIO_REGULAR = 'false';

    const ACTIVAR= 'activo';
    const DESACTIVAR='inactivo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 
        'apellido', 
        'email', 
        'admin',   
        'estado',
        'password',
    ];
    public $timestamps= false; 
        //mustadores: un mutador se encarga de modificar un atributo antes de ser insertado
        //tambien modifica  al obtener de la base de datos para mostrar al usurio
        public function SetNombreAttribute($valor){  //transforma el nombre en minuscula 
             $this->attributes['nombre']=strtolower($valor);
        }
      
         //tambien modifica  al obtener de la base de datos para mostrar al usurio
         public function getNombreAttribute($valor){
             return ucwords($valor);
        }
        public function getApellidoAttribute($valor){
            return ucwords($valor);
       }
        public function SetEmailAttribute($valor){  //transforma el nombre en minuscula 
            $this->attributes['email']=strtolower($valor);
        }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'password',
         'remember_token',
         'verification_token',
 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function empresas(){
        return  $this->hasMany(Empresa::class);
    }
    public function proformm(){
        return  $this->hasMany(Proforma::class);
    }

    // funciones extras
     // asumimos que estas funciones , llamados mutadores y accesore
    // se ejecutan automaticamenet
    // un mutador se utiliza un dato antes de ineratra a la base de datos
    // un accesor saca de la base de datos y lo cambia, y lo devuelve a la interfas

   
    public function esVerificado(){
        return $this->verificado == User::USUARIO_VERIFICADO;
    }
    public function esAdministrador(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }
    public static function generarVerificationToken(){
        return str_random(40);
    }


    //// Auth

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
     
}
