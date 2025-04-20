<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Swagger API Title and Description
    |--------------------------------------------------------------------------
    |
    | Set your API's title and description here.
    |
    */

    'swagger' => [
        'api' => [
            'title' => 'Customer API',  // API ka title
            'description' => 'API for managing customers',  // API ki description
            'version' => '1.0.0',  // API ka version
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Swagger Routes Configuration
    |--------------------------------------------------------------------------
    |
    | The routes below will be used to access the Swagger UI and the API docs.
    |
    */
    'routes' => [
        'api' => 'api/documentation',  // Swagger documentation ka route
        'swagger_ui' => 'api/docs',     // Swagger UI ka route
    ],

    /*
    |--------------------------------------------------------------------------
    | Generate Documentation Automatically
    |--------------------------------------------------------------------------
    |
    | If this is set to `true`, Swagger docs will be regenerated automatically.
    |
    */
    'generate_always' => true,

    'generate_docs' => true,
    'use_annotations' => true,

];
