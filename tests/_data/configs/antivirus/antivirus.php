<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Antivirus Scanner
    |--------------------------------------------------------------------------
    */

    'default_scanner' => env('DEFAULT_ANTIVIRUS_SCANNER', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'default' => [
            // TODO: Replace default scanner profile...

            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => false,
            ],
        ],

        'null' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [
                'should_pass' => false,
            ],
        ]
    ]
];
