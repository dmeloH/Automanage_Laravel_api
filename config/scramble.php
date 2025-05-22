<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * Ruta de tu API. Por defecto, todas las rutas que comienzan con esta ruta se agregarán a la documentación.
     * Si necesitas cambiar este comportamiento, puedes agregar tu propio resolutor de rutas usando `Scramble::routes()`.
     */
    'api_path' => 'api',

    /*
     * Dominio de tu API. Por defecto, se usa el dominio de la aplicación. Esto también es parte del coincidente de rutas de API por defecto,
     * así que si implementas el tuyo propio, asegúrate de usar esta configuración si es necesario.
     */
    'api_domain' => null,

    /*
     * Ruta donde se exportará tu especificación OpenAPI.
     */
    'export_path' => 'api.json',

    'info' => [
        /*
         * Versión de la API.
         */
        'version' => env('API_VERSION', '0.0.1'),

        /*
         * Descripción que se muestra en la página principal de la documentación de la API (`/docs/api`).
         */
        'description' => '/docs/api',
    ],

    /*
     * Personaliza la interfaz de usuario de Stoplight Elements
     */
    'ui' => [
        /*
         * Define el título del sitio web de documentación. Se usa el nombre de la aplicación si esta configuración es `null`.
         */
        'title' => 'API Documentation',

        /*
         * Define el tema de la documentación. Las opciones disponibles son `light` y `dark`.
         */
        'theme' => 'dark',

        /*
         * Oculta la función `Probarlo`. Habilitada por defecto.
         */
        'hide_try_it' => false,

        /*
         * Oculta los esquemas en la tabla de contenido. Habilitado por defecto.
         */
        'hide_schemas' => false,

        /*
         * URL de una imagen que se muestra como un pequeño logotipo cuadrado junto al título, encima de la tabla de contenido.
         */
        'logo' => '',

        /*
         * Se usa para obtener la política de credenciales para la función Probarlo. Las opciones son: omit, include (por defecto), y same-origin.
         */
        'try_it_credentials_policy' => 'include',

        /*
         * Hay tres diseños para Elements:
         * - sidebar - (por defecto de Elements) Diseño de tres columnas con una barra lateral que se puede redimensionar.
         * - responsive - Como sidebar, excepto que en pantallas pequeñas colapsa la barra lateral en un cajón que se puede abrir.
         * - stacked - Todo en una sola columna, útil para integraciones con sitios web que ya tienen su propia barra lateral u otras columnas.
         */
        'layout' => 'responsive',
    ],

    /*
     * Lista de servidores de la API. Por defecto, cuando es `null`, la URL del servidor se creará a partir de
     * las variables de configuración `scramble.api_path` y `scramble.api_domain`. Al proporcionar un array,
     * deberás especificar manualmente la URL del servidor local (si es necesario).
     *
     * Ejemplo de configuración no predeterminada (las URLs finales se generan usando el helper `url` de Laravel):
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    /**
     * Determina cómo Scramble almacena las descripciones de los casos de enums.
     * Opciones disponibles:
     * - 'description' – Las descripciones de los casos se almacenan como la descripción del esquema del enum usando formato de tabla.
     * - 'extension' – Las descripciones se almacenan en la extensión del esquema enum `x-enumDescriptions`.
     *
     *    @see https://redocly.com/docs-legacy/api-reference-docs/specification-extensions/x-enum-descriptions
     * - false - Se ignoran las descripciones de los casos.
     */
    'enum_cases_description_strategy' => 'description',

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
