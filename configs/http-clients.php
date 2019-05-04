<?php
return [

    /*
     |--------------------------------------------------------------------------
     | Default Http Client
     |--------------------------------------------------------------------------
     |
     | The default Http Client profile to use, when no specific profile is
     | requested.
    */

    'default' => env('HTTP_CLIENT', 'default'),

    /*
     |--------------------------------------------------------------------------
     | Http Client Profiles
     |--------------------------------------------------------------------------
     |
     | List of available Http Client "profiles". Each has a driver, which is a
     | class path to an actual client that must be used. All Guzzle Http Client
     | are supported, by the default client(s).
     |
     | See http://docs.guzzlephp.org/en/stable/request-options.html
    */

    'profiles' => [

        'default' => [
            'driver'    => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options'   => [

            ]
        ],

        'json' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [

            ]
        ]
    ]
];