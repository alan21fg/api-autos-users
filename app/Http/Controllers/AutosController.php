<?php

namespace App\Http\Controllers;

use App\Models\Autos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autos = Autos::all();
        $data = [
            'autos' => $autos,
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

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $autos = Autos::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'año' => $request->año,
            'color' => $request->color,
            'matricula' => $request->matricula,
            'precio' => $request->precio,
            'estado' => $request->estado,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
        ]);

        if (!$autos) {
            $data = [
                'message' => 'Error al crear auto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'auto' => $autos,
            'status' => 201
        ];

        return response()->json($autos, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $auto = Autos::find($id);

        if (!$auto) {
            $data = [
                'message'=> 'Auto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'auto'=> $auto,
            'status'=> 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            $data = [
                'message'=> 'Auto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = Validator::make($request->all(), [
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

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $autos->marca = $request->marca;
        $autos->modelo =  $request->modelo;
        $autos->año = $request->año;
        $autos->color = $request->color;
        $autos->matricula = $request->matricula;
        $autos->precio = $request->precio;
        $autos->estado = $request->estado;
        $autos->descripcion = $request->descripcion;
        $autos->imagen =  $request->imagen;
        $autos->update();

        $data = [
            'message'=> 'Auto actualizado',
            'auto'=> $autos,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            $data = [
                'message'=> 'Auto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $autos->delete();

        $data = [
            'message'=> 'Auto eliminado',
            'status'=> 200
        ];
        return response()->json($data, 204);
    }

    public function updatePartial(Request $request, $id)
    {
        $autos = Autos::find($id);

        if (!$autos) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validatedData = Validator::make($request->all(), [
            'marca' => 'string|max:50',
            'modelo' => 'string|max:50',
            'año' => 'integer|digits:4',
            'color' => 'string|max:30',
            'matricula' => 'string|max:20',
            'precio' => 'numeric|min:0',
            'estado' => 'string|max:20',
            'descripcion' => 'string',
            'imagen' => 'nullable|url|max:255',
        ]);

        if ($validatedData->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validatedData->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('marca')) {
            $autos->marca = $request->marca;
        }
        if ($request->has('modelo')) {
            $autos->modelo = $request->modelo;
        }
        if ($request->has('año')) {
            $autos->año = $request->año;
        }
        if ($request->has('color')) {
            $autos->color = $request->color;
        }
        if ($request->has('matricula')) {
            $autos->matricula = $request->matricula;
        }
        if ($request->has('precio')) {
            $autos->precio = $request->precio;
        }
        if ($request->has('estado')) {
            $autos->estado = $request->estado;
        }
        if ($request->has('descripcion')) {
            $autos->descripcion = $request->descripcion;
        }
        if ($request->has('imagen')) {
            $autos->imagen = $request->imagen;
        }

        $autos->save();

        $data = [
            'message' => 'Auto actualizado',
            'auto' => $autos,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
