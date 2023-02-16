---
description: How to setup Http Clients
---

# Setup

[[TOC]]

## Register Service Provider

Register `HttpClientServiceProvider` inside your `config/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Http\Clients\Providers\HttpClientServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish this package's assets.

```shell
php artisan vendor:publish
```

After the command has completed, you should see the following configuration file in your `/configs` directory:

- `http-clients.php`

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

In your `/config/http-clients.php` configuration, you should see a list of "profiles".
Feel free to add as many profiles as your application requires.

Each profile consists of two keys:

* `driver`: Class patch to the Http Client "driver" to be used.
* `options`: Http Client options.

You can use [Guzzle's Request Options](http://docs.guzzlephp.org/en/stable/request-options.html), for each client profile.

```php
return [

    // ... previous not shown

    /*
     |--------------------------------------------------------------------------
     | Http Client Profiles
     |--------------------------------------------------------------------------
    */

    'profiles' => [

        'default' => [
            'driver'    => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options'   => [

                'data_format' => \GuzzleHttp\RequestOptions::FORM_PARAMS,                
                'grammar-profile' => env('HTTP_QUERY_GRAMMAR', 'default'),
            ]
        ],

        'json' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                
                'grammar-profile' => 'json_api',
            ]
        ],

        // Add your own profiles... e.g. a preconfigured json http client
        'flights-api-client' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                'base_uri' => 'https://acme.com/api/v2/flights',
                'grammar-profile' => 'odata',
            ]
        ],
    ]
    
    // ... remaining not shown ...
];
```

### Http Query Grammars

Each Http Client profile can specify it's desired Http Query Grammars profile to use.
The following grammars are offered by default:

- `DefaultGrammar`: Does not follow any specific syntax or convention.
- `JsonApiGrammar`: Adheres to [Json API's](https://jsonapi.org/format/1.1/#fetching) syntax for Http Queries.
- `ODataGrammar`: Adheres to [OData's](https://www.odata.org/getting-started/basic-tutorial/#queryData) syntax for Http Queries.

You can find a matching profile, inside your `config/http-clients.php`, where you may change any of the available options.

```php
<?php

return [
    // ... previous not shown ...

    'profiles' => [

        'json' => [
            'driver' => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options' => [
                // Http Query grammar profile to use
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

        'profiles' => [

            'json_api' => [
                'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\JsonApiGrammar::class,
                'options' => [

                    'datetime_format' => \DateTimeInterface::ISO8601,
                    'date_format' => 'Y-m-d',
                    'year_format' => 'Y',
                    'month_format' => 'm',
                    'day_format' => 'd',
                    'time_format' => 'H:i:s',

                    // ... remaining not shown ...
                ]
            ],

            // ... remaining not shown ...
        ]
    ]
];
``` 
