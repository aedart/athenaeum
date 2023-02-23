<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Exporter
    |--------------------------------------------------------------------------
    |
    | Name of default translations exporter profile to use, when none specified.
    */

    'default_exporter' => env('DEFAULT_TRANSLATIONS_EXPORTER', 'default'),

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

        // In case that you do not have laravel's default translations published, you might want
        // to include this path...
        // realpath(__DIR__ . '/../vendor/laravel/framework/src/Illuminate/Translation/lang')
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces and Json
    |--------------------------------------------------------------------------
    |
    | Register namespaced translations and paths to JSON translations. Use this
    | when you want to use 3rd part translations without having to register
    | their service providers.
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

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__'
            ],
        ],

        'lang_js' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsExporter::class,
            'options' => [

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__'
            ],
        ],

        'lang_js_json' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsJsonExporter::class,
            'options' => [

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__',

                // JSON encoding options
                'json_options' => 0,
                'depth' => 512
            ],
        ],
    ]
];
