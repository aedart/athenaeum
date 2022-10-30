<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default ETag Generator
    |--------------------------------------------------------------------------
    |
    | Name of default ETag Generator profile to use, when none specified.
    */

    'default_generator' => env('DEFAULT_ETAG_GENERATOR', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Generator Profiles
    |--------------------------------------------------------------------------
    |
    | List of available ETag Generator profiles
    */

    'profiles' => [

        'default' => [
            'driver' => \Aedart\ETags\Generators\GenericGenerator::class,
            'options' => [
                'hash_algo' => 'sha1',
                'is_weak' => false,
            ],
        ]
    ]
];