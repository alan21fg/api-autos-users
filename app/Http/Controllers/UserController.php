<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\UseUse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'user' => 'required|string|max:255|unique:users',
            'image' => 'required|url',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Crear el usuario con valores predeterminados para los campos no proporcionados
        $user = User::create([
            'name' => $validatedData['name'],
            'last' => $validatedData['last'],
            'user' => $validatedData['user'],
            'image' => $validatedData['image'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'email_verified_at' => null, // Por defecto, sin verificar
            'remember_token' => null,    // No se establece
        ]);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return User::findOrFail($user->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'last' => 'sometimes|string|max:255',
            'user' => 'sometimes|string|max:255|unique:users,user,' . $user->id,
            'image' => 'sometimes|url',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        // Actualizar solo los campos que están presentes en el request
        $user->update($validatedData);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);

        if (is_null($user)) {
            return response()->json('No se pudo realizar correctamente la operción', 404);
        }

        $user->delete();
        return response()->noContent();
    }
}
