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
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                'data_format' => \GuzzleHttp\RequestOptions::FORM_PARAMS
            ]
        ],

        'json' => [
            'driver' => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options' => [

            ]
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Http Query Grammars
     |--------------------------------------------------------------------------
    */

    'grammars' => [

        /*
         |--------------------------------------------------------------------------
         | Default Http Query Grammar Client
         |--------------------------------------------------------------------------
         |
         | The default Http Query Grammar profile to use, when none specified
        */

        'default' => env('HTTP_QUERY_GRAMMAR', 'default'),

        /*
         |--------------------------------------------------------------------------
         | Http Query Grammar Profiles
         |--------------------------------------------------------------------------
         |
         | List of available Http Query Grammar "profiles".
        */

        'profiles' => [

            'default' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\DefaultGrammar::class,
                'options' => []
            ],

            'json_api' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\JsonApiGrammar::class,
                'options' => []
            ],

            'odata' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\ODataGrammar::class,
                'options' => []
            ]
        ]
    ]
];
