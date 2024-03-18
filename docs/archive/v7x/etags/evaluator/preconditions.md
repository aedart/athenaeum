---
description: Preconditions
sidebarDepth: 0
---

# Preconditions

At the heart of the `Evaluator` are the preconditions that can be evaluated, when a request contain such.
They are responsible for invoking appropriate [actions](actions.md), if applicable, whenever they pass or fail.

[[TOC]]

## Supported Preconditions

Unless otherwise specified, the following preconditions are enabled by default in the `Evaluator`.

### RFC 9110

* [If-Match](./rfc9110/if-match.md)
* [If-Unmodified-Since](./rfc9110/if-unmodified-since.md)
* [If-None-Match](./rfc9110/if-none-match.md)
* [If-Modified-Since](./rfc9110/if-modified-since.md)
* [If-Range](./rfc9110/if-range.md)

### Extensions

* [Range](./extensions/range.md)

## Disable Extensions

If you do not wish to allow any other kind of preconditions evaluation than those defined by RFC 9110, then you can invoke the `useRfc9110Preconditions()` method.

```php
$evaluator->useRfc9110Preconditions();
```

## Specify Preconditions

::: tip Order of precedence
All preconditions are evaluated in the order that they are given.
This means that the default are evaluated in accordance with [RFC 9110's order of precedence](https://httpwg.org/specs/rfc9110.html#precedence).
:::

To specify what preconditions can be evaluated, set the `$preconditions` argument in the `make()` method. Or, use the `setPreconditions()` method.

```php
// When creating a new instance...
$evaluator = Evaluator::make(
    request: $request,
    preconditions: [
        MyCustomPreconditionA::class,
        new OtherCustomPrecontion()
    ],
);

// Or, when after instance has been instantiated
$evaluator->setPreconditions([
    MyCustomPreconditionA::class,
    new OtherCustomPrecontion()
]);
```

Alternatively, if you wish to add a custom precondition to be evaluated after those that are already set (_e.g. the default preconditions_), then use the `addPrecondition()` method.
Just like when set custom preconditions, the method accepts a string class path or precondition instance as argument.

```php
$evaluator->addPrecondition(new MyCustomPrecondition());
```

## Custom Preconditions

See [extensions](extensions/README.md) for more information.