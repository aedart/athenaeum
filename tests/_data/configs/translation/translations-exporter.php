<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Exporter
    |--------------------------------------------------------------------------
    */

    'default_exporter' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Language Directories
    |--------------------------------------------------------------------------
    */

    'paths' => [
        lang_path(),
        realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces and Json
    |--------------------------------------------------------------------------
    */

    'namespaces' => [
        'deferrable' => \Codeception\Configuration::dataDir() . 'translation/deferrable'
    ],

    'json' => [
        \Codeception\Configuration::dataDir() . 'translation/deferrable'
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

        'cache' => [
            'driver' => \Aedart\Translation\Exports\Drivers\CacheExporter::class,
            'options' => [
                'exporter' => 'default',
                'cache' => 'array',
                'ttl' => 300,
                'prefix' => 'trans_export_'
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