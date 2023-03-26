# IoC Service Container

The `\Aedart\Container\IoC` is a slightly adapted version of [Laravel's Service Container](https://laravel.com/docs/5.8/container).
Please make sure to read their documentation, before attempting to use this version.

::: tip Info
IoC stands for [Inversion of control](https://en.wikipedia.org/wiki/Inversion_of_control).
:::

## `getInstance()`

Creates or obtains existing Service Container instance.
This method registers the `IoC` as the `app` instance within itself.
Furthermore, the method also ensures to set the container as the "application" instance in [Laravel's Facade](https://laravel.com/docs/5.8/facades).

These additions have been made to make it easier, when working with Laravel components outside a typical Laravel application.

```php
use Aedart\Container\IoC;

$container = IoC::getInstance();
```

## `destroy()`

When you destroy the Service Container, the `destroy()` method will ensure to clear all resolved instances, within the [Facade](https://laravel.com/docs/5.8/facades) component, before removing itself.

```php
$container->destroy();
```

## Onward

For additional information, please review the source code of this component.
