<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Antivirus Scanner
    |--------------------------------------------------------------------------
    |
    | Name of default scanner profile to use, when none specified.
    */

    'default_scanner' => env('DEFAULT_ANTIVIRUS_SCANNER', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    |
    | List of available antivirus scanner profiles
    */

    'profiles' => [

        'default' => [
            // TODO: Add a default scanner profile...
        ],

        'null' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [

                // Whether scanner should "pass" file scans (true), or
                // "fail" then (false).
                'should_pass' => false,
            ],
        ]
    ]
];
