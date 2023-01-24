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

                // Hashing algorithm to be used for ETags flagged as "weak" (weak comparison)
                'weak_algo' => 'xxh3',

                // Hashing algorithm to be used for ETags NOT flagged as "weak" (strong comparison)
                'strong_algo' => 'xxh128',
            ],
        ],
    ]
];
