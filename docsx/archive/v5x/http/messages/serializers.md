---
description: How to use Http Message Serializers
---

# Serializers

The Http messages serializer `Factory` is able to accept a [PSR-7 `MessageInterface`](https://www.php-fig.org/psr/psr-7/#31-psrhttpmessagemessageinterface) and return a `Serializer` instance, which is capable of serializing the provided message into a `string` or `array`. 
This can come very handy, e.g. when dealing with Request & Response logging.

[[toc]]

The serializers found in this package, are inspired by those available in [Laminas Diactoros](https://github.com/laminas/laminas-diactoros).
Please check their [documentation](https://docs.laminas.dev/laminas-diactoros/v2/serialization/) for additional details.

## Register Service Provider

Register `HttpSerializationServiceProvider` in your `configs/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Http\Messages\Providers\HttpSerializationServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Obtain Serializer

Use the `HttpSerializerFactoryTrait` component to obtain the serializer `Factory`. 
The factory offers a `make()` method, which accepts a `MessageInterface` instance.

::: tip
PSR-7 `RequestInterface`, `ServerRequestInterface` and `ResponseInterface` all inherit from the `MessageInterface`.
See [documentation](https://www.php-fig.org/psr/psr-7/) for additional information.
:::

```php
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Psr\Http\Message\ResponseInterface;

class WeatherServiceHandler
{
    use HttpSerializerFactoryTrait;

    public function handle(ResponseInterface $response)
    {
        $serializer = $this
                        ->getHttpSerializerFactory()
                        ->make($response);
        
        // ... remaining not shown ...    
    }
}
```

## `toString()`

Use the `toString()` to get a `string` representation of the Http message.
You may also cast the serializer to achieve same result.

```php
$serializer = $factory->make($request);
echo $serializer->toString();

// Example Output
//
// GET /users?created_at=2020 HTTP/1.1
// Host: acme.org
// Content-Type: application/json
//  
// {"users":["Jim","Ulla","Brian"]}
```

## `toArray()`

To get an `array` representation of the Http message, use the `toArray()` method.

```php
$serializer = $factory->make($request);
dd($serializer->toArray());

// Example Output
//
// array:6 [
//  "method" => "GET"
//  "target" => "/users?created_at=2020"
//  "uri" => "https://acme.org/users?created_at=2020"
//  "protocol_version" => "1.1"
//  "headers" => array:2 [
//    "Host" => array:1 [
//      0 => "acme.org"
//    ]
//    "Content-Type" => array:1 [
//      0 => "application/json"
//    ]
//  ]
//  "body" => "{"users":["Jim","Ulla","Brian"]}"
]
```
