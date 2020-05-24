---
description: How to use Circuit Breaker
---

# Usage

[[TOC]]

## Obtain Circuit Breaker

Once you have defined your "service" and circuit breaker settings, in your `configs/circuit-breaker`, you can obtain a `CircuitBreaker` instance.
This can be done via the `CircuitBreakerManagerTrait`.

```php
<?php

use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;

class WeatherService
{
    use CircuitBreakerManagerTrait;
    
    public function forecast()
    {
        $circuitBreaker = $this->getCircuitBreakerManager()
            ->create('weather_service');
            
        // ...remaining not shown
    }
}
```

## Attempt

Use the `attempt()` method to invoke a callback.

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

TODO: ...coming soon...

## Retries

If the provided callback fails, e.g. an exception is thrown, then a failure is reported and an internal failure count is increased.
Depending on your configuration, the callback is attempted invoked several times if a failure is detected.

TODO: ...example coming soon...

## Failure Threshold

TODO: ...coming soon...

