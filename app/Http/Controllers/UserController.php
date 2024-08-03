<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $data = [
            'usuarios' => $users,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'user' => 'required|string|max:255|unique:users',
            'image' => 'required|url',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user = User::create([
            'name' => $request->name,
            'last' => $request->last,
            'user' => $request->user,
            'image' => $request->image,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            $data = [
                'message' => 'Error al crear usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $user,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'usuario' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'user' => 'required|string|max:255|unique:users',
            'image' => 'required|url',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $user->name = $request->name;
        $user->last = $request->last;
        $user->user = $request->user;
        $user->image = $request->image;
        $user->email = $request->email;
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        $data = [
            'message' => 'Usuario actualizado',
            'auto' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $user->delete();

        $data = [
            'message' => 'Auto eliminado',
            'status' => 200
        ];
        return response()->json($data, 204);
    }

    public function updatePartial(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'last' => 'string|max:255',
            'user' => 'string|max:255|unique:users',
            'image' => 'nullable|url',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:8',
        ]);

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('last')) {
            $user->last = $request->last;
        }
        if ($request->has('user')) {
            $user->user = $request->user;
        }
        if ($request->has('image')) {
            $user->image = $request->image;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $data = [
            'message' => 'Usuario actualizado',
            'auto' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos de entrada inválidos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        // Intentar autenticar al usuario
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales inválidas',
                'status' => 401,
            ], 401);
        }

        // Retornar el token JWT
        return response()->json([
            'token' => $token,
            'status' => 200,
        ], 200);
    }

}
