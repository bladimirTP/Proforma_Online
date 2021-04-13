<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokensController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 1,
                'message' => 'Wrong validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = JWTAuth::attempt($credentials);

        if ($token) {

            return response()->json([
                'token' => $token,
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
