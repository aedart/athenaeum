# Http Clients

A wrapper for [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html), that supports multiple "profiles" based instances, allowing you to segment each api you communicate with, into it's own client instance.

## Prerequisite

[Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html) is a required dependency.
Please ensure that it is present, in your [composer.json](https://getcomposer.org) file.

## Service Provider

Register the `HttpClientServiceProvider` inside your `configs/app.php` configuration file.

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

## Publish Resources

You need to publish the service's configuration, before able to use it.
This can be achieved via artisan's publish command:

```
php artisan vendor:publish 
```

_Remember to select `Aedart\Http\Clients\Providers\HttpClientServiceProvider` as the service to publish from._ 

## Configuration

Once you have published this service's configuration, you should find a `http-clients.php`, inside your `configs/` directory.
Within this configuration, you can freely add more http client profiles or change the existing.

Each profile consists of two keys:

* `driver` : class patch to the Http Client driver to be used
* `options` : [Guzzle Options](http://docs.guzzlephp.org/en/stable/request-options.html)

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
                // Guzzle Http Client options
            ]
        ],

        'json' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                // Guzzle Http Client options
            ]
        ]
    ]
];
```

## Usage

To obtain a http client, you can use the `HttpClientsManager`, which can be obtained via a trait.

```php
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;

class WeatherController
{
    use HttpClientsManagerTrait;
    
    public function index()
    {
        $client = $this->getHttpClientsManager()->profile();
        
        // Perform a GET requeset
        $response = $client->get('/weather-report.html');
        
        // ...remaining not shown
    }
}
```

## Obtain Specific Client Profile

In order to obtain a Http Client instance that matches a specific profile, simply state the name as argument for the `profile()` method. 

```php
$myClient = $this->getHttpClientsManager()->profile('my-client-profile');
```

## Json Http Client

When you require to communicate with a json-based api, it is recommended that you use a profile that makes use of `JsonHttpClient` driver.
This driver will ensure to automatically set the `Content-Type` header to be `application/json`.
Furthermore, it will also automatically ensure correct json encoding of your requests's payload (body). 

```php
return [
    // ... previous not shown

    'profiles' => [

        'json' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                // Guzzle Http Client options
            ]
        ]
    ]
];
```

```php
$client = $this->getHttpClientsManager()->profile('json');

// Send a POST request, as json
$response = $client->post('/api/v1/users', [
    'name' => 'Jim Gordon'
]);
```

## Onward

For more information about the http client's public methods, please review the `\Aedart\Contracts\Http\Clients\Client` interface.