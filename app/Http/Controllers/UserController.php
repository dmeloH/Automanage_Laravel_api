<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from the 'users' table
        $users = Usuario::all();
        // If no records are found, return a 404 response
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No se encontraron usuarios'], 404);
        }

        // Return the records as a JSON response
        if ($users) {
            $data = [
                'status' => true,
                'message' => 'Usuarios encontrados',
                'data' => $users
            ];
            return response()->json($data, 200);
        }
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
            'direccion' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'role' => 'string|max:50',
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8'

        ]);

        // If validation fails, return a 422 response with the errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
        // Check if the email already exists in the database
        $existingUser = Usuario::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'status' => false,
                'message' => 'El correo electrónico ya está en uso'
            ], 422);
        }
        // Check if the username already exists in the database
        $existingUser = Usuario::where('username', $request->username)->first();
        if ($existingUser) {
            return response()->json([
                'status' => false,
                'message' => 'El nombre de usuario ya está en uso'
            ], 422);
        }
        // Hash the password before storing it
        $request->merge(['password' => bcrypt($request->password)]);

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
        $request->validate([
            'direccion' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'nombre' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|min:8',
            'telefono' => 'sometimes|required|string|max:15',
            'tipo' => 'sometimes|required|string|max:50',
            'username' => 'sometimes|required|string|max:50'
        ]);

        $user = Usuario::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Validación de email único
        if ($request->filled('email')) {
            $existingUser = Usuario::where('email', $request->email)->where('id', '!=', $id)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'El correo electrónico ya está en uso'
                ], 422);
            }
        }

        // Validación de username único
        if ($request->filled('username')) {
            $existingUser = Usuario::where('username', $request->username)->where('id', '!=', $id)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'El nombre de usuario ya está en uso'
                ], 422);
            }
        }

        $fields = $request->only(['direccion', 'email', 'nombre', 'telefono', 'tipo', 'username']);
        $user->fill($fields);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $user
        ]);
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
