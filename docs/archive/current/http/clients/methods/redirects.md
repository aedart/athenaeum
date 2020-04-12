---
description: Request Redirects
sidebarDepth: 0
---

# Redirects

[[TOC]]

## Set Max Redirects

`maxRedirects()` allows you to specify the maximum amount of redirect a request should follow.

```php
$response = $client
        ->maxRedirects(2)
        ->get('/hotels');
```

Unless specified, each Http Client has the maximum of `1` redirect.

## Disable Redirects

To disallow request redirects, use the `disableRedirects()` method.

```php
$response = $client
        ->disableRedirects()
        ->get('/hotels');
```

## Via Configuration

You can also set the redirect behaviour via the configuration.
This will allow you to specify all of Guzzle's [redirect settings](http://docs.guzzlephp.org/en/stable/request-options.html#allow-redirects).

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [

                'allow_redirects' => [
                    'max' => 1,
                    'strict' => true,
                    'referer' => true,
                    'protocols' => ['http', 'https'],
                    'track_redirects' => false
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```
