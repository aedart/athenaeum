---
description: How to extend the Athenaeum Core Application
---

# Extending Core Application

In this chapter, you will find a few hints if you choose to extend the Core Application.

[[TOC]]

## Core Service Providers

As soon as you instantiate a new Application instance, it's core service providers are registered - _but NOT booted!_
Some of these service providers are very essential and the application might not work as expected, without them.
Should you wish to adapt the list of core service providers, overwrite the `getCoreServiceProviders()` method.

```php
use Aedart\Core\Application;

class AcmeApplication extends Application
{
    public function getCoreServiceProviders(): array
    {
        return [
            CoreServiceProvider::class,
            ExceptionHandlerServiceProvider::class,
            NativeFilesystemServiceProvider::class,
            EventServiceProvider::class,
            ListenersViaConfigServiceProvider::class,
            ConfigServiceProvider::class,
            ConfigLoaderServiceProvider::class,
    
            // ... etc
        ];
    }
    
    // ... remaining not shown ...   
}
```

## Core Bootstrappers

A "bootstrapper" is a component that is able to perform some kind of "initial startup" logic.
It is what sets the entire application in motion.
Bootstrappers are processed when you invoke the `bootstrapWith()` method (_automatically invoked by the application's `run()` method_).
Furthermore, they are _processed after the core service providers have registered!_

```php
$app->run(); // All bootstrappers are processed...
```

### Create Custom Bootstrapper

To create your own custom bootstrapper, you need to implement the `CanBeBootstrapped` interface.
The following examples shows a very simple bootstrapper, which is used to set the default timezone.

```php{6}
<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Support\Helpers\Config\ConfigTrait;

class SetDefaultTimezone implements CanBeBootstrapped
{
    use ConfigTrait;

    public function bootstrap(Application $application): void
    {
        date_default_timezone_set($this->getConfig()->get('app.timezone', 'UTC'));
    }
}
```

### Overwrite Core Bootstrappers

To use your custom bootstrappers, you need to overwrite the `getCoreBootstrappers()` method.
Similar to the `getCoreServiceProviders()` method, this method returns an order list of class paths to the application's bootstrappers.

```php
use Aedart\Core\Application;

class AcmeApplication extends Application
{
    public function getCoreBootstrappers(): array
    {
        return [
            DetectAndLoadEnvironment::class,
            LoadConfiguration::class,
            SetDefaultTimezone::class,
            SetExceptionHandling::class,
    
            // ... etc
        ];
    }
    
    // ... remaining not shown ...   
}
```

## Application is a Service Container

Just like Laravel's Foundation Application, the Athenaeum Core Application extends the [Service Container](https://laravel.com/docs/10.x/container).
This means that, you can gain access to services and components.
_But not before those service have been registered!_

```php
// Somewhere inside your extended Core Application
$config = $this->make('config'); // Might fail, if Config Service hasn't registered!
```

It is advisable that you keep your logic simple.
If possible, try to encapsulate your needs into either service providers or bootstrappers.
Otherwise, you risk of adding too much complexity, inside the actual application.
