---
description: Request Timeout
sidebarDepth: 0
---

# Timeout

[[TOC]]

## Set Request Timeout

To specify a request's timeout, use the `withTimeout()` method.
The method accepts a duration stated in seconds as it's argument.

```php
$response = $client
        ->withTimeout(5)
        ->get('/pending-orders');
```

## Via Configuration

In your configuration, you can specify the request timeout, as well as other [timeouts](http://docs.guzzlephp.org/en/stable/request-options.html) that Guzzle supports.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [

                'timeout' => 5,
                'read_timeout' => 10,
                'connect_timeout' => 2

                // ... remaining not shown ...
            ]
        ],
    ],
];
```
