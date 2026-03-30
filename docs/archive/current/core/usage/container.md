---
description: How to use Service Container
---

# Service Container

The Core Application is essentially an extended version of Laravel's [Service Container](https://laravel.com/docs/13.x/container).
It works exactly as you are used to, in your Laravel projects.
This chapter only briefly highlights some of it's major features.
For more saturated examples and information on how to use the Service Container, please review Laravel's [documentation](https://laravel.com/docs/13.x/container). 

[[TOC]]

## Bindings

Inside your Service Provider's `register()` method, you can use the `bind()` method to register a binding.

```php
<?php

use Acme\Contracts\Weather\Temperature\Measurement as MeasurementInterface;
use Acme\Weather\Temperature\Measurement;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MeasurementInterface::class, function($app){
            return new Measurement();
        });
    }
}
```

### When no interfaces are available

The Service Container does not explicitly require you to state an interface's class path, as the "abstract" identifier for your binding.
You can use a regular string value that you wish, as long as it is unique.
Depending on just how "legacy" your application is, this can come very handy for you, should you wish to redesign or refactor certain logic.

```php
$this->app->bind('weather-measurement', function($app){
    return new Measurement();
});
```

### Aliases

Another helpful feature of the Service Container, is the ability to create aliases for your bindings.
This will allow you to resolve a bound instance, via both an interface's class path or your assigned alias. 

```php
$this->app->bind(MeasurementInterface::class, function($app){
    return new Measurement();
});

// "weather-measurement" alias for MeasurementInterface::class
$this->app->alias(MeasurementInterface::class, 'weather-measurement'); 
```

### Singleton Bindings

To bind a single instance, use the `singleton()` method.

```php
<?php

use Acme\Contracts\Weather\Station;
use Acme\Weather\Stations\LondonWeatherGateway;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Station::class, function($app){
            return new LondonWeatherGateway();
        });
    }
}
```

## Resolving

To resolve a binding, use the `make()` method on the application instance.
Given the above shown examples, imagine that you are somewhere inside your legacy application.
To obtain (_resolve_) your desired bound components, use your `$app`.

```php
<?php

use Acme\Contracts\Weather\Station;

// ... somewhere inside your custom application

$weatherStation = $app->make(Station::class);
```

The above example assumes that you are within your entry-point(s), e.g. your `index.php`, and have direct access to your `$app`.
This might not always be the case for you.
In the next few sections, different approaches are explored.

### Using the `App` Facade

You can also resolve your bindings, by using Laravel's `App` [Facade](https://laravel.com/docs/13.x/facades).
This Facade provides access to your application instance, as long as your application is running.
Such can be useful, in situations where you might not have direct access to your `$app`.

```php
<?php

use Acme\Contracts\Weather\Station;
use Illuminate\Support\Facades\App;

// ... somewhere inside your custom application

$weatherStation = App::make(Station::class);
```

::: warning Caution
Depending upon how you use Facades, they can either help you to get the job done or become a hindrance.
You should take some time to read about their conceptual [benefits and limitations](https://laravel.com/docs/13.x/facades#when-to-use-facades).  
:::

### Using the `IoCFacade`

The `IoCFacade` is a custom Facade, which also provides access to your application instance.
Just like Laravel's `App` facade, it too offers the `make()` method.
In addition, it also comes with a `tryMake()` method, which does not fail, in case that a binding could not be resolved.
When a binding cannot be resolved, it returns a default value that you can specify.

```php
<?php

use Acme\Contracts\Weather\Station;
use Acme\Weather\Stations\NullStation;
use Aedart\Support\Facades\IoCFacade;

// ... somewhere inside your custom application

// Either resolves "station" binding or returns a default value.
$weatherStation = IoCFacade::tryMake(Station::class, function(){
    return new NullStation();
});
```

For more information, please review the source code of [`IoCFacade`](https://github.com/aedart/athenaeum/blob/master/packages/Support/src/Facades/IoCFacade.php).

### Inside your Classes

Arguably, when situated inside a class, it is considered best practice to rely on [dependency injection](https://en.wikipedia.org/wiki/Dependency_injection), rather than using Facades.
Given that you have a component with one or more dependencies, you should type-hint them in the component's constructor.
Imagine the following component:

```php
<?php

use Acme\Contracts\Weather\Station;

class WeatherController
{
    protected Station $weatherStation;

    public function __construct(Station $weatherStation)
    {
        $this->weatherStation = $weatherStation;
    }
}
```

When you need to resolve it's dependencies, use the `make()` method.

```php
<?php

// Constructor dependencies are automatically resolved.
$controller = $app->make(WeatherController::class);
```

### Alternative

Another approach to resolving you bindings, is by making use of [Aware-of Helpers](../../support).
These helpers are basically "getters and setters" that come with a default value.
Consider the following example, where a "Weather Station Aware of" helper is available.

```php
<?php

use Acme\Weather\Stations\Traits\StationTrait;
use Psr\Http\Message\ResponseInterface;

class WeatherController
{
    use StationTrait;

    public function index() : ResponseInterface
    {
        // A default station binding resolved from the Service Container.
        $weatherStation = $this->getStation();
    
        // ... remaining not shown ...
    }
}
```

The implementation of a "Weather Station Aware of" helper, could look similar to the following example:

```php
<?php

namespace Acme\Weather\Stations\Traits;

use Acme\Contracts\Weather\Station;
use Aedart\Support\Facades\IoCFacade;

trait StationTrait
{
    protected Station|null $station = null;

    public function setStation(Station|null $station): static
    {
        $this->station = $station;
        
        return $this;
    }
    
    public function getStation(): Station|null
    {
        if( ! $this->hasStation()){
            $this->setStation($this->getDefaultStation());
        }
        return $this->station;
    }
    
    public function hasStation(): bool
    {
        return isset($this->station);
    }
    
    public function getDefaultStation(): Station|null
    {
        return IoCFacade::tryMake(Station::class);
    }
}
```

The benefit of using an "Aware-of" Helper approach, is that your component(s) can "lazy" resolve their dependencies.
Furthermore, you always have the possibility to overwrite its methods, meaning that a different implementation could be returned as a default, should you require such.


In any case, you have the freedom to choose how, if at all, you wish to resolve dependencies in your custom application.
