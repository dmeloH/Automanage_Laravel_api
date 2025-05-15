<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from the 'vehiculos' table
        $vehiculos = Vehiculo::all();

        // Return the records as a JSON response
        return response()->json($vehiculos, 201);
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
            'cilindraje' => 'required|integer',
            'imagen' => 'nullable|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'placa' => 'required|string|max:10',
            'usuario_id' => 'required|integer|exists:usuarios,id'
        ]);

        // If validation fails, return a 422 response with the errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // Check if the 'placa' already exists in the database
        $existingVehiculo = Vehiculo::where('placa', $request->placa)->first();
        if ($existingVehiculo) {
            return response()->json(['message' => 'La placa ya existe'], 422);
        }
        // Create a new record in the 'vehiculos' table
        $vehiculo = Vehiculo::create($request->all());

        // Return the created record as a JSON response
        return response()->json($vehiculo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the record by ID
        $vehiculo = Vehiculo::find($id);

        // If the record is not found, return a 404 response
        if (!$vehiculo) {
            return response()->json(['message' => 'Vehiculo no encontrado'], 404);
        }

        // Return the record as a JSON response
        return response()->json($vehiculo, 201);
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
            'cilindraje' => 'required|integer',
            'imagen' => 'nullable|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'placa' => 'required|string|max:10',
            'usuario_id' => 'required|integer|exists:usuarios,id'
        ]);
        // If validation fails, return a 422 response with the errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        // Find the record by ID
        $vehiculo = Vehiculo::find($id);

        // If the record is not found, return a 404 response
        if (!$vehiculo) {
            return response()->json(['message' => 'Vehiculo no encontrado', 404], 404);
        }

        // Update the record with the new data
        $vehiculo->update($request->all());

        // Return the updated record as a JSON response
        return response()->json($vehiculo, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the record by ID
        $vehiculo = Vehiculo::find($id);

        // If the record is not found, return a 404 response
        if (!$vehiculo) {
            return response()->json(['message' => 'Vehiculo no encontrado'], 404);
        }

        // Delete the record
        $vehiculo->delete();

        // Return a success message
        return response()->json(['message' => 'Vehiculo eliminado con éxito', 200]);
    }
}
