---
description: How to setup Circuits
---

# Setup

[[TOC]]

## Register Service Provider

Register `CircuitBreakerServiceProvider` inside your `configs/app.php`. 

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Circuits\Providers\CircuitBreakerServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets

Run `vendor:publish` to publish package's assets.

```shell
php artisan vendor:publish
```

Once completed, the following configuration file should be available inside your `configs/` directory:

- `circuit-breakers`

### Publish Assets for Athenaeum Core Application

When using [Athenaeum Core Application](../../core), run `vendor:publish-all` to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

The `configs/circuit-breakers.php` configuration file, is intended to contain a list of "services".
Each service has a list of settings (_options_) for it's corresponding circuit breaker instance.
Add or change these settings as you see fit.

```php
<?php

return [

    'services' => [

        'weather_service' => [

            /*
             * Name of store to use
             */
            'store' => 'default',

            /*
             * Maximum amount of times that a callback should
             * be attempted
             */
            'retries' => 3,

            /*
             * Amount of milliseconds to wait before each attempt
             */
            'delay' => 100,

            /*
             * Maximum amount of failures before circuit breaker
             * must trip (change state to "open")
             */
            'failure_threshold' => 10,

            /*
             * Grace period duration.
             *
             * The amount of seconds to wait before circuit breaker can
             * attempt to change state to "half open", after failure
             * threshold has been reached.
             */
            'grace_period' => 10,

            /*
             * Timezone
             */
            'timezone' => env('TIMEZONE', 'UTC'),

            /*
             * Time-to-live (ttl) for a state
             *
             * Duration in seconds. When none given, it defaults to
             * store's ttl.
             */
            'state_ttl' => null,
        ]
    ],

    // ... remaining not shown ...
];
```

### Store Configuration

Each Circuit Breaker uses a `Store` to keep track of it's state (_closed, open, half-open_).
In your configuration, you can specify the profile-name of the store to use.
Additional store configuration can be specified in your configuration file (`configs/circuit-breakers.php`).

::: warning
Currently, only cache stores that inherit from [`LockProvider`](https://laravel.com/docs/7.x/cache#atomic-locks) can be used.
:::

```php
<?php

return [
    // ... previous not shown ...

    /*
    |--------------------------------------------------------------------------
    | Stores
    |--------------------------------------------------------------------------
    */

    'stores' => [

        'default' => [
            'driver' => \Aedart\Circuits\Stores\CacheStore::class,
            'options' => [

                /*
                 * Name of Laravel Cache Store to use
                 *
                 * WARNING: Cache Store MUST inherit from LockProvider or
                 * it cannot be used.
                 *
                 * @see \Illuminate\Contracts\Cache\LockProvider
                 */
                'cache-store' => 'redis',

                /*
                 * Default time-to-live (ttl) for a state.
                 */
                'ttl' => 3600,
            ]
        ]
    ]
];
```

