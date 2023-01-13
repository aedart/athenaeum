---
description: About the Invoker Helper
sidebarDepth: 0
---

# Invoker

A utility for invoking callbacks, with an optional fallback callback.
This helper is intended for situations when you dynamically are building a callback, to be executed at a later point.

[[TOC]]

## Basic Example 

```php
use \Aedart\Utils\Helpers\Invoker;

$callback = function () {
    return true;
};

$invoker = Invoker::invoke($callback);

// ...Later in your application
echo $invoker->call(); // true
```

## Arguments

To provide arguments, use the `with()` method.

```php
use \Aedart\Utils\Helpers\Invoker;

$invoker = Invoker::invoke($callback)
    ->with(1, 2, 3);
```

## Fallback

You may also specify a fallback callback, in case that the core callback is not [`callable`](https://www.php.net/manual/en/function.is-callable).

**Note**: _Any arguments that are provided via `width()` are passed on to the fallback callback, if "core" callback is not callable!_

```php
use \Aedart\Utils\Helpers\Invoker;

$unknownCallback = null; // Edge-case

$invoker = Invoker::invoke($unknownCallback)
    ->fallback(function() {
        // E.g. do something else if "core" callback is not callable...
        throw new \RuntimeException('No callback provided');
    });

// ...Later in your application
echo $invoker->call(); // throws exception
```

## Caveat

::: warning
If neither the "core" callback nor fallback are [`callable`](https://www.php.net/manual/en/function.is-callable), then the invoker component will throw a `RuntimeException` when invoked.
:::

```php
use \Aedart\Utils\Helpers\Invoker;

$callback = null;
$fallback = null

// Throws RuntimeException
$result = Invoker::invoke($callback)
    ->fallback($fallback)
    ->call();
```
