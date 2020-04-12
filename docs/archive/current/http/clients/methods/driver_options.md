---
description: Http Client Driver Options
sidebarDepth: 0
---

# Driver Options

Guzzle supports a variety of [request options](http://docs.guzzlephp.org/en/stable/request-options.html), some of which are directly available in the Http Client.
In this section, settings or removing such options is briefly illustrated.

[[TOC]]

## Add Driver Option

To add a single request option, use `withOption()`.

```php
$builder = $client
        ->withOption('delay', 800); 
``` 

## Add Multiple Options

Use `withOptions()` to add multiple options at the same time.
It accepts an array of key-value pairs.

```php
$builder = $client
        ->withOptions([
            'delay' => 800,
            'force_ip_resolve' => 'v4',
            'sink' => '/responses/hotel-orders.log'
        ]); 
```

## Remove Options

`withoutOption()` can be used to remove a single option.
It accepts the request option's name, as it's argument.

```php
$builder = $client
        ->withoutOption('delay'); 
``` 

## Via Configuration

Lastly, as illustrated in previous sections, you may also specify request options via your configuration.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [

                'delay' => 800,
                'force_ip_resolve' => 'v4',
                'sink' => '/responses/hotel-orders.log',
                'timeout' => 5,
                'read_timeout' => 10,
                'connect_timeout' => 2

                // ... remaining not shown ...
            ]
        ],
    ],
];
```

