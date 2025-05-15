<?php

namespace App\Http\Controllers;

use App\Models\Registrosmante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistroManteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from the 'registro_mante' table
        $registros = Registrosmante::all();
        // If no records are found, return a 404 response
        if ($registros->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }

        // Return the records as a JSON response
        return response()->json($registros, 201);
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'caracteristicas' => 'required|string|max:255',
            'fechaMante' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|integer',
            'fechaPeticion' => 'required|date',
            'citas_id' => 'integer|exists:citas,id',
            'registroVehiculo_Id' => 'required|integer|exists:vehiculos,id',

        ]);

        // If validation fails, return a 422 response with the errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new record in the 'registro_mante' table
        $registro = Registrosmante::create($request->all());

        // Return the created record as a JSON response
        return response()->json($registro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the record by ID
        $registro = Registrosmante::find($id);

        // If the record is not found, return a 404 response
        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Return the record as a JSON response
        return response()->json($registro, 201);
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'caracteristicas' => 'string|max:255',
            'fechaMante' => 'date',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre' => 'string|max:255',
            'precio' => 'integer',
            'fechaPeticion' => 'date',
            'citas_id' => 'integer|exists:citas,id',
            'registroVehiculo_Id' => 'integer|exists:vehiculos,id',
        ]);
        // If validation fails, return a 422 response with the errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the record by ID
        $registro = Registrosmante::find($id);

        // If the record is not found, return a 404 response
        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Update the record with the new data
        $registro->update($request->all());

        // Return the updated record as a JSON response
        return response()->json($registro, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the record by ID
        $registro = Registrosmante::find($id);

        // If the record is not found, return a 404 response
        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Delete the record
        $registro->delete();

        // Return a success message
        return response()->json(['message' => 'Registro eliminado con éxito', 200]);
    }
}
