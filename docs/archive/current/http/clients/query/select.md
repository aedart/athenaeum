---
description: Select Field from Resource
sidebarDepth: 0
---

# Select

Provided that the API you are working with supports such, you may select the "fields" to be returned by a response.
Typically, you would combine a selection of fields with [include](./include.md).

[[TOC]]

## Select a Single Field

The `select()` method allows you to specify what field(s) should be returned.

```php
$response = $client
        ->select('name')
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?select=name
```
:::

::: tab json api
```http
/users?fields[]=name
```
:::
 
::: tab odata
```http
/users?$select=name
```
:::

::::

## Select Field from Resource

You may also specify what resource the given field should be selected from.

```php
$response = $client
        ->select('name', 'friends')
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?select=friends.name
```
:::

::: tab json api
```http
/users?fields[friends]=name
```
:::
 
::: tab odata
```http
/users?$select=friends.name
```
:::

::::

## Select Multiple Fields

To select multiple fields, you can state an array as argument.


```php
$response = $client
        ->select([
            'name' => 'friends',
            'age' => 'friends',
            'job_title' => 'position'
        ])
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?select=friends.name,friends.age,position.job_title
```
:::

::: tab json api
```http
/users?fields[friends]=name,age&fields[position]=job_title
```
:::
 
::: tab odata
```http
/users?$select=friends.name,friends.age,position.job_title
```
:::

::::

## Select Raw Expression

To perform a raw selection, use the `selectRaw()` method.
It accepts a string expression and an optional bindings array.

```php
$response = $client
        ->selectRaw('account(:number)', [ 'number' => 7 ])
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?select=account(7)
```
:::

::: tab json api
```http
/users?fields[]=account(7)
```
:::
 
::: tab odata
```http
/users?$select=account(7)
```
:::

::::
