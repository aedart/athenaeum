---
description: How to setup Http Clients
---

# Setup

## Register Service Provider

Register `HttpClientServiceProvider` inside your `configs/app.php`. 

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

```console
php artisan vendor:publish
```

After the publish command has completed, you should see the following configuration file in your `/configs` directory:

- `http-clients.php`

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```console
php {your-cli-app} vendor:publish-all
```

## Configuration

In your `/configs/http-clients.php` configuration, you should see a list of "profiles".
Feel free to add as many profiles as your application requires.

Each profile consists of two keys:

* `driver` : Class patch to the Http Client "driver" to be used
* `options` : Http Client options.

The `DefaultHttpClient` and `JsonHttpClient` accept the following [options](http://docs.guzzlephp.org/en/stable/request-options.html)

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
                // Http Client options
            ]
        ],

        'json' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                // Http Client options
            ]
        ],

        // Add your own profiles... e.g. a preconfigured json http client
        'flights-api-client' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                'base_uri' => 'https://acme.com/api/v2/flights'
            ]
        ],
    ]
];
```
