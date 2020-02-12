---
description: Available Methods for Http Client
---

# Available Methods

All provided Http Clients offer a common set of methods. These are shortly described below.
In general, all methods that perform a HTTP request will return a `ResponseInterface` that adheres to [PSR-7 Http Message](https://www.php-fig.org/psr/psr-7/). 

## `get()`

Performs a [GET](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET) request.

```php
$response = $client->get('/flight-status/KL743');
```

## `head()`

Performs a [HEAD](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD) request.

```php
$response = $client->head('/flights');
```

## `post()`

Performs a [POST](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST) request.

```php
$response = $client->post('/flights', [
    'flightNo'      => 'WN417',
    'destination'   => 'BJS'
]);
```

## `put()`

Performs a [PUT](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT) request.

```php
$response = $client->put('/flights', [
    'flightNo'      => 'WN417',
    'destination'   => 'LON'
]);
```

## `delete()`

Performs a [DELETE](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE) request.

```php
$response = $client->delete('/flights', [
    'flightNo'      => 'WN417'
]);
```

## `options()`

Performs a [OPTIONS](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS) request.

```php
$response = $client->options('/flights');
```

## `patch()`

Performs a [PATCH](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH) request.

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

```php
$response = $client->request('POST', '/flight-status', [
    'form_params' => [
        'flightNo'      => 'WN417',
        'message'       => 'Delayed 30 minutes'
    ]
]);
```

-------------------TODO-------------------------

```

    /**
     * Set the Http headers for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function withHeaders(array $headers = []) : self ;

    /**
     * Set a Http header for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function withHeader(string $name, $value) : self ;

    /**
     * Remove a Http header from the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutHeader(string $name) : self ;

    /**
     * Get all the Http headers for the next request
     *
     * @return array
     */
    public function getHeaders() : array ;

    /**
     * Get the desired Http header, for the next request
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getHeader(string $name);

    /**
     * Apply a set of options for the next request
     *
     * Method will merge given options with Client's default options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function withOptions(array $options = []) : self ;

    /**
     * Set a specific option for the next request
     *
     * Method will merge given options with Client's default options
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function withOption(string $name, $value) : self ;

    /**
     * Remove given option for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutOption(string $name) : self ;

    /**
     * Get all the options for the next request
     *
     * @return array
     */
    public function getOptions() : array ;

    /**
     * Get a specific option for the next request
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getOption(string $name);

    /**
     * Get this Http Client's native driver
     *
     * @return mixed
     */
    public function driver();
```
