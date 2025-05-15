<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::all();
        if ($citas->isEmpty()) {
            return response()->json(['message' => 'No hay recursos dispinibles.'], 404);
        }

        return response()->json($citas, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caracteristicas' => 'required|string|max:255',
            'fechaCita' => 'required|date',
            'fechaPeticion' => 'required|date',
            'registroVehiculo_Id' => 'integer|exists:vehiculos,id',
            'usuario_id' => 'required|integer|exists:usuarios,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cita = Cita::create($request->all());

        return response()->json($cita, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'No se encontro el recurso.'], 404);
        }
        return response()->json($cita, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'caracteristicas' => 'string|max:255',
            'fechaCita' => 'date',
            'fechaPeticion' => 'date',
            'registroVehiculo_Id' => 'integer|exists:vehiculos,id',
            'usuario_id' => 'integer|exists:usuarios,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        $cita->update($request->all());
        return response()->json($cita);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }
        $cita->delete();
        return response()->json(['message' => 'Cita eliminada con éxito']);
    }
}
