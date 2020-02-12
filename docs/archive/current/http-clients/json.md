---
description: Json Http Client
---

# Json Http Client

When you require to communicate with a json-based api, it is recommended that you use a profile that makes use of the `JsonHttpClient` driver.
This driver will ensure to automatically set the `Content-Type` header to be `application/json`.
Furthermore, it will also automatically ensure correct json encoding of your requests's payload (body). 

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
