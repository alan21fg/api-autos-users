<?php

namespace App\Http\Controllers;

use App\Models\Autos;
use Illuminate\Http\Request;

class AutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autos = Autos::all();
        return response()->json($autos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'año' => 'required|integer|digits:4',
            'color' => 'required|string|max:30',
            'matricula' => 'required|string|max:20',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|string|max:20',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|url|max:255',
        ]);

        $autos = Autos::create($validatedData);

        return response()->json($autos, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            return response()->json(['message' => 'Auto no encontrado'], 404);
        }

        return response()->json($autos, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            return response()->json(['message' => 'Auto no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'marca' => 'sometimes|string|max:50',
            'modelo' => 'sometimes|string|max:50',
            'año' => 'sometimes|integer|digits:4',
            'color' => 'sometimes|string|max:30',
            'matricula' => 'sometimes|string|max:20',
            'precio' => 'sometimes|numeric|min:0',
            'estado' => 'sometimes|string|max:20',
            'descripcion' => 'sometimes|string',
            'imagen' => 'nullable|url|max:255',
        ]);

        $autos->update($validatedData);

        return response()->json($autos, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            return response()->json(['message' => 'Auto no encontrado'], 404);
        }

        $autos->delete();
        return response()->json(null, 204);
    }
}
