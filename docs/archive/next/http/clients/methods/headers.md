---
description: Setting the Http Headers
sidebarDepth: 0
---

# Headers

[[TOC]]

## Set a Single Http Header

In order to set a single Http header, for your next request, use the `withHeader()` method.
It accepts a name and a value as arguments.

```php
$builder = $client
    ->withHeader('X-Foo', 'bar');
```

## Set Multiple Headers

You can also specify multiple headers, via the `withHeaders()` method.

```php
$builder = $client
    ->withHeaders([
        'X-Foo' => 'bar',
        'X-Bar' => 'foo'
    ]);
```

## Remove a Header

Should you require to dynamically remove an already set Http header, use `withoutHeader()`.
It accepts a name argument, which must match the name of an already set header.

```php
$builder = $client
    ->withoutHeader('X-Foo');
```

## Via Configuration

You can also predefine Http headers via your Http Client profile's options, in your configuration file.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'headers' => [
                    'X-Foo' => 'bar'
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```
