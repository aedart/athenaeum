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
    | Exporter Profiles
    |--------------------------------------------------------------------------
    |
    | List of available exporter profiles
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Translation\Exports\Drivers\ArrayExporter::class,
            'options' => [

                'paths' => [

                    // Application's "lang" directory...
                    lang_path(),

                    // In case that you do not have laravel's default translations published, you might want
                    // to include this path...
                    // realpath(__DIR__ . '/../vendor/laravel/framework/src/Illuminate/Translation/lang')

                ],

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__'
            ],
        ],

        'lang_js' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsExporter::class,
            'options' => [

                'paths' => [

                    // Application's "lang" directory...
                    lang_path(),

                    // In case that you do not have laravel's default translations published, you might want
                    // to include this path...
                    // realpath(__DIR__ . '/../vendor/laravel/framework/src/Illuminate/Translation/lang')

                ],

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__'
            ],
        ],

        'lang_js_json' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsJsonExporter::class,
            'options' => [

                'paths' => [

                    // Application's "lang" directory...
                    lang_path(),

                    // In case that you do not have laravel's default translations published, you might want
                    // to include this path...
                    // realpath(__DIR__ . '/../vendor/laravel/framework/src/Illuminate/Translation/lang')

                ],

                // Name of key in which json translations are to be found, for each locale
                'json_key' => '__JSON__',

                // JSON encoding options
                'json_options' => 0,
                'depth' => 512
            ],
        ],
    ]
];
