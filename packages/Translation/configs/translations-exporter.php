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

                ]
            ],
        ],
    ]
];
