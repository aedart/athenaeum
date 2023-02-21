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
                    lang_path(),
                    realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')
                ]
            ],
        ],

        'null' => [
            'driver' => \Aedart\Translation\Exports\Drivers\NullExporter::class,
            'options' => [
                'paths' => [
                    lang_path(),
                    realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')
                ]
            ],
        ],
    ]
];