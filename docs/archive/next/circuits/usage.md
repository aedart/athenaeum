---
description: How to use Circuit Breaker
---

# Usage

[[TOC]]

## Obtain Circuit Breaker

Once you have defined your "service" and circuit breaker settings, in your `config/circuit-breaker`, you can obtain a `CircuitBreaker` instance.
This can be done via the `CircuitBreakerManagerTrait`.

```php
<?php

use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;

class WeatherService
{
    use CircuitBreakerManagerTrait;
    
    public function forecast()
    {
        // Obtain circuit breaker for "weather_service" (defined in your
        // config/circuit-breakers.php file)
        $circuitBreaker = $this->getCircuitBreakerManager()
            ->create('weather_service');
            
        // ...remaining not shown
    }
}
```

## Attempt

Use the `attempt()` method to invoke a callback.
Depending on your configuration, this callback will be attempted executed one or multiple times (_See `retries` in your configuration file_), until it either succeeds or fails entirely.

```php
use Aedart\Contracts\Circuits\CircuitBreaker;

return $circuitBreaker->attempt(function(CircuitBreaker $cb) {
    // Call 3rd party service, return result ...
    $response = $http::get('https://acme.org/api/weather-service/v1/forecast');

    if ($response->failed()) {
        throw new RuntimeException('Unable to obtain forecast');
    }

    return $response;
});
```

## Otherwise Callback

Use the `$otherwise` argument to state a callback, which will be invoked if the attempt should fail.

```php
use Aedart\Contracts\Circuits\CircuitBreaker;
use Acme\Services\Weather\ServiceUnavailable;

return $circuitBreaker->attempt(function(CircuitBreaker $cb) {
    // ... callback not shown ...
}, function(CircuitBreaker $cb) {
    // Attempt has failed, do something else
    $lastFailure = $cb->lastFailure();
    $reason = $lastFailure->reason();

    if (!empty($reason)) {
        throw new ServiceUnavailable($reason);
    }
    
    throw new ServiceUnavailable('Weather Service is currently unavailable');
});
```

Behind the scenes, if the circuit breaker has detected too many failed attempts, across instances, then the `$otherwise` callback can be invoked immidiatly, allowing a [fast-failure](https://en.wikipedia.org/wiki/Fail-fast) to occur.
This happens when the `failure_threshold` has been reached.

### Default Otherwise Callback

You may also specify a default otherwise callback to be invoked, when none provided via the `attempt()` method.

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

## Retries & Failure Threshold

It is very important to understand that, **each failed attempt increases the failure count**.
The circuit breaker's internal store keeps track of this failure count, **across instances**.
This means that, if you have configured your circuit breaker to perform a certain amount `retries`, it **might not actually perform all attempts**, if the `failure_threshold` is reached, during those attempts. 

Please be mindful og how you choose to configure your `retries` and `failure_threshold`.

## Recovery (_Half-Open_)

When the circuit breaker is in _Open_ state (_circuit tripped - failure state_), it will automatically try to switch state to the _Half-Open_ state, each time `attempt()` is invoked.
However, this only happens after the `grace_period` has past (_available in your configuration_).

::: tip Note
By default, only a single circuit breaker instance will be able to obtain the _Half-Open_ state, across instances.
:::

If a circuit breaker achieves changing state to _Half-Open_, it will invoke the provided `$callback`.
Should the callback succeed, then **the failure count will be reset**, across all instances.
This means that the circuit breaker changes its state back to _Closed_.

If the callback does not succeed, the circuit breaker will remain in _Open_ state and invoke the `$otherwise` callback. 

Lastly, if the _Half-Open_ state cannot be obtained, then the circuit breaker resumes its normal behaviour and invokes the `$otherwise` callback.

