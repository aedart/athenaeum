---
description: How to use Laravel Aware-of Helpers
---

# How to use

## Prerequisite

You are either working inside a regular Laravel Application or inside a [Athenaeum Core Application](../../core).

## Example

Imagine that you have a component that depends on Laravel's configuration `Repository`.
To obtain the bound instance, use the `ConfigTrait`.

```php
use Aedart\Support\Helpers\Config\ConfigTrait;

class Box
{
    use ConfigTrait;
    
    // ... remaining not shown ... //
}
```

As soon as you invoke the getter method (_`getConfig()`_), a local reference to the bound `Repository` is obtained from the [Service Container](https://laravel.com/docs/11.x/container).

```php
$box = new Box();

$config = $box->getConfig();
```

You can also specify a custom `Repository`, should you wish it.

```php
$box->setConfig($myCustomRepository);
```
