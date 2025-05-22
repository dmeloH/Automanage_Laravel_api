<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityRequirement;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Solo si Scramble está disponible (opcional por seguridad)
        if (class_exists(Scramble::class)) {
            Scramble::configure()
                ->withDocumentTransformers(function (OpenApi $openApi) {
                    // Definimos el esquema de seguridad
                    $openApi->components->securitySchemes['BearerToken'] =
                        SecurityScheme::http('bearer', 'JWT');

                    // Lo marcamos como seguridad global (para todas las rutas)
                    $openApi->security[] = new SecurityRequirement([
                        'BearerToken' => [],
                    ]);
                });
        }
    }
}
