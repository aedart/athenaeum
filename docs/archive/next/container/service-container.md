---
description: About the IoC Service Container
---

# Container

The `\Aedart\Container\IoC` is a slightly adapted version of [Laravel's Service Container](https://laravel.com/docs/9.x/container).
Please make sure to read their documentation, before attempting to use this version.

::: tip Info
IoC stands for [Inversion of control](https://en.wikipedia.org/wiki/Inversion_of_control).
:::

The motivation behind this adaptation is development outside a normal Laravel Application.
E.g. testing and development of Laravel dependent packages.
In other words, you will most likely not find this useful within your Laravel Application!

[[toc]]

## How to obtain instance

To obtain the instance of the IoC Service Container, use the `getInstance()` method.

```php
use \Aedart\Container\IoC;

$ioc = IoC::getInstance();
```

## `registerAsApplication()`

Sometimes, when testing your custom Laravel components and services, it can be useful to "trick" them in believing that the `Container` is the `Application`.
This can be achieved via the `registerAsApplication()`.

```php
$ioc->registerAsApplication();
```

When invoked, the method will bind the `IoC` as the `app` (_Laravel Application_). It will also set the [`Facade`](https://laravel.com/docs/9.x/facades)'s application instance to be the `IoC`.
This will allow you to use other facades and ensure that they are able to resolve their bindings, provided your have bound them inside the service container.

::: danger Warning
**DO NOT USE THIS METHOD** inside your normal Laravel Application. It will highjack the `app` binding, causing all kinds of unexpected and undesirable behaviour.
The intended purposes of this method is **for testing only!**

#### Why is this available?

Sometimes it's a bit faster to test certain components, without having a full Laravel Application up and running.
This can for instance be [Facades](https://laravel.com/docs/9.x/facades) or a custom [Service Provider's boot method](https://laravel.com/docs/9.x/providers#the-boot-method).
However, using this method when the `IoC` is not a superclass to a Laravel [`Application`](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php), is **considered to be hack!**

Be careful how you choose to make use of this, if at all!
:::

## `destroy()`

This method ensures that all bindings are unset, including those located within the [`Facade`](https://laravel.com/docs/9.x/facades).
In addition, when invoked the `Facade`'s application is also unset.

```php
// ...destroy ioc and all of it's bindings.
$ioc->destroy();
```
