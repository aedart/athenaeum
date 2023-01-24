<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default ETag Generator
    |--------------------------------------------------------------------------
    |
    | Name of default ETag Generator profile to use, when none specified.
    */

    'default_generator' => 'default',

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

                // Algorithm intended for ETags flagged as "weak" (weak comparison)
                'weak_algo' => 'xxh3',

                // Algorithm intended for ETags NOT flagged as "weak" (strong comparison)
                'strong_algo' => 'xxh128',
            ],
        ],

        'other' => [
            'driver' => \Aedart\ETags\Generators\GenericGenerator::class,
            'options' => [
                'weak_algo' => 'crc32',
                'strong_algo' => 'sha1',
            ],
        ]
    ]
];