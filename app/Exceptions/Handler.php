<?php

namespace App\Exceptions;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// clases de errores importados
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Queryexception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use  ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
      
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //return parent::render($request, $exception);
        // error al hacer un post, es decir, si los datos estan vacios
        if($exception instanceof ValidationException){
            return $this->errorvalidationpost($exception,$request);
        }
          // error modelo no encontrado es decir al hacer un get, no existe el dato solicitado
         if ($exception Instanceof ModelNotFoundException) {
              $modelo = strtolower(class_basename($exception->getModel()));
              return $this->errorResponse("no existe ninguna instancia de {$modelo} especificado" , 404);
         } 
         if ($exception Instanceof AuthenticationException) {
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->unauthenticated($request, $exception);
         } 
         if ($exception Instanceof AuthorizationException) {
            
            return $this->errorResponse('No posee permisos para ejecutar esta accion',403);
         }    
         // error al no encontrar una ruta especifica al hacer una peticion
         if ($exception Instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la URl especificada',404);
         }
            // error al  enviar desde el cliente un metodo que no le pertenece a dicha ruta. entonces mostramos este emensaje
         if ($exception Instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El metodo especificado en la peticion no es valido',405);
         }
         // otros errores http.. menos importantes,
         if ($exception Instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
         }
           // error para controlar errores de integridad con la base de datso ->QueryException
         if ($exception Instanceof  QueryException) {
             $codigo= $exception->errorInfo[1];
             if ($codigo==1451) {
                return $this->errorResponse('No se puede Eliminar de forma permanente el recurso por que esta relacionado con algun otro',409);
             }
           
         }
         // errores inesperados del servidor , por ejemplo la base de datos podria estar caido
         if (config('app.debug')) {
            return parent::render($request, $exception);
         }
         return $this->errorResponse('Falla inesperada,Intente luego',500);

    }
    /** 
     * Create a response object from the given validation
     * 
     * @param \Illuminate\Validation\ValidationException $e
     *  @param \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
    */
    protected function errorvalidationpost(ValidationException $e,$request)
    {
        $errors = $e->validator->errors()->getMessages();
       return $this->errorResponse($errors,422);
       // return response()->json($error,422);
       //convertValidationExceptionToResponse-> nombre de la funcion
    }
}
