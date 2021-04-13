<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Auth; 

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\HttpException;

class LoginController extends Controller
{ 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

       // dd($credentials);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
       
        //dd($validator);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 1,
                'message' => 'Wrong validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = JWTAuth::attempt($credentials);
      // dd($token);

        if ($token) {

            return response()->json([
                'token' => $token,
                'expiresIn' => JWTAuth::factory()->getTTL() * 60,
                'user' => User::where('email', $credentials['email'])->get()->first()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Wrong credentials',
                'errors' => $validator->errors()], 401);
        }
    }
}


