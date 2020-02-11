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

When invoked, the method will bind the `Container` as the `app` and set the [`Facade`](https://laravel.com/docs/6.x/facades)'s application instance to be the `Container`.
This will allow you to use other facades and ensure that they are able to resolve their bindings, provided your have bound them inside the service container.

::: danger Warning
**DO NOT USE THIS METHOD** inside your normal Laravel Application. It will highjack the `app` binding, causing all kinds of unexpected behaviour.
The intended purposes of this method is for testing only.
:::

