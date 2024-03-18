---
description: Http Query
sidebarDepth: 0
---

# Http Query

The Http Client comes with a powerful [Http Query Builder](../query/) that allows you to set query parameters in a fluent manner, similar to [Laravel's database query builder](https://laravel.com/docs/10.x/queries#introduction) (_but with significantly less features_).
You can read more about the builder, in the upcoming [chapter](../query/).
For now, the more traditional ways of setting a request's http query parameters is briefly illustrated.
This may be useful for you, when the provided query builder isn't able to meet your needs.

## Via Uri

You can always specify query parameters manually, via the request's uri.

```php
$response = $client
        ->withUri('/users?search=John')
        ->get();
```

::: warning Caution
If you choose to set query parameters via the uri and also make use the Http Query Builder, then the entire query string provided via the uri is ignored!

In other words, you **SHOULD NOT** mix the methods of how you state query parameters.
:::

## Via Configuration

Another way to specify query parameters, is via your configuration.
Here, you may specify a string or an array of key-value pairs.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'query' => [
                    'search' => 'John'
                ]

                // ... remaining not shown ...
            ]
        ],
    ],
];
```

The above shown example may not seem very useful, but sometimes you might be working with a type of API, where you always are required to send one or more query parameters, for each request.
If that is the case, then you are better off stating these directly into your configuration.

You can read more about the `query` option, in [Guzzle's documentation](http://docs.guzzlephp.org/en/stable/request-options.html#query).

::: tip
Query parameters that are added via the configuration are automatically also appended to your Http Query Builder.
:::

