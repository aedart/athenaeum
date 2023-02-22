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
                ],

                'json_key' => '__JSON__'
            ],
        ],

        'lang_js' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsExporter::class,
            'options' => [
                'paths' => [
                    lang_path(),
                    realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')
                ],

                'json_key' => '__JSON__'
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