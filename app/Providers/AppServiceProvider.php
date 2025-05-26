<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Middleware para autorizar accesos basados en roles usando JWT.
 */
class RoleAuthorization
{
    /**
     * Maneja la solicitud entrante y verifica si el usuario tiene uno de los roles permitidos.
     *
     * @param Request $request La solicitud HTTP entrante.
     * @param Closure $next La siguiente función middleware a ejecutar.
     * @param string $roles Coma separada, lista de roles permitidos (por ejemplo: "admin,cliente").
     * @return Response Una respuesta HTTP, ya sea continuando o rechazando la solicitud.
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        try {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->unauthorized('Tu token ha expirado. Por favor, vuelve a iniciar sesión.');
        } catch (TokenInvalidException $e) {
            return $this->unauthorized('Tu token no es válido. Vuelve a iniciar sesión.');
        } catch (JWTException $e) {
            return $this->unauthorized('Por favor, adjunte un Token de Portador a su solicitud');
        }

        // Convertir string de roles en array
        $allowedRoles = explode(',', $roles);

        if ($user && in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    /**
     * Devuelve una respuesta JSON no autorizada.
     *
     * @param string|null $message Mensaje de error personalizado.
     * @return \Illuminate\Http\JsonResponse Respuesta con código 401.
     */
    private function unauthorized($message = null)
    {
        return response()->json([
            'message' => $message ?? 'No está autorizado para acceder a este recurso.',
            'success' => false
        ], 401);
    }
}
