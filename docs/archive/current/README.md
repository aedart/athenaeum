---
description: Athenaeum Release Notes
---

# Release Notes

## `v5.x` Highlights

These are the new features and additions of Athenaeum `v5.x`.

[[toc]]

### Http Client Middleware

You can now assign middleware to process your outgoing requests and incoming responses. 
See [Http Client Middleware](./http/clients/methods/middleware) for more examples.

```php
use Acme\Middleware\MeasuresResponseTime;

$response = $client
        ->withMiddleware(new MeasuresResponseTime())
        ->get('/weather');
```

### Extract Response Expectations

A `ResponseExpectations` class has been added, which you can use as a base class to extract complex expectations into separate classes.
See [documentation](./http/clients/methods/expectations) for additional information.

```php
use Aedart\Http\Clients\Requests\Builders\Expectations\ResponseExpectation;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserWasCreated extends ResponseExpectations
{
    public function expectation(
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ): void {
        // ...validation not shown here...
    }
}

// --------------------------------------- /
// Use expectation when you send your request
$response = $client
        ->expect(new UserWasCreated())
        ->post('/users', [ 'name' => 'John Snow' ]);
```

### Debugging Request and Response

[Debugging](./http/clients/methods/debugging) and [logging](./http/clients/methods/logging) utilities have been added for a quick way to dump outgoing request and incoming response.

```php
// Dump request / response.
$response = $client
        ->debug()
        ->get('/users');

// --------------------------------------------

// Logs the request / response.
$response = $client
        ->log()
        ->get('/users');
```

### Default otherwise callback

The [Circuit Breaker](./circuits) now supports setting a default "otherwise" callback, via the `otherwise()` method.
When no "otherwise" callback is provided to the `attempt()` method, the default "otherwise" callback will be used.

```php
use Aedart\Contracts\Circuits\CircuitBreaker;

$result = $circuitBreaker
    ->otherwise(function(CircuitBreaker $cb) {
        // ...not shown...
    })
    ->attempt(function(CircuitBreaker $cb) {
        // ...callback not shown...
    });
```

### Support for TOML configuration files

Added configuration file parser for [TOML](https://en.wikipedia.org/wiki/TOML) format, for the [configuration loader](./config).

### Resolve list of dependencies

Using the new `ListResolver`, you can resolve a list of dependencies, including custom arguments.
(_Component is available in the [Service Container package](./container/list-resolver.md)_).

```php
use Aedart\Container\ListResolver;

$list = [
    \Acme\Filters\SanitizeInput::class,
    \Acme\Filters\ConvertEmptyToNull::class,
    \Acme\Filters\ApplySorting::class => [
        'sortBy' => 'age',
        'direction' => 'desc'
    ]
];

// Resolve list of dependencies
$filters = (new ListResolver())->make($list);
```

### Http Messages Package

A new package for that offers PSR-7 Http Messages utilities.
See [documentation](./http/messages) for additional information.

### Duration

Added `Duration` utility; a small component able to help with dealing with relative date and time. 
See [utilities](./utils/duration) for more information.

### Upgraded Dependencies

Upgraded several dependencies, here amongst Laravel which is now running on `v8.x`.

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
