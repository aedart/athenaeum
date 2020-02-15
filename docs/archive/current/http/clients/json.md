---
description: Json Http Client
---

# Json Http Client

When you are required to communicate with a json-based api, it is recommended that you use a profile that makes use of the `JsonHttpClient` driver.
This driver automatically sets the [`Content-Type`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type) and [`Accept`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept) header to `application/json`, if no such headers have been specified in the configuration.

Additionally, the client will automatically ensure correct json encoding of your request's payload (body). 

## Configuration

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

## Obtain Json Http Client

```php
$client = $this->getHttpClientsManager()->profile('json');

// Send a POST request, as json
$response = $client->post('/api/v1/users', [
    'name' => 'Jim Gordon'
]);
```
