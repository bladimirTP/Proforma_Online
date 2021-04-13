<?php
namespace App\Traits;
use response;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    private function sucessResponse($data,$code){
        return response()->json($data,$code);
    }
    protected function errorResponse($message,$code){
      return response()->json(['error'=>$message,'code'=>$code],$code);
    }

    protected function showAll(Collection $collection,$code=200){
        return $this->sucessResponse(['data'=>$collection],$code);
    }
    protected function showOne(Model $instance, $code = 200){
      return $this->sucessResponse(['data'=> $instance],$code);
    }
    protected function showMessage($message, $code = 200){
      return $this->sucessResponse(['data'=> $message],$code);
    }
}