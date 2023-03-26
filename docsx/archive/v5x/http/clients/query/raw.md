---
description: Raw Expressions
sidebarDepth: 0
---

# Raw Expressions

Unlike `selectRaw()`, `whereRaw()` or other equivalent methods, `raw()` allows you to add an expression, without prefixing, affixing or in other ways process the added expression.   
The method will, however, inject binding values into the provided expression, if any are given.

::: tip Note
Raw expressions added via `raw()` will always be added at the end of the final assembled http query string, regardless of the order stated via the builder.
:::

## Arguments

`raw()` accepts the following arguments:

- `$expression`: `string` the raw expression
- `$bindings`: `array` (_optional_) binding values

## Example

```php
$response = $client
        ->raw('search=person from (:list)', [ 'list' => 'a,b,c' ])
        ->get('/users');
```


:::: tabs
 
::: tab default
```http
/users?search=person from (a,b,c)
```
:::

::: tab json api

**Caution**: _Produced http query is not in accordance with Json API recommendations._

```http
/users?search=person from (a,b,c)
```
:::
 
::: tab odata

**Caution**: _Produced http query is not a valid OData query._

```
/users?search=person from (a,b,c)
```
:::

::::
