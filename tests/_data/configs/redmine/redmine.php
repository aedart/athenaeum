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
             | Redmine Authentication token. This option automatically be set as
             | the appropriate Http Header (X-Redmine-API-Key)
            */
            'authentication' => env('REDMINE_TOKEN')
        ],

        'my_custom_connection' => [
            'http_client' => 'redmine',
            'authentication' => env('REDMINE_TOKEN')
        ],

        'connection_with_invalid_http_client' => [
            'http_client' => 'client_that_does_not_exist',
        ]
    ]
];
