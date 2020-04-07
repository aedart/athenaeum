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

                /**
                 * Data format to use
                 */
                'data_format' => \GuzzleHttp\RequestOptions::FORM_PARAMS,

                /**
                 * Http Query Grammar to use
                 */
                'grammar-profile' => env('HTTP_QUERY_GRAMMAR', 'default'),
            ]
        ],

        'json' => [
            'driver' => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options' => [

                /**
                 * Http Query Grammar to use
                 */
                'grammar-profile' => 'json_api',
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
                'options' => [

                    /**
                     * Date formats
                     */
                    'datetime_format' => \DateTimeInterface::ISO8601,
                    'date_format' => 'Y-m-d',
                    'year_format' => 'Y',
                    'month_format' => 'm',
                    'day_format' => 'd',
                    'time_format' => 'H:i:s',

                    /**
                     * Query parameter separator symbol
                     *
                     * @see https://www.w3.org/TR/html401/appendix/notes.html#h-B.2.2
                     */
                    'parameter_separator' => '&',

                    /**
                     * "And where" conjunction separator.
                     *
                     * This SHOULD use same symbol as the query
                     * parameter separator.
                     */
                    'and_separator' => '&',

                    /**
                     * "or where" conjunction separator.
                     *
                     * WARNING: This is NOT a standard convention.
                     * Symbol is added after the "and separator".
                     * E.q. "?gender=male&|name=john" (where gender eq male or name eq john)
                     */
                    'or_separator' => '|',
                ]
            ],

            'json_api' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\JsonApiGrammar::class,
                'options' => [

                    /**
                     * Date formats
                     */
                    'datetime_format' => \DateTimeInterface::ISO8601,
                    'date_format' => 'Y-m-d',
                    'year_format' => 'Y',
                    'month_format' => 'm',
                    'day_format' => 'd',
                    'time_format' => 'H:i:s',

                    /**
                     * Query parameter separator symbol
                     *
                     * @see https://www.w3.org/TR/html401/appendix/notes.html#h-B.2.2
                     */
                    'parameter_separator' => '&',

                    /**
                     * "And where" conjunction separator.
                     *
                     * This SHOULD use same symbol as the query
                     * parameter separator.
                     */
                    'and_separator' => '&',

                    /**
                     * "or where" conjunction separator.
                     *
                     * WARNING: This is NOT a standard convention.
                     * Symbol is added BEFORE a field / filter identifier.
                     * E.g. "?filter[gender]=male&filter[|name]=john" (where gender eq male or name eq john)
                     */
                    'or_separator' => '|',
                ]
            ],

            'odata' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\ODataGrammar::class,
                'options' => [

                    /**
                     * If true, string values are automatically quoted with
                     * single-quotes
                     */
                    'quote_strings' => false,

                    /**
                     * Date formats
                     */
                    'datetime_format' => \DateTimeInterface::ISO8601,
                    'date_format' => 'Y-m-d',
                    'year_format' => 'Y',
                    'month_format' => 'm',
                    'day_format' => 'd',
                    'time_format' => 'H:i:s',

                    /**
                     * Query parameter separator symbol
                     *
                     * @see https://www.w3.org/TR/html401/appendix/notes.html#h-B.2.2
                     */
                    'parameter_separator' => '&',
                ]
            ]
        ]
    ]
];
