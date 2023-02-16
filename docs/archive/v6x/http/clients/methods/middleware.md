---
description: Middleware
sidebarDepth: 0
---

# Middleware

Inspired by [PSR-15: HTTP Server Request Handlers](https://www.php-fig.org/psr/psr-15/), the Http Client is able to process outgoing requests and incoming responses, using middleware. 

[[toc]]

## Create Middleware

To create a custom middleware component, you must inherit from the `Middleware` interface.

```php
namespace Acme\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Acme\Logger\ResponseLogger;

class LogsResponse implements Middleware
{
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        ResponseLogger::log($response);

        return $response;
    }
}
```

::: tip Differs from PSR-15
If you are familiar with PSR-15, you will immediately notice the similarity between the above shown middleware example, and the one defined in PST-15.
Currently, it is not possible to use the same middleware component(s), as for PSR-15.
This is because `Psr\Http\Server\MiddlewareInterface` relies on `ServerRequestInterface`.
In other words, it was designed to process incoming server requests, and not outgoing requests.
Therefore, to avoid confusion and misuse of PSR-15, custom `Middleware` and `Handler` components have been added to this package.

Even so, the `Middleware` and `Handler` from this package offer the same look & feel, as those defined by PSR-15. 
:::

::: tip Differs from Guzzle
You should not confuse this middleware mechanism with [Guzzle's Handlers and Middleware](http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html).
While they might overlap in purpose and functionality, they are distinctively two different mechanisms.

It is possible to use both mechanisms. If so, then you should know that Guzzle's handlers and middleware will always be executed first.
See [Guzzle's documentation](http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html) for additional information. 
:::

## Apply Middleware

To apply middleware use the `withMiddleware()` method. 

```php
use Acme\Middleware\LogsResponse;

$response = $client
        ->withMiddleware(new LogsResponse())
        ->get('/weather');
```

### Add List of Middleware

You may also provide a list of middleware, using the same method.

```php
use Acme\Middleware\SetsAuthenticationHeaders;
use Acme\Middleware\LimitsResults;
use Acme\Middleware\LogsResponse;

// Will automatically resolve provided class paths...
$response = $client
        ->withMiddleware([
            SetsAuthenticationHeaders::class,
            LimitsResults::class,
            LogsResponse::class
        ])
        ->get('/weather');
```

## Via Configuration

Alternatively, you may also specify a list of middleware in your configuration.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'middleware' => [
                    \Acme\Middleware\SetsAuthenticationHeaders::class,
                    \Acme\Middleware\LimitsResults::class,
                    \Acme\Middleware\LogsResponse::class
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```

### Arguments for Middleware

Behind the scene, the [List Resolver](../../../container/list-resolver) is used, to resolve middleware.
This means that you can provide custom arguments for your middleware component, directly from the configuration.

The following hypothetical example assumes that each middleware component accepts one or more arguments.
When resolved, each middleware instance will be provided with the arguments defined in the configuration.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'middleware' => [
                    \Acme\Middleware\SetsAuthenticationHeaders::class => [
                        'token' => env('WEATHER_SERVICE_TOKEN')
                    ],
                    \Acme\Middleware\LimitsResults::class => [
                        'maxResults' => 25,
                    ],
                    \Acme\Middleware\LogsResponse::class => [
                        'maxEntries' => 15,
                        'path' => storage_path('/logs/weather-service-responses.log')
                    ]
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```

## Obtain Request Builder in Middleware

Should your middleware require the Http Request `Builder` instance, then just inherit from the `HttpRequestBuilderAware` interface.
When resolved, the `Builder` will automatically be injected into your middleware.

```php
use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogsResponse implements
    Middleware,
    HttpRequestBuilderAware
{
    use HttpRequestBuilderTrait;

    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        // Obtain builder
        $builder = $this->getHttpRequestBuilder();

        // ... remaining not shown ...
    }
}
```

::: warning
The `Builder` is no longer able to alter the outgoing request, during middleware processing.
It can, however, be used to obtain settings and options.
:::
