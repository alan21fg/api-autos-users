<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Credenciales inválidas',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'No autorizado',
                'status' => 401
            ], 401);
        }

        $user = JWTAuth::user();

        return response()->json([
            'token' => $token,
            'user' => $user,
            'status' => 200
        ], 200);
    }
}
