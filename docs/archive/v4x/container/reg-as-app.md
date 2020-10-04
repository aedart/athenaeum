---
description: Register Container as Application
---

# `registerAsApplication()`

Sometimes, when testing your custom Laravel components and services, it can be useful to "trick" them in believing that the `Container` is the `Application`.
This can be achieved via the `registerAsApplication()`.

```php
use \Aedart\Container\IoC;

$ioc = IoC::getInstance();
$ioc->registerAsApplication();
```

When invoked, the method will bind the `IoC` as the `app` (_Laravel Application_). It will also set the [`Facade`](https://laravel.com/docs/7.x/facades)'s application instance to be the `IoC`.
This will allow you to use other facades and ensure that they are able to resolve their bindings, provided your have bound them inside the service container.

::: danger Warning
**DO NOT USE THIS METHOD** inside your normal Laravel Application. It will highjack the `app` binding, causing all kinds of unexpected and undesirable behaviour.
The intended purposes of this method is **for testing only!**

#### Why is this available?

Sometimes it's a bit faster to test certain components, without having a full Laravel Application up and running.
This can for instance be [Facades](https://laravel.com/docs/7.x/facades) or a custom [Service Provider's boot method](https://laravel.com/docs/7.x/providers#the-boot-method).
However, using this method when the `IoC` is not a superclass to a Laravel [`Application`](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php), is **considered to be hack!**

Be careful how you choose to make use of this, if at all!
:::

