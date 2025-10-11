<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        try {
            // Autenticar usuario desde el token JWT
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no encontrado',
                    'success' => false
                ], 401);
            }

            // Cargar la relación role si no está cargada
            if (!$user->relationLoaded('role')) {
                $user->load('role');
            }

            // Convertir string de roles en array
            $allowedRoles = explode(',', $roles);

            // Verificar si el rol del usuario está permitido
            if (in_array($user->role->name, $allowedRoles)) {
                return $next($request);
            }

            return response()->json([
                'message' => 'Acceso denegado: permisos insuficientes',
                'success' => false
            ], 403);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token expirado',
                'error' => 'token_expired',
                'success' => false
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Token inválido',
                'error' => 'token_invalid',
                'success' => false
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token no proporcionado',
                'error' => 'token_absent',
                'success' => false
            ], 401);
        }
    }
}
