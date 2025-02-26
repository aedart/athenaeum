---
description: Setting the Base Url
sidebarDepth: 0
---

# Base Uri

You can specify the [base uri](http://docs.guzzlephp.org/en/stable/quickstart.html) using either the `withBaseUrl()` method or directly via the driver options, in your `config/http-clients.php`.
This will result in each request's uri being prefixed, with the stated "base uri" 

## Via `withBaseUrl()`

```php
$builder = $client
        ->withBaseUrl('https://acme.org/api/v1');
```

## Via Configuration

Add the `base_uri` in your `options` list, to set the base uri.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [

                'base_uri' => 'https://acme.org/api/v1'
            ]
        ],
    ],
    
    // ... remaining not shown ...
];
```
