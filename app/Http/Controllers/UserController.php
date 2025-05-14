<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from the 'users' table
        $users = Usuario::all();

        // Return the records as a JSON response
        return response()->json($users);
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
        $request->validate([
            'direccion' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'tipo' => 'required|string|max:50',
            'username' => 'required|string|max:50'
        ]);

        // Create a new record in the 'users' table
        $user = Usuario::create($request->all());

        // Return the created record as a JSON response
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the record by ID
        $user = Usuario::find($id);

        // If the record is not found, return a 404 response
        if (!$user) {
            return response()->json(['message' => 'User no encontrado'], 404);
        }

        // Return the record as a JSON response
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $request->validate([
            'direccion' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'nombre' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|min:8',
            'telefono' => 'sometimes|required|string|max:15',
            'tipo' => 'sometimes|required|string|max:50',
            'username' => 'sometimes|required|string|max:50'
        ]);

        // Find the record by ID
        $user = Usuario::find($id);

        // If the record is not found, return a 404 response
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Update the record with the new data
        $user->update($request->all());

        // Return the updated record as a JSON response
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the record by ID
        $user = Usuario::find($id);

        // If the record is not found, return a 404 response
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Delete the record
        $user->delete();

        // Return a success message
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}
