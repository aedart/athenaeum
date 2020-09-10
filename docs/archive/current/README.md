---
description: Athenaeum Release Notes
---

# Release Notes

## `v5.x` Highlights

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

### Upgraded Dependencies

Upgraded several dependencies, here amongst Laravel which is now running on `v8.x`.

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
