<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Exporter
    |--------------------------------------------------------------------------
    |
    | Name of default translations exporter profile to use, when none specified.
    */

    'default_exporter' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Language Directories
    |--------------------------------------------------------------------------
    |
    | Paths to directories that contain language files. Typically, this should
    | only be your application's language directory. Paths are ONLY used for
    | auto-discovery of available locales and groups.
    */

    'paths' => [
        lang_path(),
        realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces and Json
    |--------------------------------------------------------------------------
    |
    | Namespaces and paths to JSON translations to be registered. Use this to
    | deal with 3rd party service providers that offer translations, yet are
    | marked as deferrable and possibly not available during export.
    */

    'namespaces' => [
        //'acme' => realpath(__DIR__ . '/../vendor/acme/package/lang'),
    ],

    'json' => [
        //realpath(__DIR__ . '/../vendor/acme/package/lang')
    ],

    /*
    |--------------------------------------------------------------------------
    | Exporter Profiles
    |--------------------------------------------------------------------------
    |
    | List of available exporter profiles
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Translation\Exports\Drivers\ArrayExporter::class,
            'options' => [
                'json_key' => '__JSON__'
            ],
        ],

        'lang_js' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsExporter::class,
            'options' => [
                'json_key' => '__JSON__'
            ],
        ],


        'lang_js_json' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsJsonExporter::class,
            'options' => [
                'json_key' => '__JSON__',
                'json_options' => 0,
                'depth' => 512
            ],
        ],

        'null' => [
            'driver' => \Aedart\Translation\Exports\Drivers\NullExporter::class,
            'options' => [
                // N/A
            ],
        ],
    ]
];