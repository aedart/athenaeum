---
description: How to populate Dto
---

# Populate

To populating your DTO with data, provide the constructor with an array or use the `populate()` method.

::: tip Note
Getters and setter methods are automatically invoked for each property, if available.
:::

## Via constructor

If you are extending the default DTO abstraction, then you can also pass in an array in the constructor.

```php
$person = new Person([
    'name' => 'Carmen Rock',
    'age'  => 25
]);
```

## Via `populate()`

```php
$person->populate([
    'name' => 'Timmy Jones',
    'age'  => 32
]);
```
