---
description: How to use Service Registrar
---

# How to use

## Prerequisite

To use the Service Registrar, you **MUST** have an application instance available.
The application **MUST** implement (_or inherit from_) `\Illuminate\Contracts\Foundation\Application`.

The [Athenaeum Core Application](../core) meets this criteria.

## Create instance

```php
use \Aedart\Service\Registrar;

$registrar = new Registrar($application);
```

## Register a Single Service Provider

Use the `register()` method to register a single Service Provider.
The method accepts a class path or instance, as it's first argument.

```php
use \Acme\Warehouse\Providers\StockServiceProvider;
use \Acme\Warehouse\Providers\TruckServiceProvider;

$registrar->register(StockServiceProvider::class);

// Or...

$registrar->register(new TruckServiceProvider($application));
```

## Register Multiple Service Providers

The `registerMultiple()` allows you to register multiple Service Providers.
Just like the `register()` method, it accepts class paths or instances.

```php
$registrar->registerMultiple([
    // Class paths
    \Acme\Warehouse\Providers\StockServiceProvider::class,
    \Acme\Employees\Providers\EmployeesServiceProvider::class,
    
    // Can also register instance
    new \Acme\Warehouse\Providers\StockServiceProvider($application),
]);
```

## Boot 

The `bootAll()` method can be used to boot all Service Providers that have yet to be booted.
See [Laravel's documentation](https://laravel.com/docs/9.x/providers#the-boot-method) for additional information about the boot method.

```php
$registrar->bootAll();
```

::: tip Note
If you choose to register additional providers, after already registered providers have been booted, then those newly registered will automatically be booted.
Should this behaviour not suit your needs, then you can always disable booting during registration, via the `$boot` argument for the `regsiter()` method.
The same is true for the `registerMultiple()` method.

```php
// Register but do not boot
$registrar->register(MyServiceProvider::class, false);
```

Later, you can always invoke `bootAll()` to boot those providers that have yet to be booted.

See source code for additional information.
:::
