---
description: How to use Http Clients
---

# Basic Usage

[[TOC]]

## Obtain Http Client

To obtain a Http Client instance, use the `HttpClientsManager`.
It can be obtained via `HttpClientsManagerTrait`.

```php
<?php
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;

class WeatherController
{
    use HttpClientsManagerTrait;
    
    public function index()
    {
        $client = $this->getHttpClientsManager()->profile();
        
        // ...remaining not shown
    }
}
```

## Obtain Specific Client Profile

In order to obtain a Http Client profile, state the profile name as argument for the `profile()` method. 

```php
$myClient = $this->getHttpClientsManager()->profile('my-client-profile');
```

## Perform Http Requests

Each method that performs a request will return a [PSR-7](https://www.php-fig.org/psr/psr-7/) `ResponseInterface`.

### GET

Use `get()` to make a Http [GET](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET) request.

```php
$response = $client->get('/users');
```

### HEAD

Use `head()` to make a Http [HEAD](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD) request.

```php
$response = $client->head('/users');
```

### POST

Use `post()` to make a Http [POST](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST) request.

```php
$response = $client->post('/users', [
    'name' => 'John Doe',
    'job'  => 'developer'
]);
```

### PUT

Use `put()` to make a Http [PUT](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT) request.

```php
$response = $client->put('/users/421', [
    'name' => 'Jim Orion',
    'job'  => 'architect'
]);
```

### DELETE

Use `delete()` to make a Http [DELETE](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE) request.

```php
$response = $client->delete('/users/7742');
```

### OPTIONS

Use `options()` to make a Http [OPTIONS](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS) request.

```php
$response = $client->options('/users');
```

### PATCH

Use `patch()` to make a Http [PATCH](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH) request.

```php
$response = $client->patch('/users/4487', [
    'name' => 'Isabella Amelia Thomason',
    'job'  => 'lead designer'
]);
```

### Generic Request

The `request()` method allows you to perform a generic Http request.
It accepts three arguments:

- `$method`: `string` Http method name
- `$uri`: `string` or `UriInterface` The Uri
- `$options`: `array` Driver specific request options (_See [Guzzle's documentation](http://docs.guzzlephp.org/en/stable/request-options.html) for additional information_)

```php
$response = $client->request('PATCH', '/users/1247', [
    'json' => [
        'name' => 'Emma Jackson',
        'job'  => 'junior developer'
    ]
]);
```
