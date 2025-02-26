---
description: Authentication Headers
sidebarDepth: 0
---

# Authentication

Inspired by [Laravel's Http Client](https://laravel.com/docs/11.x/http-client#authentication), authentication headers can be specified via these shortcut methods.

[[TOC]]

::: warning Caution
Regardless of authentication method, you should always use https.
You never know who's listening...
:::

## Basic

The `useBasicAuth()` method will allow you to set a username and password, for [Basic Authentication](https://tools.ietf.org/html/rfc7617). 

```php
$response = $client
        ->useBasicAuth('john@doe.org', 'secret')
        ->get('/available-flights');
```

_Basic authentication can also be set [via configuration](http://docs.guzzlephp.org/en/stable/request-options.html#auth)._

## Digest

[Digest Authentication](https://tools.ietf.org/html/rfc7616) can be used, via `useDigestAuth()`.
This method also accepts a username and a password. 

```php
$response = $client
        ->useDigestAuth('john@doe.org', 'secret')
        ->get('/available-flights');
```

_Digest authentication can also be set [via configuration](http://docs.guzzlephp.org/en/stable/request-options.html#auth)._

## Token

Lastly, when using [token-based authentication](https://tools.ietf.org/html/rfc6750), `useTokenAuth()` can be used.
It accepts the following arguments:

- `$token`: `string` The token you wish to use
- `$scheme`: `string` (_optional_) The authentication scheme. Defaults to `Bearer`.

```php
 $response = $client
         ->useTokenAuth('my-secret-api-token')
         ->get('/available-flights');
```

Alternatively, you can also use the configuration to specify authentication headers.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'headers' => [
                    'Authorization' => 'Bearer my-secret-api-token'
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```
