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
     | List of available Http Client "profiles".
    */

    'profiles' => [
        'default' => [
            'driver'    => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options'   => [

            ]
        ]
    ]
];