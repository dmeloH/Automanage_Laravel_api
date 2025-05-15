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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $response = null;
        try {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {
            $response = $this->unauthorized('Tu token ha expirado. Por favor, vuelve a iniciar sesión.');
        } catch (TokenInvalidException $e) {
            $response = $this->unauthorized('Tu token no es válido. Vuelve a iniciar sesión.');
        } catch (JWTException $e) {
            $response = $this->unauthorized('Por favor, adjunte un Token de Portador a su solicitud');
        }

        if ($response === null) {
            // Convertir string de roles en array
            $allowedRoles = explode(',', $roles);

            if ($user && in_array($user->role, $allowedRoles)) {
                $response = $next($request);
            } else {
                $response = $this->unauthorized();
            }
        }

        return $response;
    }


    private function unauthorized($message = null)
    {
        return response()->json([
            'message' => $message ? $message : 'No está autorizado para acceder a este recurso.',
            'success' => false
        ], 401);
    }
}
