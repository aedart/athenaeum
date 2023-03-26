---
description: About the Circuits Package
sidebarDepth: 0
---
# Circuits

::: tip
_Circuits package is available from Athenaeum `v4.2`_
:::

This package offers a Circuit Breaker that can be used to "_[...] detect failures and encapsulates the logic of preventing a failure from constantly recurring, during maintenance, temporary external system failure or unexpected system difficulties[...]_" ([wiki](https://en.wikipedia.org/wiki/Circuit_breaker_design_pattern)).

A detailed explanation of how the Circuit Breaker Pattern works, can be found on [Medium](https://medium.com/@soumendrak/circuit-breaker-design-pattern-997c3521c1c4) and [Martin Fowler's blog](https://martinfowler.com/bliki/CircuitBreaker.html)

## Example

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

        return $circuitBreaker->attempt(function() {
            // Perform 3rd party API call... not shown here
        }, function(){
            // Service has failed and is unavailable, do something else...
        });
    }
}
```
