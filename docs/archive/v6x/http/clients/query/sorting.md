---
description: Sort Results
sidebarDepth: 0
---

# Sorting

In order to request results to be sorted, you can use the `orderBy()` method.
It accepts two arguments:

- `$field`: `string|array` Name of field or key-value pair, where key = field, value = sorting order.
- `$direction`: `string` (_optional_) sorting order, e.g. `asc` or `desc`.

```php
$response = $client
    ->orderBy('name')
    ->orderBy('age', 'desc')
    ->get('/users');
```


 
::: details default
```http
/users?sort=name asc,age desc
```
:::

::: details json api
```http
/users?sort=name,-age
```
:::
 
::: details odata

```
/users?$orderby=name asc,age desc
```
:::

## Via Array
 
You can also use an array as argument. When doing so, the second argument is ignored.

```php
$response = $client
    ->orderBy([
        'name' => 'desc',
        'age',
        'jobs' => 'asc'
    ])
    ->get('/users');
```


 
::: details default
```http
/users?sort=name desc,age asc,jobs asc
```
:::

::: details json api
```http
/users?sort=-name,age,jobs
```
:::
 
::: details odata

```
/users?$orderby=name desc,age asc,jobs asc
```
:::

