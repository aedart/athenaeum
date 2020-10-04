---
description: About the Method Helper
sidebarDepth: 0
---

# Method Helper

The `MethodHelper` offers various function and method utilities.

[[TOC]]

## `makeGetterName()`

Returns a 'getter' method name for given property

```php
use Aedart\Utils\Helpers\MethodHelper;

$method = MethodHelper::makeGetterName('age');

echo $method; // getAge
```

## `makeSetterName()`

Returns a 'setter' method name for given property

```php
use Aedart\Utils\Helpers\MethodHelper;

$method = MethodHelper::makeSetterName('age');

echo $method; // setAge
```

## `callOrReturn()`

Invokes the given method and return it's return value, if possible.
Otherwise, the whatever value was given will be returned instead.

This helper is useful when not knowing if a callable has already been invoked.

```php
use Aedart\Utils\Helpers\MethodHelper;

$callable = function(){
    return 'Hi there';
};

$output = MethodHelper::callOrReturn($callable);

echo $output; // Hi there
```

### When method is not a callable

If given method is not a [`callable`](https://www.php.net/manual/en/language.types.callable.php), then whatever was given will be returned instead.

```php
use Aedart\Utils\Helpers\MethodHelper;

$callable = 'Okay there...';

$output = MethodHelper::callOrReturn($callable);

echo $output; // Okay there...
```

### Passing Arguments

You can state arguments to passed to the callable method, as the second argument.

```php
use Aedart\Utils\Helpers\MethodHelper;

$callable = function(string $name){
    return 'Hi ' . $name;
};

$output = MethodHelper::callOrReturn($callable, [ 'Ryan' ]);

echo $output; // Hi Ryan
```
