---
description: How to Register Service Providers
---

# Service Providers

[[TOC]]

## Register Service Providers

Just like within a regular Laravel application, you can register you service providers in the `providers` array, located in your `/configs/app.php`. (_configuration path [can be specified](../integration.md) in your application instance_).

## Register a Laravel Service Provider

When you wish to make use of a Laravel's packages, then simply require the desired package and add the service's class path inside the `providers` array. 
The following example take your though the steps it requires to add Laravel's [Redis Service](https://laravel.com/docs/7.x/redis).

### Require Package

Start off by requiring the package, using composer.

```shell
composer require illuminate/redis
```

### Register `RedisServiceProvider`

In your `/configs/app.php`, add the class path to the Redis service provider.

```php
<?php
return [
    // ... previous not shown ...
    
    'providers' => [
        \Illuminate\Redis\RedisServiceProvider::class
    ],
];
```

### Dealing with Asserts

Many of Laravel's packages depend on configuration files or other assets.
Unfortunately, not all of Laravel's packages have their assets registered as publishable.
This means that you if you would run the `vendor:publish-all` command, nothing would happen.
To resolve this, you can obtain a service's required assets manually, by coping the desired assets from Laravel's [Github Repository](https://github.com/laravel/laravel).

In this example, you are required to copy the `database.php` configuration file, from the [`/configs` directory](https://github.com/laravel/laravel/blob/v6.12.0/config/database.php) and paste into your application's `/configs` directory.
This configuration file contains specific setup for the Redis service.

```php
<?php
return [
    // ... previous not shown ...
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', 'my_application'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        // ... Remaining not shown ...
    ],
];
```

::: warning Caution
Please make sure the assets that you copy, match the required package's version.
Otherwise you risk incompatibility and undesirable behaviour.
:::

### Usage

Once the Redis service has been registered, you can use it within your application.

```php
$redis = $app->make('redis');

$redis->set('my_key', 'my_value');
```

The [next chapter](container) contains more information and examples on how to obtain registered services (_e.g. bindings_).

## Deferred Services

The Athenaeum Core Application also supports [deferred providers](https://laravel.com/docs/7.x/providers#deferred-providers).
Once registered, the services that are marked deferred, will only be registered and booted when required.
Consult yourself with Laravel's [documentation](https://laravel.com/docs/7.x/providers#deferred-providers) for additional information.

## Limitations

Unlike a regular Laravel application, the Athenaeum Core Application does not cache it's resolved list of service providers.
This means that in terms of performance, this application isn't as fast as Laravel.
Currently, there are no plans to offer enhancements of this particular part of the application.
Should this prove to be a problem for you, then consider [extending the Athenaeum Core Application](ext) and overwrite the service provider registration and booting logic. 
