<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Redmine API Connection
     |--------------------------------------------------------------------------
     |
     | The default connection profile to be used, when no specific connection is
     | requested.
    */

    'default' => env('REDMINE_CONNECTION', 'default'),

    /*
     |--------------------------------------------------------------------------
     | Connection Profiles
     |--------------------------------------------------------------------------
     |
     | List of available Redmine connection profiles. Each profile contains
     | a reference to what Http Client "profile" it must use.
     |
     | See https://aedart.github.io/athenaeum/archive/current/http/clients/
    */

    'connections' => [

        'default' => [

            /*
             | Name of Http Client profile. The profile MUST have the "base_uri"
             | specified, and use the \Aedart\Http\Clients\Drivers\JsonHttpClient::class
             | driver.
             |
             | @see http-clients.php
            */
            'http_client' => 'redmine',

            /*
             | Redmine Authentication token. This option is automatically set as
             | the appropriate Http Header (X-Redmine-API-Key)
            */
            'authentication' => env('REDMINE_TOKEN')
        ]

    ]
];
