---
sidebarDepth: 0
description: Available Methods for Http Client
---

# DEPRECATED - Available Methods

All provided Http Clients offer a common set of methods. These are shortly described below.
In general, all methods that perform a HTTP request will return a `ResponseInterface` that adheres to [PSR-7 Http Message](https://www.php-fig.org/psr/psr-7/). 

[[toc]]

## `get()`

Performs a [GET](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET) request.

Returns a `ResponseInterface`.

```php
$response = $client->get('/flight-status/KL743');
```

## `head()`

Performs a [HEAD](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD) request.

Returns a `ResponseInterface`.

```php
$response = $client->head('/flights');
```

## `post()`

Performs a [POST](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST) request.

Returns a `ResponseInterface`.

```php
$response = $client->post('/flights', [
    'flightNo'      => 'WN417',
    'destination'   => 'BJS'
]);
```

## `put()`

Performs a [PUT](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT) request.

Returns a `ResponseInterface`.

```php
$response = $client->put('/flights', [
    'flightNo'      => 'WN417',
    'destination'   => 'LON'
]);
```

## `delete()`

Performs a [DELETE](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE) request.

Returns a `ResponseInterface`.

```php
$response = $client->delete('/flights', [
    'flightNo'      => 'WN417'
]);
```

## `options()`

Performs a [OPTIONS](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS) request.

Returns a `ResponseInterface`.

```php
$response = $client->options('/flights');
```

## `patch()`

Performs a [PATCH](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH) request.

Returns a `ResponseInterface`.

```php
$response = $client->patch('/flights', [
    'flightNo'      => 'WN417',
    'destination'   => 'NYC'
]);
```

## `request()`

Performs a generic HTTP request.

Accepts 3 arguments:

- `$method`: `string` Http method name
- `$uri`: `string` or `UriInterface` The Uri
- `$options`: `array` Driver specific options for request

The default provided drivers use [Guzzle Http Client](http://docs.guzzlephp.org).
Therefore, when using the `request()` method the following [options](http://docs.guzzlephp.org/en/stable/request-options.html) are accepted.

Returns a `ResponseInterface`.

```php
$response = $client->request('POST', '/flight-status', [
    'form_params' => [
        'flightNo'      => 'WN417',
        'message'       => 'Delayed 30 minutes'
    ]
]);
```

## `withHeaders()`

Set the [Http Headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers) for the next request.

Returns the `Client`.

```php
$response = $client
                ->withHeaders([ 'Accept' => 'application/xml' ])
                ->get('/status-report');
```

## `withHeader()`

Set a single [Http Header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers) for the next request.

Method accepts 2 arguments:

- `$name`: `string` Header name
- `$value`: `mixed` Header value

Returns the `Client`.

```php
$response = $client
                ->withHeader('Accept', 'application/xml')
                ->get('/status-report');
```

## `withoutHeader()`

Remove a [Http Header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers) for the next request.

_This is useful if you have predefined headers for your Http Client profile, yet you need to remove a single header, for a special occasion._ 

Returns the `Client`.

```php
$response = $client
                ->withoutHeader('Accept')
                ->get('/status-report');
```

## `getHeaders()`

Returns all the [Http Headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers) set for the next request.

Returns `array`.

```php
$headers = $client->getHeaders();
```

::: tip Note
The case of the turned headers are as provided to the client.
See [PSR-7: Http Headers](https://www.php-fig.org/psr/psr-7/#12-http-headers) for more information. 
:::

## `getHeader()`

Returns value of a specified [Http Headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers), set the next request. 

The header `$name` argument is case-insensitive.
See [PSR-7: Http Headers](https://www.php-fig.org/psr/psr-7/#12-http-headers) for more information.

Returns `mixed`.

```php
$value = $client->getHeader('Accept');
```

## `withOptions()`

Set driver specific options for the next request

Provided options will be merged with preconfigured Http Client options, set via configuration.

Returns the `Client`.

```php
$response = $client
                ->withOptions([ 'allow_redirects' => true ])
                ->get('/find-flight/CA7745');
```

## `withOption()`

Set a single driver specific option for the next request.

Provided options will be merged with preconfigured Http Client options, set via configuration.

Method accepts 2 arguments:

- `$name`: `string` Name of option
- `$value`: `mixed` Option value

Returns the `Client`.

```php
$response = $client
                ->withOption('allow_redirects', [
                    'max'             => 5,
                    'strict'          => false,
                    'referer'         => false,
                    'protocols'       => ['http', 'https'],
                    'track_redirects' => false
                ])
                ->get('/find-flight/CA7745');
```

## `withoutOption()`

Remove a single driver specific option for the next request.

_This is useful if you have predefined options for your Http Client profile, yet you need to remove a single option, for a special occasion._

Returns the `Client`.

```php
$response = $client
                ->withoutOption('allow_redirects')
                ->get('/find-flight/CA7745');
```

## `getOptions()`

Returns all driver specific options for the next request.

Returns `array`.

```php
$options = $client->getOptions();
```

## `getOption()`

Get the value of a driver specific option, for the next request.

Returns `mixed`.

```php
$value = $client->getOption('allow_redirects');
```

## `driver()`

Returns the native driver used by the Http Client.

_If you are using the default provided Http Client(s), then this method will return the [Guzzle Http Client](http://docs.guzzlephp.org) instance._

Returns `mixed`.

```php
$driver = $client->driver();
```
