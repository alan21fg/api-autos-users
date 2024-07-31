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
        return Autos::all();
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
    public function show(Autos $autos)
    {
        return Autos::find($autos->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Autos $autos)
    {
        $request->validate([
            "marca" => "required",
            "modelo" => "required",
            "año" => "required",
            "color" => "required",
            "matricula" => "required",
            "precio" => "required",
            "estado" => "required",
            "descripcion" => "required"
        ]);

        $autos->marca = $request->marca;
        $autos->modelo = $request->modelo;
        $autos->año = $request->año;
        $autos->color = $request->color;
        $autos->matricula = $request->matricula;
        $autos->precio = $request->precio;
        $autos->estado = $request->estado;
        $autos->descripcion = $request->descripcion;
        $autos->imagen = $request->imagen;
        $autos->update();

        return $autos;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autos $autos)
    {
        $autos = Autos::find($autos->id);

        if (is_null($autos)) {
            return response()->json('No se pudo realizar correctamente la operción', 404);
        }

        $autos->delete();
        return response()->noContent();
    }
}
